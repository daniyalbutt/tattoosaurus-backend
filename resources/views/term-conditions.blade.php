@extends('layouts.app')
@section('title', 'Terms & Conditions - Tattoosaurus')

@section('content')
<section class="banner inner-banner">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-heading">
                    <h1>Terms & Conditions</h1>
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
                    <p>Welcome to Tattoosaurus. By accessing or using our platform, you agree to be bound by these Terms & Conditions. Please read them carefully before using our services. If you do not agree with any part of these terms, you should not use the platform.</p>
                </div>

                <div class="terms-content">
                    <h4>1. Acceptance of Terms</h4>
                    <p>By creating an account, browsing artist profiles, or submitting a tattoo request, you confirm that you are at least 18 years of age and that you accept these Terms & Conditions in full. Tattoosaurus reserves the right to update or modify these terms at any time, and continued use of the platform constitutes acceptance of any changes.</p>

                    <h4>2. Platform Role</h4>
                    <p>Tattoosaurus is a marketplace that connects customers with independent tattoo artists. We do not provide tattoo services ourselves and are not a party to any agreement made between a customer and an artist. Any booking, design, pricing, or service arrangement is strictly between the customer and the artist.</p>

                    <h4>3. Accounts &amp; Registration</h4>
                    <p>To access certain features you must register for an account and provide accurate, current, and complete information. You are responsible for maintaining the confidentiality of your login credentials and for all activity that occurs under your account. Notify us immediately of any unauthorised use.</p>

                    <h4>4. Artist Responsibilities</h4>
                    <p>Artists are responsible for the accuracy of the information on their profiles, including portfolio images, pricing, availability, and qualifications. Artists must hold any licences or certifications required by their local jurisdiction and must comply with all applicable health and safety regulations.</p>

                    <h4>5. Customer Responsibilities</h4>
                    <p>Customers are responsible for providing accurate details when submitting a tattoo request, including reference images, placement, size, and budget. Customers must confirm they meet the legal age requirement for receiving a tattoo and must disclose any relevant medical conditions directly to the artist.</p>

                    <h4>6. Bookings &amp; Requests</h4>
                    <p>Submitting a tattoo request does not guarantee acceptance by an artist. Artists may accept, decline, or request further information regarding any submission. Any deposits, payment terms, or cancellation policies are set by the individual artist and communicated directly to the customer.</p>

                    <h4>7. Payments</h4>
                    <p>Unless otherwise stated, all payments for tattoo services are handled directly between the customer and the artist. Tattoosaurus is not responsible for processing service payments, refunds, or disputes arising from any transaction conducted outside the platform.</p>

                    <h4>8. Cancellations &amp; Refunds</h4>
                    <p>Cancellation and refund policies are determined by each artist. Customers should review an artist's policy before confirming a booking. Tattoosaurus does not issue refunds on behalf of artists and is not liable for any losses resulting from a cancelled or rescheduled appointment.</p>

                    <h4>9. Content &amp; Intellectual Property</h4>
                    <p>All content uploaded to the platform, including portfolio images and tattoo designs, remains the property of its respective owner. By uploading content, you grant Tattoosaurus a non-exclusive licence to display that content for the purpose of operating and promoting the platform. You must not copy, reproduce, or distribute another user's content without permission.</p>

                    <h4>10. Prohibited Conduct</h4>
                    <p>You agree not to use the platform for any unlawful purpose, to harass or abuse other users, to post misleading or offensive content, or to attempt to circumvent the platform's features and security. We reserve the right to suspend or terminate accounts that violate these terms.</p>

                    <h4>11. Health &amp; Safety Disclaimer</h4>
                    <p>Tattooing carries inherent risks. Tattoosaurus does not provide medical advice and is not responsible for the outcome, aftercare, or any complications arising from a tattoo. Customers should follow the aftercare guidance provided by their artist and consult a medical professional if any issues occur.</p>

                    <h4>12. Limitation of Liability</h4>
                    <p>To the fullest extent permitted by law, Tattoosaurus shall not be liable for any direct, indirect, incidental, or consequential damages arising from the use of the platform or from any interaction between customers and artists. The platform is provided on an "as is" and "as available" basis.</p>

                    <h4>13. Termination</h4>
                    <p>We may suspend or terminate your access to the platform at our discretion, without notice, if we believe you have breached these Terms & Conditions or engaged in conduct harmful to other users or the platform.</p>

                    <h4>14. Governing Law</h4>
                    <p>These Terms & Conditions are governed by and construed in accordance with the laws of the jurisdiction in which Tattoosaurus operates. Any disputes shall be subject to the exclusive jurisdiction of the courts of that jurisdiction.</p>

                    <h4>15. Contact Us</h4>
                    <p>If you have any questions about these Terms & Conditions, please reach out through our <a href="{{ route('contact') }}">contact page</a> and our team will be happy to assist you.</p>

                    <p class="terms-updated"><em>Last updated: {{ now()->format('F Y') }}</em></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection