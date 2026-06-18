<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Artist Registration</title>
    <style>
        body { margin:0; padding:0; background-color:#f4f4f4; font-family:Arial, Helvetica, sans-serif; }
        @media screen and (max-width:600px){ .container{ width:100% !important; } .px{ padding-left:24px !important; padding-right:24px !important; } }
    </style>
</head>
<body style="margin:0; padding:0; background-color:#f4f4f4;">

    <div style="display:none; max-height:0; overflow:hidden;">
        A new artist, {{ $artist->name }}, has registered and is awaiting review.
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
                            <h1 style="margin:0 0 16px; font-size:22px; color:#111111; font-weight:700;">New Artist Registration</h1>
                            <p style="margin:0 0 24px; font-size:15px; line-height:1.6; color:#555555;">
                                A new artist has completed registration on Tattoosaurus and is awaiting your review. Here are their details:
                            </p>
                        </td>
                    </tr>

                    <!-- Details table -->
                    <tr>
                        <td class="px" style="padding:0 48px 24px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #eeeeee; border-radius:10px; overflow:hidden;">
                                <tr>
                                    <td style="padding:12px 16px; background-color:#fafafa; font-size:13px; color:#888; width:40%;">Name</td>
                                    <td style="padding:12px 16px; font-size:14px; color:#111;">{{ $artist->name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 16px; background-color:#fafafa; font-size:13px; color:#888;">Username</td>
                                    <td style="padding:12px 16px; font-size:14px; color:#111;">{{ '@'.$artist->username }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 16px; background-color:#fafafa; font-size:13px; color:#888;">Email</td>
                                    <td style="padding:12px 16px; font-size:14px; color:#111;">{{ $artist->email }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 16px; background-color:#fafafa; font-size:13px; color:#888;">Phone</td>
                                    <td style="padding:12px 16px; font-size:14px; color:#111;">{{ $artist->phone ?: '—' }}</td>
                                </tr>
                                @if($profile)
                                    <tr>
                                        <td style="padding:12px 16px; background-color:#fafafa; font-size:13px; color:#888;">Tattoo Shop</td>
                                        <td style="padding:12px 16px; font-size:14px; color:#111;">{{ $profile->shop_name ?: '—' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:12px 16px; background-color:#fafafa; font-size:13px; color:#888;">Location</td>
                                        <td style="padding:12px 16px; font-size:14px; color:#111;">{{ $profile->city?->name ?? '—' }}{{ $profile->country?->name ? ', '.$profile->country->name : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:12px 16px; background-color:#fafafa; font-size:13px; color:#888;">Hourly Rate</td>
                                        <td style="padding:12px 16px; font-size:14px; color:#111;">{{ $profile->hourly_rate ? '$'.$profile->hourly_rate : '—' }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td style="padding:12px 16px; background-color:#fafafa; font-size:13px; color:#888;">Status</td>
                                    <td style="padding:12px 16px; font-size:14px;"><span style="color:#b8860b; font-weight:600;">Pending Review</span></td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- CTA -->
                    <tr>
                        <td class="px" align="center" style="padding:8px 48px 40px;">
                            <p style="margin:0 0 20px; font-size:14px; line-height:1.6; color:#555;">
                                Please log in to the admin panel to review the artist's full profile, portfolio, and approve or reject their application.
                            </p>
                            <a href="{{ route('admin.artists.show', $artist) }}"
                               style="display:inline-block; background-color:#d4af37; color:#111111; text-decoration:none; font-weight:700; font-size:15px; padding:14px 32px; border-radius:8px;">
                                Review Artist
                            </a>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color:#fafafa; border-top:1px solid #eeeeee; padding:24px 48px;" align="center">
                            <p style="margin:0; font-size:12px; color:#bbbbbb;">&copy; {{ date('Y') }} Tattoosaurus — Admin Notification</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>