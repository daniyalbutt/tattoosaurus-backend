<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Your Verification Code</title>
    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->
    <style>
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        body { margin: 0; padding: 0; width: 100% !important; background-color: #f4f4f4; }
        @media screen and (max-width: 600px) {
            .container { width: 100% !important; }
            .px { padding-left: 24px !important; padding-right: 24px !important; }
            .otp-code { font-size: 32px !important; letter-spacing: 8px !important; }
        }
    </style>
</head>
<body style="margin:0; padding:0; background-color:#f4f4f4; font-family:Arial, Helvetica, sans-serif;">

    <!-- Preheader (hidden preview text) -->
    <div style="display:none; max-height:0; overflow:hidden; mso-hide:all;">
        Your Tattoosaurus verification code is {{ $code }}. It expires in 10 minutes.
    </div>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f4;">
        <tr>
            <td align="center" style="padding:32px 16px;">

                <table role="presentation" class="container" width="600" cellpadding="0" cellspacing="0" style="width:600px; max-width:600px; background-color:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 4px 16px rgba(0,0,0,0.06);">

                    <!-- Header -->
                    <tr>
                        <td align="center" style="background-color:#111111; padding:32px 24px;">
                            <img src="{{ asset('img/logo.png') }}" alt="Tattoosaurus" width="140" style="display:block; max-width:140px; height:auto;">
                        </td>
                    </tr>

                    <!-- Gold divider -->
                    <tr>
                        <td style="height:4px; background-color:#d4af37; line-height:4px; font-size:0;">&nbsp;</td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td class="px" style="padding:40px 48px 24px;">
                            <h1 style="margin:0 0 16px; font-size:24px; line-height:1.3; color:#111111; font-weight:700;">
                                Verify your email
                            </h1>
                            <p style="margin:0 0 24px; font-size:15px; line-height:1.6; color:#555555;">
                                Hi {{ $name ?? 'there' }}, thanks for joining Tattoosaurus. Use the verification code below to confirm your email address and continue setting up your account.
                            </p>
                        </td>
                    </tr>

                    <!-- OTP code box -->
                    <tr>
                        <td class="px" style="padding:0 48px 8px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="background-color:#faf7ef; border:1px solid #ece3c8; border-radius:10px; padding:24px;">
                                        <span class="otp-code" style="display:inline-block; font-size:40px; letter-spacing:12px; font-weight:700; color:#111111; font-family:'Courier New', Courier, monospace;">
                                            {{ $code }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Expiry note -->
                    <tr>
                        <td class="px" style="padding:16px 48px 8px;">
                            <p style="margin:0; font-size:14px; line-height:1.6; color:#888888; text-align:center;">
                                This code will expire in <strong style="color:#555555;">10 minutes</strong>.
                            </p>
                        </td>
                    </tr>

                    <!-- Security note -->
                    <tr>
                        <td class="px" style="padding:24px 48px 40px;">
                            <p style="margin:0; font-size:13px; line-height:1.6; color:#999999;">
                                If you didn't request this code, you can safely ignore this email — someone may have entered your address by mistake. Your account remains secure.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color:#fafafa; border-top:1px solid #eeeeee; padding:24px 48px;" align="center">
                            <p style="margin:0 0 8px; font-size:13px; color:#999999;">
                                &copy; {{ date('Y') }} Tattoosaurus. All rights reserved.
                            </p>
                            <p style="margin:0; font-size:12px; color:#bbbbbb;">
                                This is an automated message, please do not reply.
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>