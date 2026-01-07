<?php

namespace Tests\Feature;

use App\Models\Otp;
use App\Models\User;
use App\Notifications\OtpCodeNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_email(): void
    {
        $password = 'Password123!';
        $user = User::factory()->create([
            'email' => 'login-email@test.mn',
            'phone' => '99110022',
            'password' => Hash::make($password),
        ]);

        $response = $this->post(route('users.login.submit'), [
            'identifier' => 'login-email@test.mn',
            'password'   => $password,
        ]);

        $response->assertRedirect(route('users.welcome'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_can_login_with_phone(): void
    {
        $password = 'Password123!';
        $user = User::factory()->create([
            'email' => 'phone-login@test.mn',
            'phone' => '99118877',
            'password' => Hash::make($password),
        ]);

        $response = $this->post(route('users.login.submit'), [
            'identifier' => '+97699118877',
            'password'   => $password,
        ]);

        $response->assertRedirect(route('users.welcome'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_otp_request_creates_token_and_logs_notification(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'otp-request@test.mn',
            'phone' => '99334455',
        ]);

        $response = $this->post(route('otp.request'), [
            'identifier' => 'otp-request@test.mn',
        ]);

        $response->assertRedirect(route('otp.verify.form'));

        $this->assertDatabaseCount('otps', 1);

        Notification::assertSentTo(
            $user,
            OtpCodeNotification::class,
            function (OtpCodeNotification $notification) {
                $this->assertNotEmpty($notification->code());
                return true;
            }
        );
    }

    public function test_incorrect_otp_returns_validation_error(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'otp-invalid@test.mn',
            'phone' => '99119922',
        ]);

        $this->post(route('otp.request'), [
            'identifier' => $user->email,
        ]);

        $response = $this->from(route('otp.verify.form'))->post(route('otp.verify'), [
            'code' => '000000',
        ]);

        $response->assertSessionHasErrors('code');
        $this->assertFalse(session()->get('otp_verified', false));
    }

    public function test_expired_otp_cannot_be_used(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'otp-expired@test.mn',
            'phone' => '99445566',
        ]);

        $this->post(route('otp.request'), [
            'identifier' => $user->email,
        ]);

        $otpCode = null;
        Notification::assertSentTo(
            $user,
            OtpCodeNotification::class,
            function (OtpCodeNotification $notification) use (&$otpCode) {
                $otpCode = $notification->code();
                return true;
            }
        );

        Otp::query()->update(['expires_at' => now()->subMinutes(5)]);

        $response = $this->post(route('otp.verify'), [
            'code' => $otpCode,
        ]);

        $response->assertSessionHasErrors('code');
    }

    public function test_user_can_reset_password_via_otp(): void
    {
        Notification::fake();

        $password = 'NewPassword123!';
        $user = User::factory()->create([
            'email' => 'otp-reset@test.mn',
            'phone' => '99556677',
        ]);

        $this->post(route('otp.request'), [
            'identifier' => $user->email,
        ]);

        $otpCode = null;
        Notification::assertSentTo(
            $user,
            OtpCodeNotification::class,
            function (OtpCodeNotification $notification) use (&$otpCode) {
                $otpCode = $notification->code();
                return true;
            }
        );

        $this->post(route('otp.verify'), [
            'code' => $otpCode,
        ])->assertRedirect(route('otp.reset.form'));

        $this->post(route('otp.reset'), [
            'password' => $password,
            'password_confirmation' => $password,
        ])->assertRedirect(route('users.login'));

        $this->assertTrue(Hash::check($password, $user->fresh()->password));
        $this->assertDatabaseMissing('otps', [
            'identifier' => $user->email,
            'used_at' => null,
        ]);
    }
}
