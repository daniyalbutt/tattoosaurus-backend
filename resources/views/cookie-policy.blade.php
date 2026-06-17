@extends('layouts.app')
@section('title', 'Cookie Policy - Tattoosaurus')

@section('content')
<section class="banner inner-banner">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-heading">
                    <h1>Cookie Policy</h1>
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
                    <p>This Cookie Policy explains how Tattoosaurus uses cookies and similar technologies when you visit our platform. It describes what these technologies are, why we use them, and your choices regarding their use.</p>
                </div>

                <div class="terms-content">
                    <h4>1. What Are Cookies?</h4>
                    <p>Cookies are small text files that are placed on your device when you visit a website. They are widely used to make websites work, to improve efficiency, and to provide reporting information. Cookies may be set by the site you are visiting ("first-party cookies") or by third parties ("third-party cookies").</p>

                    <h4>2. Why We Use Cookies</h4>
                    <p>We use cookies to keep you signed in to your account, remember your preferences, maintain the security of your session, understand how the platform is used, and improve your overall experience. Some cookies are essential for the platform to function, while others help us enhance and personalise your visit.</p>

                    <h4>3. Types of Cookies We Use</h4>
                    <p><strong>Essential cookies</strong> are necessary for the platform to operate. They enable core functions such as signing in, account authentication, and security. Without these cookies, services you have asked for cannot be provided.</p>
                    <p><strong>Preference cookies</strong> remember choices you make, such as your login state or display settings, to give you a more personalised experience.</p>
                    <p><strong>Analytics cookies</strong> help us understand how visitors interact with the platform by collecting information anonymously. This allows us to measure and improve performance.</p>
                    <p><strong>Functional cookies</strong> support features such as loading content, image galleries, and interactive elements across the platform.</p>

                    <h4>4. Third-Party Cookies</h4>
                    <p>In some cases, we may use cookies provided by trusted third parties, such as analytics services that help us understand platform usage, or embedded content from external sites like artist social media profiles. These third parties may set their own cookies, which are governed by their respective privacy and cookie policies.</p>

                    <h4>5. How Long Cookies Last</h4>
                    <p>Cookies may be "session cookies," which are deleted when you close your browser, or "persistent cookies," which remain on your device until they expire or you delete them. We use both types depending on the purpose of the cookie.</p>

                    <h4>6. Managing Your Cookie Preferences</h4>
                    <p>Most web browsers allow you to control cookies through their settings. You can usually find these settings in the "Options" or "Preferences" menu of your browser. You may choose to block or delete cookies, but please note that doing so may affect the functionality of the platform and some features may not work as intended.</p>

                    <h4>7. Disabling Cookies</h4>
                    <p>If you disable essential cookies, you may not be able to sign in or use certain parts of the platform. Disabling analytics or preference cookies will not prevent you from using the platform but may result in a less personalised experience.</p>

                    <h4>8. Changes to This Cookie Policy</h4>
                    <p>We may update this Cookie Policy from time to time to reflect changes in technology, legislation, or our practices. Any updates will be posted on this page with a revised date. We encourage you to review this policy periodically.</p>

                    <h4>9. Contact Us</h4>
                    <p>If you have any questions about our use of cookies, please reach out through our <a href="{{ route('contact') }}">contact page</a> and our team will be happy to help.</p>

                    <p class="terms-updated"><em>Last updated: {{ now()->format('F Y') }}</em></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection