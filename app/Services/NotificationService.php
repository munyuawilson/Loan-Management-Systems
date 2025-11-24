<?php
// app/Services/NotificationService.php
namespace App\Services;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    public function sendNotification(User $user, string $title, string $message, string $type = 'in_app')
    {
        switch ($type) {
            case 'in_app':
                $this->sendInAppNotification($user, $title, $message);
                break;
            case 'email':
                $this->sendEmailNotification($user, $title, $message);
                break;
            case 'sms_placeholder':
                $this->sendSmsPlaceholder($user, $title, $message);
                break;
        }
    }

    private function sendInAppNotification(User $user, string $title, string $message)
    {
        Notification::create([
            'user_id' => $user->id,
            'title' => $title,
            'message' => $message,
            'type' => 'in_app',
            'is_read' => false,
        ]);
    }

    private function sendEmailNotification(User $user, string $title, string $message)
    {
        try {
            // Send email using Laravel Mail
            Mail::send('emails.notification', [
                'title' => $title,
                'message' => $message,
                'user' => $user
            ], function ($mail) use ($user, $title) {
                $mail->to($user->email)
                     ->subject($title);
            });

            // Also store in database
            Notification::create([
                'user_id' => $user->id,
                'title' => $title,
                'message' => $message,
                'type' => 'email',
                'is_read' => false,
            ]);

        } catch (\Exception $e) {
            Log::error('Email notification failed: ' . $e->getMessage());
        }
    }

    private function sendSmsPlaceholder(User $user, string $title, string $message)
    {
        // Log SMS content instead of sending real SMS
        $smsContent = "SMS to {$user->phone}: {$title} - {$message}";
        
        Log::info('SMS Placeholder:', [
            'phone' => $user->phone,
            'title' => $title,
            'message' => $message,
            'timestamp' => now(),
        ]);

        // Store in database
        Notification::create([
            'user_id' => $user->id,
            'title' => $title,
            'message' => $message,
            'type' => 'sms_placeholder',
            'is_read' => false,
        ]);
    }
}