<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Approved</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f4f5; font-family: Arial, Helvetica, sans-serif;">

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f5; padding:32px 0;">
        <tr>
            <td align="center">

                <table role="presentation" width="600" cellpadding="0" cellspacing="0"
                       style="max-width:600px; width:100%; background-color:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.05);">

                    <!-- Header -->
                    <tr>
                        <td align="center" style="background-color:#111111; padding:28px;">
                            <h1 style="margin:0; color:#d4af37; font-size:24px; letter-spacing:1px;">TATTOOSAURUS</h1>
                        </td>
                    </tr>

                    <!-- Success badge -->
                    <tr>
                        <td align="center" style="padding:32px 32px 8px;">
                            <div style="width:64px; height:64px; line-height:64px; border-radius:50%; background-color:#e8f5e9; color:#2e7d32; font-size:32px; font-weight:bold;">
                                &#10003;
                            </div>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:8px 40px 24px; text-align:center;">
                            <h2 style="margin:16px 0 8px; color:#111111; font-size:22px;">Your Account Has Been Approved!</h2>
                            <p style="margin:0 0 16px; color:#555555; font-size:15px; line-height:1.6;">
                                Hi {{ $name }},
                            </p>
                            <p style="margin:0 0 24px; color:#555555; font-size:15px; line-height:1.6;">
                                Great news — our team has reviewed and approved your Tattoosaurus artist account.
                                You can now log in with your credentials and start showcasing your work,
                                managing bookings, and connecting with clients.
                            </p>

                            <!-- CTA button -->
                            <table role="presentation" cellpadding="0" cellspacing="0" align="center" style="margin:8px auto 24px;">
                                <tr>
                                    <td align="center" style="background-color:#d4af37; border-radius:6px;">
                                        <a href="{{ $loginUrl }}"
                                           style="display:inline-block; padding:13px 32px; color:#111111; font-size:15px; font-weight:bold; text-decoration:none;">
                                            Log In to Your Account
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:0; color:#999999; font-size:13px; line-height:1.6;">
                                Use the email and password you registered with. If the button above doesn't work,
                                copy and paste this link into your browser:<br>
                                <a href="{{ $loginUrl }}" style="color:#d4af37; word-break:break-all;">{{ $loginUrl }}</a>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color:#fafafa; padding:24px 40px; text-align:center; border-top:1px solid #eeeeee;">
                            <p style="margin:0 0 4px; color:#999999; font-size:12px;">
                                Need help? Contact us at
                                <a href="mailto:support@tattoosaurus.com" style="color:#777777;">support@tattoosaurus.com</a>
                            </p>
                            <p style="margin:0; color:#bbbbbb; font-size:12px;">
                                &copy; {{ date('Y') }} Tattoosaurus. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>