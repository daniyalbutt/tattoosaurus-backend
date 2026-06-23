<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Under Review</title>
    <style>
        body { margin:0; padding:0; background-color:#f4f4f4; font-family:Arial, Helvetica, sans-serif; }
        @media screen and (max-width:600px){ .container{ width:100% !important; } .px{ padding-left:24px !important; padding-right:24px !important; } }
    </style>
</head>
<body style="margin:0; padding:0; background-color:#f4f4f4;">

    <div style="display:none; max-height:0; overflow:hidden;">
        Thanks for signing up to Tattoosaurus — your account is currently under review.
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
                    <tr><td style="height:4px; background-color:#d4af37; font-size:0; line-height:4px;">&nbsp;</td></tr>

                    <!-- Body -->
                    <tr>
                        <td class="px" style="padding:40px 48px 16px;">
                            <h1 style="margin:0 0 16px; font-size:24px; color:#111111; font-weight:700;">
                                Thanks for joining, {{ $artist->name }}!
                            </h1>
                            <p style="margin:0 0 20px; font-size:15px; line-height:1.7; color:#555555;">
                                Your Tattoosaurus artist account has been successfully created and is now <strong>under review</strong>. Our team verifies every new member to keep the community safe and authentic.
                            </p>
                        </td>
                    </tr>

                    <!-- Status badge -->
                    <tr>
                        <td class="px" style="padding:0 48px 24px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="background-color:#faf7ef; border:1px solid #ece3c8; border-radius:10px; padding:20px;">
                                        <p style="margin:0 0 4px; font-size:13px; color:#888; text-transform:uppercase; letter-spacing:1px;">Account Status</p>
                                        <p style="margin:0; font-size:18px; font-weight:700; color:#b8860b;">Pending Review</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- What happens next -->
                    <tr>
                        <td class="px" style="padding:0 48px 8px;">
                            <h3 style="margin:0 0 12px; font-size:16px; color:#111111;">What happens next?</h3>
                            <p style="margin:0 0 12px; font-size:14px; line-height:1.7; color:#555555;">
                                Our team will review your profile, portfolio, and details. This usually takes 1–2 business days. Once your account is approved, your profile will go live and customers will be able to find you and send tattoo requests.
                            </p>
                            <p style="margin:0 0 24px; font-size:15px; line-height:1.7; color:#111111; font-weight:600;">
                                We'll notify you by email once your account is approved.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color:#fafafa; border-top:1px solid #eeeeee; padding:24px 48px;" align="center">
                            <p style="margin:0 0 8px; font-size:13px; color:#999999;">&copy; {{ date('Y') }} Tattoosaurus. All rights reserved.</p>
                            <p style="margin:0; font-size:12px; color:#bbbbbb;">This is an automated message, please do not reply.</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>