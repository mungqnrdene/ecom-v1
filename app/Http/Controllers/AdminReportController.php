<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display reports page with period filter
     */
    public function index(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $periodType = $request->input('period', '10_days'); // '10_days' or 'monthly'

        // Calculate date ranges
        if ($periodType === 'monthly') {
            $startDate = now()->startOfMonth();
            $endDate = now()->endOfMonth();
        } else {
            $startDate = now()->subDays(9)->startOfDay();
            $endDate = now()->endOfDay();
        }

        // Generate report data
        $reportData = $this->generateReportData($startDate, $endDate);

        // Save to database (create or update current period report)
        $report = Report::updateOrCreate(
            [
                'period_type' => $periodType,
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
            ],
            $reportData
        );

        return view('admin.reports', compact('admin', 'periodType', 'startDate', 'endDate', 'reportData', 'report'));
    }

    /**
     * Generate report data for given period
     */
    private function generateReportData($startDate, $endDate)
    {
        // New users
        $newUsersCount = User::whereBetween('created_at', [$startDate, $endDate])->count();

        // Orders
        $orders = Order::whereBetween('created_at', [$startDate, $endDate])->get();
        $totalOrdersCount = $orders->count();
        $totalSalesAmount = $orders->sum('total_amount');

        // Daily orders breakdown
        $dailyOrders = [];
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $dateStr = $currentDate->format('Y-m-d');
            $dailyOrders[$dateStr] = Order::whereDate('created_at', $currentDate)->count();
            $currentDate->addDay();
        }

        // Refunds
        $refundedOrders = Order::whereBetween('created_at', [$startDate, $endDate])
            ->whereNotNull('refunded_at')
            ->get();
        $refundedOrdersCount = $refundedOrders->count();
        $refundedAmount = $refundedOrders->sum('total_amount');

        // Sold products
        $soldProducts = OrderItem::whereHas('order', function ($q) use ($startDate, $endDate) {
            $q->whereBetween('created_at', [$startDate, $endDate])
                ->where('status', '!=', 'refunded');
        })
            ->with('product')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->product_name ?? $item->product->name ?? 'Unknown',
                    'price' => $item->price_at_purchase,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->subtotal,
                    // ⭐ ШИНЭЭР НЭМСЭН ХЭСЭГ
                    'image_url' => $item->product && $item->product->image
                        ? asset('storage/' . $item->product->image)
                        : null,
                ];
            })
            ->toArray();

        return [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'new_users_count' => $newUsersCount,
            'total_orders_count' => $totalOrdersCount,
            'total_sales_amount' => $totalSalesAmount,
            'refunded_orders_count' => $refundedOrdersCount,
            'refunded_amount' => $refundedAmount,
            'daily_orders' => $dailyOrders,
            'sold_products' => $soldProducts,
        ];
    }

    /**
     * Export 10 days report (CSV)
     */
    public function export10Days()
    {
        $startDate = now()->subDays(9)->startOfDay();
        $endDate = now()->endOfDay();

        return $this->exportReport('10_days', $startDate, $endDate);
    }

    /**
     * Export monthly report (CSV)
     */
    public function exportMonthly()
    {
        $startDate = now()->startOfMonth();
        $endDate = now()->endOfMonth();

        return $this->exportReport('monthly', $startDate, $endDate);
    }

    /**
     * Export report as CSV
     */
    private function exportReport($periodType, $startDate, $endDate)
    {
        $reportData = $this->generateReportData($startDate, $endDate);

        $filename = "report_{$periodType}_" . now()->format('Y-m-d_His') . ".csv";

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($reportData, $startDate, $endDate) {
            $file = fopen('php://output', 'w');

            // BOM for UTF-8
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header
            fputcsv($file, ['БОРЛУУЛАЛТЫН ТАЙЛАН']);
            fputcsv($file, ['Хугацаа', $startDate->format('Y-m-d') . ' - ' . $endDate->format('Y-m-d')]);
            fputcsv($file, []);

            // Summary
            fputcsv($file, ['НИЙТ ҮЗҮҮЛЭЛТҮҮД']);
            fputcsv($file, ['Шинэ хэрэглэгч', $reportData['new_users_count']]);
            fputcsv($file, ['Нийт захиалга', $reportData['total_orders_count']]);
            fputcsv($file, ['Нийт борлуулалт', number_format($reportData['total_sales_amount'], 2)]);
            fputcsv($file, ['Буцаагдсан захиалга', $reportData['refunded_orders_count']]);
            fputcsv($file, ['Буцаагдсан дүн', number_format($reportData['refunded_amount'], 2)]);
            fputcsv($file, []);

            // Daily orders
            fputcsv($file, ['ӨДРӨӨР ЗАДЛАСАН ЗАХИАЛГА']);
            fputcsv($file, ['Огноо', 'Захиалгын тоо']);
            foreach ($reportData['daily_orders'] as $date => $count) {
                fputcsv($file, [$date, $count]);
            }
            fputcsv($file, []);

            // Sold products
            fputcsv($file, ['ЗАРАГДСАН БАРАА']);
            fputcsv($file, ['Нэр', 'Үнэ', 'Тоо', 'Нийт']);
            foreach ($reportData['sold_products'] as $product) {
                fputcsv($file, [
                    $product['name'],
                    number_format($product['price'], 2),
                    $product['quantity'],
                    number_format($product['subtotal'], 2),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export users report
     */
    public function exportUsers(Request $request)
    {
        $period = $request->input('period', '10_days');

        if ($period === 'monthly') {
            $startDate = now()->startOfMonth();
            $endDate = now()->endOfMonth();
        } else {
            $startDate = now()->subDays(9)->startOfDay();
            $endDate = now()->endOfDay();
        }

        $users = User::whereBetween('created_at', [$startDate, $endDate])->get();

        $filename = "users_{$period}_" . now()->format('Y-m-d_His') . ".csv";

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($users) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, ['ШИНЭ ХЭРЭГЛЭГЧИД']);
            fputcsv($file, ['ID', 'Нэр', 'Имэйл', 'Бүртгүүлсэн огноо']);

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export orders report
     */
    public function exportOrders(Request $request)
    {
        $period = $request->input('period', '10_days');

        if ($period === 'monthly') {
            $startDate = now()->startOfMonth();
            $endDate = now()->endOfMonth();
        } else {
            $startDate = now()->subDays(9)->startOfDay();
            $endDate = now()->endOfDay();
        }

        $orders = Order::with('user')->whereBetween('created_at', [$startDate, $endDate])->get();

        $filename = "orders_{$period}_" . now()->format('Y-m-d_His') . ".csv";

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($orders) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, ['ЗАХИАЛГУУД']);
            fputcsv($file, ['Дугаар', 'Хэрэглэгч', 'Нийт дүн', 'Статус', 'Огноо']);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->order_number,
                    $order->user->name ?? 'N/A',
                    number_format($order->total_amount, 2),
                    $order->status,
                    $order->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export refunds report
     */
    public function exportRefunds(Request $request)
    {
        $period = $request->input('period', '10_days');

        if ($period === 'monthly') {
            $startDate = now()->startOfMonth();
            $endDate = now()->endOfMonth();
        } else {
            $startDate = now()->subDays(9)->startOfDay();
            $endDate = now()->endOfDay();
        }

        $refunds = Order::with('user')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNotNull('refunded_at')
            ->get();

        $filename = "refunds_{$period}_" . now()->format('Y-m-d_His') . ".csv";

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($refunds) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, ['БУЦААЛТ']);
            fputcsv($file, ['Захиалгын дугаар', 'Хэрэглэгч', 'Буцаагдсан дүн', 'Буцаасан огноо']);

            foreach ($refunds as $refund) {
                fputcsv($file, [
                    $refund->order_number,
                    $refund->user->name ?? 'N/A',
                    number_format($refund->total_amount, 2),
                    $refund->refunded_at ? $refund->refunded_at->format('Y-m-d H:i:s') : 'N/A',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
