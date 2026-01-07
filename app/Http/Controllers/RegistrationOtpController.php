<?php

namespace App\Http\Controllers;

use App\Models\Otp;
use App\Models\User;
use App\Notifications\OtpCodeNotification;
use App\Support\Concerns\HandlesAuthIdentifiers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class RegistrationOtpController extends Controller
{
    use HandlesAuthIdentifiers;

    public function showChannelForm(Request $request)
    {
        $pending = $this->pendingRegistration($request);

        if (!$pending) {
            return $this->redirectToRegister();
        }

        $channels = $this->availableChannels($pending);

        if (empty($channels)) {
            return $this->redirectToRegister('Имэйл эсвэл утасны дугаарын аль нэгийг оруулснаар OTP авах боломжтой.');
        }

        return view('users.auth.register-otp-channel', [
            'channels' => $channels,
            'status' => session('status'),
        ]);
    }

    public function send(Request $request)
    {
        $pending = $this->pendingRegistration($request);

        if (!$pending) {
            return $this->redirectToRegister();
        }

        $channels = $this->availableChannels($pending);

        $validated = $request->validate([
            'channel' => ['required', Rule::in(array_keys($channels))],
        ], [
            'channel.required' => 'Баталгаажуулах сувгаа сонгоно уу.',
        ]);

        return $this->dispatchOtp($request, $channels[$validated['channel']], $validated['channel']);
    }

    public function resend(Request $request)
    {
        $pending = $this->pendingRegistration($request);

        if (!$pending) {
            return $this->redirectToRegister();
        }

        $channel = $request->session()->get('pending_registration_channel');
        $channels = $this->availableChannels($pending);

        if (!$channel || !isset($channels[$channel])) {
            return redirect()->route('users.register.otp.channel')->withErrors([
                'channel' => 'Баталгаажуулах сувгаа дахин сонгоно уу.',
            ]);
        }

        return $this->dispatchOtp($request, $channels[$channel], $channel);
    }

    public function showVerifyForm(Request $request)
    {
        $pending = $this->pendingRegistration($request);

        if (!$pending) {
            return $this->redirectToRegister();
        }

        $identifier = $request->session()->get('pending_registration_identifier');

        if (!$identifier) {
            return redirect()->route('users.register.otp.channel')->withErrors([
                'channel' => 'Эхлээд OTP илгээх сувгаа сонгоно уу.',
            ]);
        }

        return view('users.auth.register-otp-verify', [
            'identifier' => $this->maskIdentifier($identifier),
            'channel' => $request->session()->get('pending_registration_channel'),
            'status' => session('status'),
            'expiresIn' => $this->otpExpiryMinutes(),
        ]);
    }

    public function verify(Request $request)
    {
        $pending = $this->pendingRegistration($request);

        if (!$pending) {
            return $this->redirectToRegister();
        }

        $identifier = $request->session()->get('pending_registration_identifier');

        if (!$identifier) {
            return redirect()->route('users.register.otp.channel')->withErrors([
                'channel' => 'Эхлээд OTP илгээх сувгаа сонгоно уу.',
            ]);
        }

        $validated = $request->validate([
            'code' => 'required|digits:6',
        ]);

        $throttleKey = sprintf('register-otp-verify:%s', $identifier);
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

        if ($redirect = $this->ensureNoDuplicateAccounts($pending, $request)) {
            return $redirect;
        }

        DB::transaction(function () use ($pending, $identifier, $otp) {
            User::create([
                'name' => $pending['name'],
                'email' => $pending['email'],
                'phone' => $pending['phone'],
                'password' => $pending['password'],
            ]);

            $otp->update(['used_at' => now()]);
            Otp::where('identifier', $identifier)->where('id', '!=', $otp->id)->delete();
        });

        RateLimiter::clear($throttleKey);

        $this->clearPendingRegistration($request);

        return redirect()->route('users.login')
            ->with('status', 'Бүртгэл амжилттай. Одоо нэвтэрнэ үү.');
    }

    protected function dispatchOtp(Request $request, string $identifier, string $channel)
    {
        $throttleKey = sprintf('register-otp:%s', $identifier);
        $this->ensureNotRateLimited($throttleKey, 3, 'channel');

        $code = $this->createOtpForIdentifier($identifier);

        RateLimiter::hit($throttleKey);

        $this->deliverOtp($identifier, $channel, $code);

        $request->session()->put([
            'pending_registration_channel' => $channel,
            'pending_registration_identifier' => $identifier,
        ]);

        return redirect()->route('users.register.otp.verify.form')
            ->with('status', 'OTP код илгээгдлээ. ' . $this->otpExpiryMinutes() . ' минутын дотор оруулна уу.');
    }

    protected function createOtpForIdentifier(string $identifier): string
    {
        $code = (string) random_int(100000, 999999);

        Otp::where('identifier', $identifier)->delete();

        Otp::create([
            'identifier' => $identifier,
            'code' => Hash::make($code),
            'expires_at' => now()->addMinutes($this->otpExpiryMinutes()),
            'used_at' => null,
        ]);

        return $code;
    }

    protected function deliverOtp(string $identifier, string $channel, string $code): void
    {
        if ($channel === 'email') {
            Notification::route('mail', $identifier)
                ->notify(new OtpCodeNotification($code, $this->otpExpiryMinutes()));

            if (app()->environment('local', 'testing')) {
                Log::info('Registration OTP email code', compact('identifier', 'code'));
            }

            return;
        }

        Log::info('Registration OTP SMS code', compact('identifier', 'code'));
    }

    protected function ensureNoDuplicateAccounts(array $pending, Request $request): ?RedirectResponse
    {
        $errors = [];

        if ($pending['email'] && User::where('email', $pending['email'])->exists()) {
            $errors['email'] = 'Энэ имэйлээр бүртгэл аль хэдийн бий.';
        }

        if ($pending['phone'] && User::where('phone', $pending['phone'])->exists()) {
            $errors['phone'] = 'Энэ утасны дугаараар бүртгэл аль хэдийн бий.';
        }

        if (!empty($errors)) {
            $this->clearPendingRegistration($request);

            return redirect()->route('users.register')->withErrors($errors);
        }

        return null;
    }

    protected function availableChannels(array $pending): array
    {
        $channels = [];

        if (!empty($pending['email'])) {
            $channels['email'] = $pending['email'];
        }

        if (!empty($pending['phone'])) {
            $channels['phone'] = $pending['phone'];
        }

        return $channels;
    }

    protected function pendingRegistration(Request $request): ?array
    {
        return $request->session()->get('pending_registration');
    }

    protected function clearPendingRegistration(Request $request): void
    {
        $request->session()->forget([
            'pending_registration',
            'pending_registration_channel',
            'pending_registration_identifier',
        ]);
    }

    protected function maskIdentifier(string $identifier): string
    {
        if (Str::contains($identifier, '@')) {
            [$local, $domain] = explode('@', $identifier, 2);
            $maskedLocal = Str::mask($local, '*', 2, max(strlen($local) - 2, 1));

            return sprintf('%s@%s', $maskedLocal, $domain);
        }

        return Str::mask($identifier, '*', 2, 4);
    }

    protected function otpExpiryMinutes(): int
    {
        return (int) config('auth.otp_expiry_minutes', 10);
    }

    protected function redirectToRegister(string $message = 'Бүртгэлийн мэдээллээ эхлээд оруулна уу.'): RedirectResponse
    {
        return redirect()->route('users.register')->with('register_error', $message);
    }
}
