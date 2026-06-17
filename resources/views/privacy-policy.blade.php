@extends('layouts.app')
@section('title', 'Privacy Policy - Tattoosaurus')

@section('content')
<section class="banner inner-banner">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-heading">
                    <h1>Privacy Policy</h1>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="events terms-section">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="section-heading">
                    <p>At Tattoosaurus, your privacy matters to us. This Privacy Policy explains what information we collect, how we use it, and the choices you have. By using our platform, you consent to the practices described below.</p>
                </div>

                <div class="terms-content">
                    <h4>1. Information We Collect</h4>
                    <p>We collect information you provide directly to us when you create an account, complete your profile, or submit a tattoo request. This may include your name, username, email address, phone number, location, profile photo, portfolio images, reference images, and the details of your tattoo enquiries.</p>

                    <h4>2. Information Collected Automatically</h4>
                    <p>When you use the platform, we may automatically collect certain technical information such as your IP address, browser type, device information, and pages visited. This helps us understand how the platform is used and improve our services.</p>

                    <h4>3. How We Use Your Information</h4>
                    <p>We use the information we collect to operate and maintain the platform, create and manage your account, connect customers with artists, process and display tattoo requests, communicate with you about your account or enquiries, and improve the safety and functionality of our services.</p>

                    <h4>4. Sharing Between Customers &amp; Artists</h4>
                    <p>When you submit a tattoo request, the details you provide — including reference images, idea description, placement, size, and budget — are shared with the artist you contacted so they can respond. Similarly, an artist's public profile information is visible to customers browsing the platform.</p>

                    <h4>5. Sharing With Third Parties</h4>
                    <p>We do not sell your personal information. We may share data with trusted service providers who help us operate the platform (such as hosting and email delivery), and only to the extent necessary for them to perform their services. We may also disclose information where required by law.</p>

                    <h4>6. Cookies &amp; Tracking</h4>
                    <p>We use cookies and similar technologies to keep you signed in, remember your preferences, and analyse platform usage. You can control or disable cookies through your browser settings, though some features may not function correctly if cookies are turned off.</p>

                    <h4>7. Data Retention</h4>
                    <p>We retain your personal information for as long as your account is active or as needed to provide our services. If you close your account, we may retain certain information where necessary to comply with legal obligations, resolve disputes, or enforce our agreements.</p>

                    <h4>8. Data Security</h4>
                    <p>We take reasonable measures to protect your information from unauthorised access, loss, or misuse. However, no method of transmission over the internet is completely secure, and we cannot guarantee absolute security. You are responsible for keeping your login credentials confidential.</p>

                    <h4>9. Your Rights</h4>
                    <p>Depending on your location, you may have the right to access, correct, update, or delete the personal information we hold about you. You may also have the right to object to or restrict certain processing. To exercise these rights, please contact us using the details below.</p>

                    <h4>10. Children's Privacy</h4>
                    <p>Tattoosaurus is intended for users who are at least 18 years of age. We do not knowingly collect personal information from anyone under 18. If we become aware that we have collected such information, we will take steps to delete it.</p>

                    <h4>11. Third-Party Links</h4>
                    <p>The platform may contain links to external websites or an artist's social media profiles. We are not responsible for the privacy practices or content of those third-party sites. We encourage you to review their privacy policies before sharing any information.</p>

                    <h4>12. International Data Transfers</h4>
                    <p>Your information may be stored and processed in a country other than your own. Where this occurs, we take steps to ensure that appropriate safeguards are in place to protect your information in accordance with this policy.</p>

                    <h4>13. Changes to This Policy</h4>
                    <p>We may update this Privacy Policy from time to time. Any changes will be posted on this page with an updated revision date. Your continued use of the platform after changes are posted constitutes acceptance of the revised policy.</p>

                    <h4>14. Contact Us</h4>
                    <p>If you have any questions or concerns about this Privacy Policy or how your data is handled, please reach out through our <a href="{{ route('contact') }}">contact page</a> and our team will respond as soon as possible.</p>

                    <p class="terms-updated"><em>Last updated: {{ now()->format('F Y') }}</em></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection