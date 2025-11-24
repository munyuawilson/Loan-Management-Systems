<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Verify Your Email - LoanTrack Pro</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #dc2626; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f9fafb; padding: 30px; border: 1px solid #e5e7eb; }
        .button { background: #dc2626; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; display: inline-block; }
        .footer { text-align: center; padding: 20px; color: #6b7280; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Verify Your Email Address</h1>
        </div>
        <div class="content">
            <p>Hello {{ $user->name }},</p>
            
            <p>Thank you for registering with LoanTrack Pro! Please click the button below to verify your email address and activate your account.</p>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $verificationUrl }}" class="button" style="color: white; text-decoration: none;">
                    Verify Email Address
                </a>
            </div>
            
            <p>If you did not create an account, no further action is required.</p>
            
            <p>Thank you,<br>The LoanTrack Pro Team</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} LoanTrack Pro. All rights reserved.</p>
            <p>If you're having trouble clicking the button, copy and paste the URL below into your web browser:</p>
            <p style="word-break: break-all; color: #dc2626;">{{ $verificationUrl }}</p>
        </div>
    </div>
</body>
</html>