<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\SavedCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Show card payment form
     */
    public function showCardPayment($orderId)
    {
        $order = Order::with('orderItems.product')
            ->where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($order->payment_status === 'paid') {
            return redirect()->route('users.orders.show', $order)
                ->with('info', 'Энэ захиалгын төлбөр аль хэдийн төлөгдсөн байна.');
        }

        return view('users.payment.card', compact('order'));
    }

    /**
     * Process card payment
     */
    public function processCardPayment(Request $request, $orderId)
    {
        $validated = $request->validate([
            'card_number'   => 'required|digits:16',
            'card_holder'   => 'required|string|max:100',
            'expiry_month'  => 'required|digits:2',
            'expiry_year'   => 'required|digits:4',
            'cvv'           => 'required|digits:3',
            'save_card'     => 'nullable|boolean',
        ], [
            'card_number.required'  => 'Картын дугаар оруулна уу.',
            'card_number.digits'    => 'Картын дугаар 16 оронтой байх ёстой.',
            'card_holder.required'  => 'Картын эзэмшигчийн нэр оруулна уу.',
            'expiry_month.required' => 'Дуусах сар оруулна уу.',
            'expiry_year.required'  => 'Дуусах жил оруулна уу.',
            'cvv.required'          => 'CVV код оруулна уу.',
            'cvv.digits'            => 'CVV код 3 оронтой байх ёстой.',
        ]);

        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($order->payment_status === 'paid') {
            return back()->with('info', 'Энэ захиалгын төлбөр аль хэдийн төлөгдсөн байна.');
        }

        DB::beginTransaction();

        try {
            // Simulate payment processing (in real scenario, call payment gateway API)
            $isPaymentSuccessful = $this->simulateCardPayment($validated);

            if ($isPaymentSuccessful) {
                // Create payment record
                $payment = Payment::create([
                    'order_id'          => $order->id,
                    'payment_method'    => 'credit_card',
                    'status'            => 'completed',
                    'amount'            => $order->total_amount,
                    'transaction_id'    => 'TXN-' . Str::upper(Str::random(12)),
                    'reference_number'  => 'REF-' . now()->format('YmdHis'),
                    'response_data'     => [
                        'card_last4' => substr($validated['card_number'], -4),
                        'card_holder' => $validated['card_holder'],
                    ],
                    'paid_at'           => now(),
                ]);

                // Save card if user opted in
                if ($request->save_card) {
                    $cardLastFour = substr($validated['card_number'], -4);

                    // Check if card already exists
                    $existingCard = Auth::user()->savedCards()
                        ->where('card_last_four', $cardLastFour)
                        ->where('expiry_month', $validated['expiry_month'])
                        ->where('expiry_year', $validated['expiry_year'])
                        ->first();

                    if (!$existingCard) {
                        Auth::user()->savedCards()->create([
                            'card_holder' => $validated['card_holder'],
                            'card_last_four' => $cardLastFour,
                            'card_brand' => $this->detectCardBrand($validated['card_number']),
                            'expiry_month' => $validated['expiry_month'],
                            'expiry_year' => $validated['expiry_year'],
                            'is_default' => Auth::user()->savedCards()->count() === 0, // First card is default
                        ]);
                    }
                }

                // Update order status
                $order->update([
                    'status'         => 'paid',
                    'payment_status' => 'paid',
                ]);

                DB::commit();

                return redirect()->route('users.orders.show', $order)
                    ->with('success', 'Төлбөр амжилттай төлөгдлөө! Захиалгын дугаар: ' . $order->order_number);
            } else {
                // Payment failed
                Payment::create([
                    'order_id'       => $order->id,
                    'payment_method' => 'credit_card',
                    'status'         => 'failed',
                    'amount'         => $order->total_amount,
                    'response_data'  => ['error' => 'Payment declined by bank'],
                ]);

                $order->update([
                    'status' => 'failed',
                ]);

                DB::commit();

                return back()->withErrors(['error' => 'Төлбөр амжилтгүй боллоо. Картын мэдээллээ шалгана уу.']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Төлбөр төлөхөд алдаа гарлаа: ' . $e->getMessage()]);
        }
    }

    /**
     * Simulate card payment (replace with real payment gateway)
     */
    private function simulateCardPayment($cardData)
    {
        // In production, integrate with Stripe, PayPal, or local payment gateway
        // For demo: accept if card doesn't start with '4000'
        return !str_starts_with($cardData['card_number'], '4000');
    }

    /**
     * Detect card brand from card number
     */
    private function detectCardBrand($cardNumber)
    {
        $firstDigit = substr($cardNumber, 0, 1);
        $firstTwoDigits = substr($cardNumber, 0, 2);

        if ($firstDigit === '4') {
            return 'Visa';
        } elseif (
            in_array($firstTwoDigits, ['51', '52', '53', '54', '55']) ||
            (intval($firstTwoDigits) >= 22 && intval($firstTwoDigits) <= 27)
        ) {
            return 'Mastercard';
        } elseif (in_array($firstTwoDigits, ['34', '37'])) {
            return 'American Express';
        } elseif ($firstTwoDigits === '62') {
            return 'UnionPay';
        } elseif (
            in_array(substr($cardNumber, 0, 4), ['6011']) ||
            (intval($firstTwoDigits) >= 64 && intval($firstTwoDigits) <= 65)
        ) {
            return 'Discover';
        }

        return null;
    }
}
