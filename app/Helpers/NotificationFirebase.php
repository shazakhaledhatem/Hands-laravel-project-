<?php

namespace App\Helpers;

use Exception;
use Google\Client as GoogleClient;
use JsonException;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Factory;

class NotificationFirebase
{
    protected $messaging;

    public function __construct()
    {
        $this->messaging = (new Factory)->withServiceAccount(config('services.firebase.credentials'))->createMessaging();
    }
     //For multiple users
    public function sendMulticast(array $tokens, $title, $body)
    {
        $notification = Notification::create($title, $body);

        $message = CloudMessage::new()
            ->withNotification($notification);

        try {
            $this->messaging->sendMulticast($message, $tokens);
            return true;
        } catch (\Exception $e) {
            throw new JsonException($e->getMessage());
        }
    }
     //For a single user
    public function send(string $token, $title, $body)
    {
        $notification = Notification::create($title, $body);

        $message = CloudMessage::withTarget('token', $token)
            ->withNotification($notification);

        try {
            $this->messaging->send($message);
            return ['success' => true];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

}
