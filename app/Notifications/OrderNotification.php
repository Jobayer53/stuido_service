<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

// class OrderNotification extends Notification
class OrderNotification extends Notification implements ShouldQueue

{
    use Queueable;
    public $order;
    /**
     * Create a new notification instance.
     */
    public function __construct($oder)
    {
        $this->order = $oder;
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
        return (new MailMessage)
             ->subject('New Order Submitted')
            ->line('Service: '.$this->order->service->name)
            ->line('Slug ID: '.$this->order->slug)
            ->line('Customer: '.$this->order->user->name)
            ->action('View Order', url('/admin-orders'));
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
