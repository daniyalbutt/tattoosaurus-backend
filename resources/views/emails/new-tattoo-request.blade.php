<!DOCTYPE html>
<html>
<head><meta charset="utf-8"></head>
<body style="margin:0;padding:0;background:#f4f4f4;font-family:Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f4f4;">
        <tr><td align="center" style="padding:32px 16px;">
            <table width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:12px;overflow:hidden;">
                <tr><td align="center" style="background:#111;padding:28px;">
                    <img src="{{ asset('img/logo.png') }}" alt="Tattoosaurus" width="140" style="height:auto;">
                </td></tr>
                <tr><td style="height:4px;background:#d4af37;font-size:0;">&nbsp;</td></tr>
                <tr><td style="padding:36px 44px;">
                    <h1 style="margin:0 0 16px;font-size:22px;color:#111;">You have a new tattoo request!</h1>
                    <p style="margin:0 0 16px;font-size:15px;line-height:1.7;color:#555;">
                        Hi {{ $artist->name }}, <strong>{{ $customer->name }}</strong> has just submitted a tattoo request for you on Tattoosaurus.
                    </p>
                    <p style="margin:0 0 24px;font-size:15px;line-height:1.7;color:#555;">
                        Log in to your portal to view the full brief and start the conversation.
                    </p>
                    <table cellpadding="0" cellspacing="0"><tr>
                        <td style="border-radius:6px;background:#111;">
                            <a href="{{ route('artist.requests') }}"
                               style="display:inline-block;padding:12px 28px;color:#fff;text-decoration:none;font-weight:bold;">
                                View Request
                            </a>
                        </td>
                    </tr></table>
                </td></tr>
                <tr><td style="background:#fafafa;border-top:1px solid #eee;padding:20px 44px;" align="center">
                    <p style="margin:0;font-size:12px;color:#aaa;">&copy; {{ date('Y') }} Tattoosaurus</p>
                </td></tr>
            </table>
        </td></tr>
    </table>
</body>
</html>