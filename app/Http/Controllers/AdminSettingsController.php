<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display settings page
     */
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        $settings = Setting::all()->groupBy('group');

        return view('admin.settings', compact('admin', 'settings'));
    }

    /**
     * Update profile settings
     */
    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . Auth::guard('admin')->id(),
        ], [
            'name.required' => 'Нэр заавал оруулна уу.',
            'email.required' => 'Имэйл заавал оруулна уу.',
            'email.unique' => 'Энэ имэйл бүртгэгдсэн байна.',
        ]);

        $admin = Auth::guard('admin')->user();
        $admin->update($validated);

        return redirect()->back()->with('success', 'Профайл амжилттай шинэчлэгдлээ');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ], [
            'password.required' => 'Нууц үг оруулна уу.',
            'password.min' => 'Нууц үг багадаа 6 тэмдэгт байх ёстой.',
            'password.confirmed' => 'Нууц үг таарчхгүй байна.',
        ]);

        $admin = Auth::guard('admin')->user();
        $admin->update(['password' => Hash::make($validated['password'])]);

        return redirect()->back()->with('success', 'Нууц үг амжилттай солигдлоо');
    }

    /**
     * Update store settings
     */
    public function updateStore(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_email' => 'required|email',
            'site_phone' => 'required|string|max:20',
            'site_address' => 'required|string|max:500',
            'currency' => 'required|string|max:10',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // Handle logo upload
            if ($request->hasFile('logo')) {
                $oldLogo = setting('logo_path');
                if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                    Storage::disk('public')->delete($oldLogo);
                }

                $logoPath = $request->file('logo')->store('logos', 'public');
                Setting::set('logo_path', $logoPath, 'site');
            }

            // Update other settings
            Setting::set('site_name', $validated['site_name'], 'site');
            Setting::set('site_email', $validated['site_email'], 'site');
            Setting::set('site_phone', $validated['site_phone'], 'site');
            Setting::set('site_address', $validated['site_address'], 'site');
            Setting::set('currency', $validated['currency'], 'site');

            DB::commit();
            return redirect()->back()->with('success', 'Тохиргоо амжилттай шинэчлэгдлээ');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Алдаа гарлаа: ' . $e->getMessage()]);
        }
    }

    /**
     * Update payment settings
     */
    public function updatePayment(Request $request)
    {
        $validated = $request->validate([
            'card_enabled' => 'required|boolean',
            'qpay_enabled' => 'required|boolean',
            'bank_transfer_enabled' => 'required|boolean',
        ]);

        Setting::set('card_enabled', $validated['card_enabled'] ? '1' : '0', 'payment');
        Setting::set('qpay_enabled', $validated['qpay_enabled'] ? '1' : '0', 'payment');
        Setting::set('bank_transfer_enabled', $validated['bank_transfer_enabled'] ? '1' : '0', 'payment');

        // Backward compatibility for old cash-on-delivery setting
        Setting::set('cod_enabled', $validated['qpay_enabled'] ? '1' : '0', 'payment');

        Setting::clearCache();

        return redirect()->back()->with('success', 'Төлбөрийн тохиргоо амжилттай шинэчлэгдлээ');
    }

    /**
     * Update order settings
     */
    public function updateOrder(Request $request)
    {
        $validated = $request->validate([
            'order_auto_pending' => 'required|boolean',
            'free_shipping_threshold' => 'required|numeric|min:0',
            'allow_refund' => 'required|boolean',
        ]);

        Setting::set('order_auto_pending', $validated['order_auto_pending'] ? '1' : '0', 'order');
        Setting::set('free_shipping_threshold', $validated['free_shipping_threshold'], 'order');
        Setting::set('allow_refund', $validated['allow_refund'] ? '1' : '0', 'order');

        Setting::clearCache();

        return redirect()->back()->with('success', 'Захиалгын тохиргоо амжилттай шинэчлэгдлээ');
    }

    /**
     * Update security settings
     */
    public function updateSecurity(Request $request)
    {
        $validated = $request->validate([
            'admin_email_notifications' => 'required|boolean',
            'maintenance_mode' => 'required|boolean',
        ]);

        Setting::set('admin_email_notifications', $validated['admin_email_notifications'] ? '1' : '0', 'security');
        Setting::set('maintenance_mode', $validated['maintenance_mode'] ? '1' : '0', 'security');

        Setting::clearCache();

        return redirect()->back()->with('success', 'Аюулгүй байдлын тохиргоо амжилттай шинэчлэгдлээ');
    }
}
