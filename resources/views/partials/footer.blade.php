    <footer>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-7">
                    <div class="footer-logo section-heading text-center">
                        <img src="{{ asset('img/logo.png') }}" alt="Tattoosaurus Logo">
                        <h2>Get Started with <span class="gold-line">Tattoosaurus</span> Today</h2>
                        <!-- <div class="line">
                            <img src="{{ asset('img/line-bg.png') }}" alt="">
                            </div> -->
                        <p>Join the Tattoosaurus community and experience a new way to discover tattoo artists, manage your bookings, and showcase your artwork. Whether you’re an artist looking for more exposure or a client searching for the perfect tattoo, Tattoosaurus is here to help.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg">
                    <div class="footer-heading">
                        <h6>Quick <span class="gold-line">Links</span></h6>
                        <ul>
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('about') }}">About Us</a></li>
                            <li><a href="{{ route('faqs') }}">FAQ</a></li>
                            <li><a href="{{ route('contact') }}">Contact Us</a></li>
                            <li><a href="{{ route('events') }}">Events</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg">
                    <div class="footer-heading">
                        <h6>For <span class="gold-line">Clients</span></h6>
                        <ul>
                            <li><a href="{{ route('tattoo.gallery') }}">Tattoo Gallery</a></li>
                            <li><a href="{{ route('flash.gallery') }}">Flash Gallery</a></li>
                        </ul>
                    </div>
                </div>
                <!-- <div class="col-lg">
                    <div class="footer-heading">
                        <h6><span class="gold-line">Information</span></h6>
                        <ul>
                            <li><a href="">Cookie Policy</a></li>
                            <li><a href="">DMCA Policy</a></li>
                            <li><a href="">Artist Agreement</a></li>
                            <li><a href="">Payment/Billing Policy</a></li>
                            <li><a href="">Community Guidelines</a></li>
                        </ul>
                    </div>
                    </div> -->
                <div class="col-lg-3">
                    <div class="footer-heading">
                        <h6>Contact <span class="gold-line">Us</span></h6>
                        <ul class="footer-info">
                            <li><a href=""><i class="fa-regular fa-envelope"></i> support@tattoosarus.com</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="footer-heading social-links">
                        <h6>Follow <span class="gold-line">Us</span></h6>
                        <ul class="footer-social">
                            <li><a href=""><i class="fa-brands fa-facebook-f"></i></a></li>
                            <li><a href=""><i class="fa-brands fa-x-twitter"></i></a></li>
                            <li><a href=""><i class="fa-brands fa-linkedin-in"></i></a></li>
                            <li><a href=""><i class="fa-brands fa-instagram"></i></a></li>
                            <li><a href=""><i class="fa-brands fa-youtube"></i></a></li>
                            <li><a href=""><i class="fa-brands fa-tiktok"></i></a></li>
                        </ul>
                        <h6><span class="gold-line">Newsletter</span></h6>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Your Email">
                            <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i class="fa-solid fa-arrow-right-long"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="lower-footer">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <p class="copyright">©2026 Tattoosaurus, All right reserved</p>
                    </div>
                    <div class="col-lg-6">
                        <div class="payment">
                            <img src="{{ asset('img/payment-img.png') }}" alt="Payment Methods">
                            <p><a href="{{ route('term.conditions') }}">Term & Conditions </a> - <a href="{{ route('privacy.policy') }}">Privacy Policy</a> - <a href="{{ route('cookie.policy') }}">Cookie Policy</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</main>