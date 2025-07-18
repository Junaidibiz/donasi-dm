<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DonaturResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // URL ini akan mengarah ke halaman reset password di frontend Vue Anda
        $url = config('app.url_frontend') . '/reset-password?token=' . $this->token . '&email=' . urlencode($notifiable->email);

        return (new MailMessage)
                    ->subject('Notifikasi Reset Password Akun Donasi')
                    ->line('Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.')
                    ->action('Reset Password', $url)
                    ->line('Token reset password ini akan kedaluwarsa dalam 60 menit.')
                    ->line('Jika Anda tidak merasa melakukan permintaan ini, abaikan email ini.');
    }
}