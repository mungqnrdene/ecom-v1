<?php

namespace App\Http\Controllers;

use App\Models\Otp;
use App\Models\User;
use App\Notifications\OtpCodeNotification;
use App\Support\Concerns\HandlesAuthIdentifiers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OtpController extends Controller
{
    use HandlesAuthIdentifiers;

    public function request(Request $request)
    {
        $validated = $request->validate([
            'identifier' => 'required|string|max:255',
        ]);

        $resolved = $this->resolveIdentifier($validated['identifier']);
        $user = User::where($resolved['field'], $resolved['value'])->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'identifier' => 'Ийм хэрэглэгч олдсонгүй.',
            ]);
        }

        $throttleKey = sprintf('otp-request:%s', $resolved['value']);
        $this->ensureNotRateLimited($throttleKey, 3, 'identifier');

        $code = (string) random_int(100000, 999999);

        Otp::updateOrCreate(
            ['identifier' => $resolved['value']],
            [
                'code'       => Hash::make($code),
                'expires_at' => now()->addMinutes($this->otpExpiryMinutes()),
                'used_at'    => null,
            ]
        );

        RateLimiter::hit($throttleKey);

        if ($resolved['field'] === 'email' && $user->email) {

            if (app()->environment('local', 'testing')) {
                \Log::info('===== OTP DEBUG =====');
                \Log::info('Identifier: ' . $user->email);
                \Log::info('OTP CODE: ' . $code);
                \Log::info('=====================');
            } else {
                $user->notify(
                    new OtpCodeNotification($code, $this->otpExpiryMinutes())
                );
            }
        }

        if ($resolved['field'] === 'phone' || app()->environment('local', 'testing')) {
            Log::info('OTP code generated', [
                'identifier' => $resolved['value'],
                'code'       => $code,
            ]);
        }

        $request->session()->put([
            'otp_identifier'         => $resolved['value'],
            'otp_identifier_display' => $this->displayIdentifier($user, $resolved['field']),
            'otp_verified'           => false,
        ]);

        return redirect()->route('otp.verify.form')->with('status', 'OTP код илгээгдлээ. 10 минутын дотор оруулна уу.');
    }

    public function showVerifyForm(Request $request)
    {
        if (!$request->session()->has('otp_identifier')) {
            return redirect()->route('users.password.request')->withErrors([
                'identifier' => 'Эхлээд OTP код авах хүсэлт илгээнэ үү.',
            ]);
        }

        return view('users.auth.verify-otp', [
            'identifier' => $request->session()->get('otp_identifier_display'),
            'status'     => session('status'),
        ]);
    }

    public function verify(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|digits:6',
        ]);

        $identifier = $request->session()->get('otp_identifier');

        if (!$identifier) {
            return redirect()->route('users.password.request')->withErrors([
                'identifier' => 'OTP хүсэлтийг дахин илгээнэ үү.',
            ]);
        }

        $throttleKey = sprintf('otp-verify:%s', $identifier);
        $this->ensureNotRateLimited($throttleKey, 5, 'code');

        $otp = Otp::where('identifier', $identifier)
            ->whereNull('used_at')
            ->latest()
            ->first();

        if (!$otp || $otp->isExpired() || !Hash::check($validated['code'], $otp->code)) {
            RateLimiter::hit($throttleKey);

            throw ValidationException::withMessages([
                'code' => 'OTP код буруу эсвэл хугацаа дууссан байна.',
            ]);
        }

        RateLimiter::clear($throttleKey);

        $request->session()->put('otp_verified', true);

        return redirect()->route('otp.reset.form')->with('status', 'OTP баталгаажлаа. Одоо шинэ нууц үгээ оруулна уу.');
    }

    public function showResetForm(Request $request)
    {
        if (!$request->session()->get('otp_verified') || !$request->session()->has('otp_identifier')) {
            return redirect()->route('users.password.request')->withErrors([
                'identifier' => 'OTP кодоо эхлээд баталгаажуулна уу.',
            ]);
        }

        return view('users.auth.reset-password', [
            'identifier' => $request->session()->get('otp_identifier_display'),
            'status'     => session('status'),
        ]);
    }

    public function resetPassword(Request $request)
    {
        if (!$request->session()->get('otp_verified')) {
            return redirect()->route('users.password.request')->withErrors([
                'identifier' => 'OTP кодоо эхлээд баталгаажуулна уу.',
            ]);
        }

        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $identifier = $request->session()->get('otp_identifier');

        $otp = Otp::where('identifier', $identifier)
            ->whereNull('used_at')
            ->latest()
            ->first();

        if (!$otp || $otp->isExpired()) {
            throw ValidationException::withMessages([
                'password' => 'OTP кодын хугацаа дууссан байна. Дахин OTP хүсэлт илгээнэ үү.',
            ]);
        }

        $user = User::where('phone', $identifier)
            ->orWhere('email', $identifier)
            ->firstOrFail();

        $user->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ])->save();

        $otp->update(['used_at' => now()]);
        Otp::where('identifier', $identifier)->where('id', '!=', $otp->id)->delete();

        $request->session()->forget(['otp_identifier', 'otp_identifier_display', 'otp_verified']);

        return redirect()->route('users.login')->with('status', 'Нууц үг амжилттай шинэчлэгдлээ.');
    }

    protected function otpExpiryMinutes(): int
    {
        return (int) config('auth.otp_expiry_minutes', 10);
    }

    protected function displayIdentifier(User $user, string $field): string
    {
        $value = $user->{$field} ?? '';

        return str_contains($value, '@')
            ? Str::mask($value, '*', 2, 4)
            : Str::mask($value, '*', 2, 4);
    }
}
