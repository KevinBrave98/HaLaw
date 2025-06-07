<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class resetPassword extends Notification
{
    use Queueable;

    private $url;

    /**
     * Create a new notification instance.
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = $this->url;
        return (new MailMessage)
                    ->subject('Permintaan Reset Password')
                    ->greeting('HaLaw!')
                    ->line('Kamu mendapatkan email ini karena kami baru saja menerima permintaan reset password dari akunmu.')
                    ->action('Reset Password', $url)
                    ->line('Link reset password ini akan tidak berlaku lagi setelah 60 menit.')
                    ->line('Jika kamu tidak meminta untuk reset password, kamu tidak perlu melakukan apapun.')
                    ->salutation(new HtmlString("Salam Hangat,<br>HaLaw"));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
