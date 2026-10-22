<?php
// app/Notifications/GeneralNotification.php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class GeneralNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string  $title,
        public string  $body  = '',
        public ?string $url   = null,
        public string  $icon  = 'notifications',   // material-icon name
        public ?string $image = null,              // optional avatar/image url
    ) {}

    /**
     * Store in the database only (add 'mail' here later if you want emails too).
     */
    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => $this->title,
            'body'  => $this->body,
            'url'   => $this->url,
            'icon'  => $this->icon,
            'image' => $this->image,
        ];
    }
}