<?php

namespace App\Support\Concerns;

use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

trait HandlesAuthIdentifiers
{
    protected function resolveIdentifier(string $identifier): array
    {
        $identifier = trim($identifier);

        if (str_contains($identifier, '@')) {
            return [
                'field' => 'email',
                'value' => Str::lower($identifier),
            ];
        }

        $phone = $this->normalizePhone($identifier);

        if (!$phone) {
            throw ValidationException::withMessages([
                'identifier' => 'Утасны дугаарыг зөв форматаар оруулна уу.',
            ]);
        }

        return [
            'field' => 'phone',
            'value' => $phone,
        ];
    }

    protected function normalizePhone(?string $input): ?string
    {
        if (!$input) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $input);

        if (Str::startsWith($digits, '976') && strlen($digits) === 11) {
            $digits = substr($digits, 3);
        }

        if (Str::startsWith($digits, '0') && strlen($digits) === 9) {
            $digits = substr($digits, 1);
        }

        return strlen($digits) === 8 ? $digits : null;
    }

    protected function ensureNotRateLimited(string $key, int $maxAttempts, string $field): void
    {
        if (!RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            return;
        }

        $seconds = RateLimiter::availableIn($key);

        throw ValidationException::withMessages([
            $field => "Олон дахин оролдсон байна. {$seconds} секундийн дараа дахин оролдоно уу.",
        ]);
    }
}
