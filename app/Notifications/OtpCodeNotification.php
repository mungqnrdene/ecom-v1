<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OtpCodeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected string $code,
        protected int $expiresInMinutes
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Таны баталгаажуулах код')
            ->line('Дараах OTP кодыг ашиглан үйлдлээ баталгаажуулна уу:')
            ->line("**{$this->code}**")
            ->line("Код {$this->expiresInMinutes} минутын дотор хүчинтэй.")
            ->line('Хэрэв та энэ хүсэлтийг илгээгээгүй бол энэ имэйлийг үл тооно уу.');
    }

    public function code(): string
    {
        return $this->code;
    }
}
