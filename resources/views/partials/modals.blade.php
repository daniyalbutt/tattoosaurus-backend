<div class="modal fade register-modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="register-img">
                            <img src="{{ asset('img/register-img.png') }}" alt="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="register-content">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            <div class="section-heading">
                                <h2>Join and be part of the Tattoosarus community.”</h2>
                                <div class="line">
                                    <img src="{{ asset('img/line-bg.png') }}" alt="">
                                </div>
                                <ul class="register-login">
                                    <li>
                                        <a href="#" class="choose-role" data-role="customer"
                                        data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registerModal">
                                            <span class="img-box">
                                                <img src="{{ asset('img/customer-login.png') }}" alt="">
                                            </span>
                                            <p>As a Customer</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="choose-role" data-role="artist"
                                        data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registerModal">
                                            <span class="img-box">
                                                <img src="{{ asset('img/member-login.png') }}" alt="">
                                            </span>
                                            <p>As a Member</p>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade register-modal" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="register-img">
                            <img src="{{ asset('img/register-img.png') }}" alt="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="register-content">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            <div class="section-heading">
                                <h6>Log in</h6>
                                <h2>Access Your Ink World with Tattoosaurus</h2>
                                <div class="line">
                                    <img src="{{ asset('img/line-bg.png') }}" alt="">
                                </div>
                                <p class="new-here">New here? <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registerModal">Create an account</a> and start your tattoo journey today.</p>
                                <h5>Login to your account</h5>
                                <div class="line">
                                    <img src="{{ asset('img/line-bg.png') }}" alt="">
                                </div>
                                <div class="row">
                                    <div class="col-lg-7">
                                        <form id="loginForm" class="contact-form login-form" novalidate>
                                            <div id="loginError" class="alert alert-danger d-none"></div>

                                            <div class="input-group-wrapper">
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <img src="{{ asset('img/form-icon-2.png') }}" alt="">
                                                    </span>
                                                    <input type="text" name="login_email" class="form-control" placeholder="email or Phone Number">
                                                </div>
                                                <small class="field-error text-danger d-block mt-1" data-error="email"></small>
                                            </div>

                                            <div class="input-group-wrapper">
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <img src="{{ asset('img/form-icon-6.png') }}" alt="">
                                                    </span>
                                                    <input type="password" name="login_password" class="form-control" placeholder="Password">
                                                    <span class="input-group-text password-toggle" data-target="login_password" role="button">
                                                        <i class="fa-regular fa-eye"></i>
                                                    </span>
                                                </div>
                                                <small class="field-error text-danger d-block mt-1" data-error="password"></small>
                                            </div>

                                            <div class="forgot">
                                                <a href="" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#forgetpasswordModal">Forgot Password?</a>
                                            </div>
                                            <button type="submit" class="btn btn-gradient" id="loginSubmit">Log in</button>
                                        </form>
                                        <div class="signup-option d-none">
                                            <h5>Sign up with</h5>
                                            <a href="">
                                            <img src="{{ asset('img/google-icon.png') }}" alt="Google Login">
                                            </a>
                                            <a href="">
                                            <img src="{{ asset('img/facebook-icon.png') }}" alt="Facebook Login">
                                            </a>
                                            <a href="">
                                            <img src="{{ asset('img/apple-icon.png') }}" alt="Apple Login">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade register-modal" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="register-img">
                            <img src="{{ asset('img/signup-img.png') }}" alt="Register Image">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="register-content">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            <div class="section-heading">
                                <h6>Sign up</h6>
                                <h2>Access Your Ink World with Tattoosaurus</h2>
                                <div class="line">
                                    <img src="{{ asset('img/line-bg.png') }}" alt="">
                                </div>
                                <p class="new-here">Already have an account? <a href="" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">Login here</a></p>
                                <h5>Create an account</h5>
                                <div class="line">
                                    <img src="{{ asset('img/line-bg.png') }}" alt="">
                                </div>
                                <form id="registerForm" class="contact-form login-form row register-form" novalidate>
                                    <div class="col-lg-6">
                                        <div class="input-group-wrapper">
                                            <div class="input-group">
                                                <span class="input-group-text"><img src="{{ asset('img/form-icon-1.png') }}" alt=""></span>
                                                <input type="text" name="name" class="form-control" placeholder="Name *">
                                            </div>
                                            <small class="field-error text-danger d-block mt-1" data-error="name"></small>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="input-group-wrapper">
                                            <div class="input-group">
                                                <span class="input-group-text"><img src="{{ asset('img/form-icon-1.png') }}" alt=""></span>
                                                <input type="text" name="username" class="form-control" placeholder="Username *">
                                            </div>
                                            <small class="field-error text-danger d-block mt-1" data-error="username"></small>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="input-group-wrapper">
                                            <div class="input-group">
                                                <span class="input-group-text"><img src="{{ asset('img/form-icon-2.png') }}" alt=""></span>
                                                <input type="email" name="email" class="form-control" placeholder="Email *">
                                            </div>
                                            <small class="field-error text-danger d-block mt-1" data-error="email"></small>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="input-group-wrapper">
                                            <div class="input-group">
                                                <span class="input-group-text"><img src="{{ asset('img/form-icon-1.png') }}" alt=""></span>
                                                <input type="text" name="phone" class="form-control" placeholder="Phone Number *">
                                            </div>
                                            <small class="field-error text-danger d-block mt-1" data-error="phone"></small>
                                        </div>
                                        <small class="field-error text-danger d-block mt-1" data-error="phone"></small>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="input-group-wrapper">
                                            <div class="input-group">
                                                <span class="input-group-text"><img src="{{ asset('img/form-icon-6.png') }}" alt=""></span>
                                                <input type="password" name="password" class="form-control" placeholder="Password">
                                                <span class="input-group-text password-toggle" data-target="password" role="button">
                                                    <i class="fa-regular fa-eye"></i>
                                                </span>
                                            </div>
                                            <small class="field-error text-danger d-block mt-1" data-error="password"></small>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="input-group-wrapper">
                                            <div class="input-group">
                                                <span class="input-group-text"><img src="{{ asset('img/form-icon-6.png') }}" alt=""></span>
                                                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                                                <span class="input-group-text password-toggle" data-target="password_confirmation" role="button">
                                                    <i class="fa-regular fa-eye"></i>
                                                </span>
                                            </div>
                                            <small class="field-error text-danger d-block mt-1" data-error="password_confirmation"></small>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-gradient" id="registerSubmit">Register</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade register-modal" id="oneTimePassowrdModal" tabindex="-1" aria-labelledby="oneTimePassowrdModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="register-img">
                            <img src="{{ asset('img/signup-img.png') }}" alt="Register Image">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="register-content">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            <div class="section-heading text-center">
                                <h2>One Time Password</h2>
                                <div class="line">
                                    <img src="{{ asset('img/line-bg.png') }}" alt="">
                                </div>
                                <p class="new-here">We have sent you an email containing a 6-digit verification code.<br> Please enter the code to verify your identity</p>
                                <form id="otpForm" class="contact-form login-form row register-form" novalidate>
                                    <div class="circle-timer" id="circleTimer"><span>0s</span></div>
                                    <ul class="circle-input">
                                        <li><input type="text" inputmode="numeric" class="form-control otp-digit" placeholder="0" maxlength="1"></li>
                                        <li><input type="text" inputmode="numeric" class="form-control otp-digit" placeholder="0" maxlength="1"></li>
                                        <li><input type="text" inputmode="numeric" class="form-control otp-digit" placeholder="0" maxlength="1"></li>
                                        <li><input type="text" inputmode="numeric" class="form-control otp-digit" placeholder="0" maxlength="1"></li>
                                        <li><input type="text" inputmode="numeric" class="form-control otp-digit" placeholder="0" maxlength="1"></li>
                                        <li><input type="text" inputmode="numeric" class="form-control otp-digit" placeholder="0" maxlength="1"></li>
                                    </ul>
                                    <small class="field-error text-danger d-block mt-1 text-center" data-error="otp"></small>

                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-gradient" id="otpSubmit">Verify</button>
                                    </div>
                                    <a href="#" class="code-receive" id="resendOtp">Code didn't receive?<br><span>Resend Code</span></a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade register-modal" id="registerationModal" tabindex="-1" aria-labelledby="registerationModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="register-img">
                            <img src="{{ asset('img/signup-img.png') }}" alt="Register Image">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="register-content">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            <div class="section-heading text-center">
                                <h2>Registration</h2>
                                <div class="line">
                                    <img src="{{ asset('img/line-bg.png') }}" alt="">
                                </div>
                                <p class="new-here">Enter your details to register yourself</p>
                                <form id="detailsForm" class="contact-form login-form row register-form align-items-center justify-content-center" novalidate>
                                    <div class="col-lg-8">
                                        {{-- Country --}}
                                        <div class="input-group-wrapper">
                                            <div class="input-group mb-1">
                                                <span class="input-group-text"><i class="fa-solid fa-earth-africa"></i></span>
                                                <select id="country" name="country_id" class="form-control">
                                                    <option value="">Select Country</option>
                                                </select>
                                            </div>
                                            <small class="field-error text-danger d-block mb-2" data-error="country_id"></small>
                                        </div>

                                        {{-- State --}}
                                        <div class="input-group-wrapper">
                                            <div class="input-group mb-1">
                                                <span class="input-group-text"><i class="fa-solid fa-flag"></i></span>
                                                <select id="state" name="state_id" class="form-control" disabled>
                                                    <option value="">Select State</option>
                                                </select>
                                            </div>
                                            <small class="field-error text-danger d-block mb-2" data-error="state_id"></small>
                                        </div>

                                        {{-- City --}}
                                        <div class="input-group-wrapper">
                                            <div class="input-group mb-1">
                                                <span class="input-group-text"><i class="fa-solid fa-city"></i></span>
                                                <select id="city" name="city_id" class="form-control" disabled>
                                                    <option value="">Select City</option>
                                                </select>
                                            </div>
                                            <small class="field-error text-danger d-block mb-2" data-error="city_id"></small>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-gradient" id="detailsSubmit">Continue</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade register-modal" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="register-img">
                            <img src="{{ asset('img/signup-img.png') }}" alt="Register Image">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="register-content">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            <div class="section-heading text-center">
                                <h2>Create Profile</h2>
                                <div class="line">
                                    <img src="{{ asset('img/line-bg.png') }}" alt="">
                                </div>
                                <p class="new-here">Enter your details to register yourself</p>
                                <form id="profileForm" class="contact-form login-form row register-form align-items-center justify-content-center" enctype="multipart/form-data" novalidate>
                                    <div class="col-lg-8">
                                        <div class="profile-upload">
                                            <label for="profileInput" class="profile-circle">
                                                <img id="profilePreview" src="" alt="">
                                                <span class="placeholder"><i class="fa-regular fa-user"></i></span>
                                            </label>
                                            <span class="remove-image" title="Remove image"><i class="fa-solid fa-xmark"></i></span>
                                            <input type="file" id="profileInput" name="avatar" accept="image/*" hidden>
                                        </div>
                                        <small class="field-error text-danger d-block mb-2 text-center" data-error="avatar"></small>

                                        <div class="input-group-wrapper">
                                            <div class="input-group mb-1">
                                                <textarea name="bio" id="bio" class="form-control" placeholder="Bio"></textarea>
                                            </div>
                                            <small class="field-error text-danger d-block mb-2" data-error="bio"></small>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-gradient" id="profileSubmit">Continue</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade register-modal" id="accountModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="register-img">
                            <img src="{{ asset('img/signup-img.png') }}" alt="Register Image">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="register-content">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            <div class="section-heading text-center account-created">
                                <h2>Account Created!</h2>
                                <div class="line">
                                    <img src="{{ asset('img/line-bg.png') }}" alt="">
                                </div>
                                <p class="new-here">Thanks for signing up to Tattoosarus. Your account is currently under review. Our team verifies every new member to keep the community safe and authentic. You’ll receive an email once your account is approved.</p>
                                <p class="notify">We’ll notify you by email once your account is approved.</p>
                                <form class="contact-form login-form row register-form align-items-center justify-content-center">
                                    <div class="col-lg-12">
                                        <button type="button" class="btn btn-gradient" data-bs-dismiss="modal">Done</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade register-modal" id="forgetpasswordModal" tabindex="-1" aria-labelledby="forgetpasswordModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="register-img">
                            <img src="{{ asset('img/signup-img.png') }}" alt="Register Image">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="register-content">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            <div class="section-heading text-center">
                                <h2>Forgot password</h2>
                                <div class="line">
                                    <img src="{{ asset('img/line-bg.png') }}" alt="">
                                </div>
                                <p class="new-here">Please enter your email to reset password</p>
                                <form class="contact-form login-form row register-form align-items-center justify-content-center">
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                            <img src="{{ asset('img/form-icon-2.png') }}" alt="">
                                            </span>
                                            <input type="email" class="form-control" placeholder="email">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <button type="button" class="btn btn-gradient" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#oneTimePassowrdModal">Next</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>