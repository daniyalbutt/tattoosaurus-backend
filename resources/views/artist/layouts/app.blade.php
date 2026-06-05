<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('portal/css/all.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('portal/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('portal/css/cryptocoins.css') }}">
    <link rel="stylesheet" href="{{ asset('portal/css/cryptocoins-colors.css') }}">
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('portal/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- jQuery UI -->
    <link href="{{ asset('portal/css/jquery-ui.min.css') }}" rel="stylesheet">
    <!-- Page Specific CSS (Slick Slider.css) -->
    <link href="{{ asset('portal/css/slick.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">
    <!-- Mystic styles -->
    <link href="{{ asset('portal/css/style.css') }}" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon.png') }}">

    <title>@yield('title', 'Tattoosaurus')</title>
    @stack('styles')
</head>
<body class="ms-body ms-aside-left-open ms-primary-theme ms-has-quickbar">
    <!-- Preloader -->
    <div id="preloader-wrap">
        <div class="spinner spinner-8">
            <div class="ms-circle1 ms-child"></div>
            <div class="ms-circle2 ms-child"></div>
            <div class="ms-circle3 ms-child"></div>
            <div class="ms-circle4 ms-child"></div>
            <div class="ms-circle5 ms-child"></div>
            <div class="ms-circle6 ms-child"></div>
            <div class="ms-circle7 ms-child"></div>
            <div class="ms-circle8 ms-child"></div>
            <div class="ms-circle9 ms-child"></div>
            <div class="ms-circle10 ms-child"></div>
            <div class="ms-circle11 ms-child"></div>
            <div class="ms-circle12 ms-child"></div>
        </div>
    </div>
    <!-- Overlays -->
    <div class="ms-aside-overlay ms-overlay-left ms-toggler" data-target="#ms-side-nav" data-toggle="slideLeft"></div>
    <div class="ms-aside-overlay ms-overlay-right">
        <a href="javascript:;"><img src="{{ asset('portal/img/circle-left.png') }}" alt=""></a>
    </div>
    <div id="notifBackdrop" class="notif-backdrop"></div>
    <!-- Sidebar Navigation Left -->
    <aside id="ms-side-nav" class="side-nav fixed ms-aside-scrollable ms-aside-left">
        <!-- Logo -->
        <div class="logo-sn ms-d-block-lg">
            <a class="pl-0 ml-0 text-center" href="{{ route('artist.dashboard') }}">
                <img src="{{ asset('img/logo.png') }}" alt="logo">
            </a>
        </div>
        <!-- Navigation -->
        <ul class="accordion ms-main-aside fs-14" id="side-nav-accordion">
            <li class="menu-item">
                <a href="{{ route('artist.dashboard') }}">
                    <span><img src="{{ asset('portal/img/box.png') }}" alt="">Dashboard</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('artist.profile.edit') }}">
                    <span><img src="{{ asset('portal/img/box.png') }}" alt="">Update Profile</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('artist.faqs.edit') }}">
                    <span><img src="{{ asset('portal/img/box.png') }}" alt="">FAQs</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('artist.portfolio.edit') }}">
                    <span><img src="{{ asset('portal/img/box.png') }}" alt="">Portfolio</span>
                </a>
            </li>
        </ul>
    </aside>
    <div id="notificationSidebar" class="notification-sidebar">
        <div class="sidebar-header">
            <h5>Notifications</h5>
            <button id="closeNotifications">
                <i class="fa fa-times"></i>
            </button>
        </div>
        <div class="sidebar-content">
            <ul>
                <li>
                    <img src="{{ asset('portal/img/user-chat.png') }}" alt="">
                    <div class="notification-content">
                        <span>05 : 30</span>
                        <h6>Artist Approved Request</h6>
                        <p>Checkout available slot</p>
                    </div>
                </li>
                <li>
                    <img src="{{ asset('portal/img/user-chat.png') }}" alt="">
                    <div class="notification-content">
                        <span>05 : 30</span>
                        <h6>Artist Approved Request</h6>
                        <p>Checkout available slot</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <!-- Main Content -->
    <main class="body-content">
        <!-- Navigation Bar -->
        <nav class="navbar ms-navbar">
            <div class="ms-aside-toggler ms-toggler pl-0" data-target="#ms-side-nav" data-toggle="slideLeft">
                <span class="ms-toggler-bar bg-primary"></span>
                <span class="ms-toggler-bar bg-primary"></span>
                <span class="ms-toggler-bar bg-primary"></span>
            </div>
            <ul class="ms-nav-list ms-inline mb-0" id="ms-nav-options">
                <li class="ms-nav-item pr-0">
                    <a href="chat.php" class="text-disabled ms-has-notification">
                        <i class="flaticon-chat"></i>
                    </a>
                </li>
                <li class="ms-nav-item dropdown">
                    <a href="#" class="text-disabled ms-has-notification" id="notificationDropdown">
                        <i class="flaticon-bell"></i>
                    </a>
                </li>
                <li class="ms-nav-item ms-nav-user dropdown">
                    <a href="#" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="ms-user-img ms-img-round float-right"
                            src="{{ auth()->user()->artistProfile?->avatar
                                    ? asset('storage/'.auth()->user()->artistProfile->avatar)
                                    : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&size=80' }}" alt="people">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right user-dropdown" aria-labelledby="userDropdown">
                        <li class="dropdown-menu-header">
                            <h6 class="dropdown-header ms-inline m-0">
                                <span class="text-disabled">Welcome, {{ auth()->user()->name }}</span>
                            </h6>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li class="ms-dropdown-list">
                            <a class="media fs-14 p-2" href="{{ route('artist.profile.edit') }}">
                                <span><i class="flaticon-user mr-2"></i> Profile</span>
                            </a>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-menu-footer">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="media fs-14 p-2 btn btn-link text-start w-100">
                                    <i class="flaticon-shut-down mr-2"></i> Logout</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="ms-toggler ms-d-block-sm pr-0 ms-nav-toggler" data-toggle="slideDown" data-target="#ms-nav-options">
                <span class="ms-toggler-bar bg-primary"></span>
                <span class="ms-toggler-bar bg-primary"></span>
                <span class="ms-toggler-bar bg-primary"></span>
            </div>
        </nav>
        <!-- Body Content Wrapper -->
        <div class="ms-content-wrapper">
            @yield('content')
        </div>
    </main>
    <!-- MODALS -->
    <!-- Reminder Modal -->
    <div class="modal fade" id="reminder-modal" tabindex="-1" role="dialog" aria-labelledby="reminder-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-secondary">
                    <h5 class="modal-title has-icon text-white"> New Reminder</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="ms-form-group">
                            <label>Remind me about</label>
                            <textarea class="form-control" name="reminder"></textarea>
                        </div>
                        <div class="ms-form-group">
                            <span class="ms-option-name fs-14">Repeat Daily</span>
                            <label class="ms-switch float-right">
                            <input type="checkbox">
                            <span class="ms-switch-slider round"></span>
                            </label>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="ms-form-group">
                                    <input type="text" class="form-control datepicker" name="reminder-date" value="" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="ms-form-group">
                                    <select class="form-control" name="reminder-time">
                                        <option value="">12:00 pm</option>
                                        <option value="">1:00 pm</option>
                                        <option value="">2:00 pm</option>
                                        <option value="">3:00 pm</option>
                                        <option value="">4:00 pm</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-secondary shadow-none" data-dismiss="modal">Add Reminder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Notes Modal -->
    <div class="modal fade" id="notes-modal" tabindex="-1" role="dialog" aria-labelledby="notes-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-secondary">
                    <h5 class="modal-title has-icon text-white" id="NoteModal">New Note</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="ms-form-group">
                            <label>Note Title</label>
                            <input type="text" class="form-control" name="note-title" value="">
                        </div>
                        <div class="ms-form-group">
                            <label>Note Description</label>
                            <textarea class="form-control" name="note-description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-secondary shadow-none" data-dismiss="modal">Add Note</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <aside id="ms-request-send" class="side-nav fixed ms-aside-right ms-scrollable">
        <div class="ms-aside-body">
            <div class="booking-details">
                <div class="booking-information">
                    <h3>Request Details</h3>
                </div>
                <div class="booking-images">
                    <img src="{{ asset('portal/img/booking-img-1.png') }}" alt="">
                    <img src="{{ asset('portal/img/booking-img-1.png') }}" alt="">
                    <img src="{{ asset('portal/img/booking-img-1.png') }}" alt="">
                </div>
                <div class="booking-box">
                    <h6>Tattoo Type</h6>
                    <p>Lorem Ipsum is simply dummy text of the printing.</p>
                </div>
                <div class="booking-box">
                    <h6>Tattoo Color</h6>
                    <p>Lorem Ipsum is simply dummy text of the printing.</p>
                </div>
                <div class="booking-box">
                    <h6>Tattoo Size</h6>
                    <p>Lorem Ipsum is simply dummy text of the printing.</p>
                </div>
                <div class="booking-box">
                    <h6>Tattoo Style</h6>
                    <p>Lorem Ipsum is simply dummy text of the printing.</p>
                </div>
                <div class="booking-box">
                    <h6>Additional Notes</h6>
                    <p>Lorem Ipsum is simply dummy text of the printing.Lorem Ipsum is simply dummy text of the printing.Lorem Ipsum is simply dummy text of the printing.Lorem Ipsum is simply dummy text of the printing.</p>
                </div>
            </div>
        </div>
        <div class="booking-designer">
            <div class="designer-info">
                <img src="{{ asset('portal/img/design-user-img.png') }}" alt="">
                <h2>Ink by Nova <span>@inkbynova</span></h2>
            </div>
            <div class="designer-msg">
                <a href="chat.php">
                    <img src="{{ asset('portal/img/message-text.png') }}" alt="">
                </a>
            </div>
        </div>
    </aside>

    <aside id="ms-recent-activity" class="side-nav fixed ms-aside-right ms-scrollable">
        <div class="ms-aside-body">
            <div class="booking-details">
                <div class="booking-information">
                    <h3>Booked</h3>
                    <h3><a href="javascript:;" class="cancel-booking">Cancel Booking</a></h3>
                </div>
                <div class="booking-images">
                    <img src="{{ asset('portal/img/booking-img-1.png') }}" alt="">
                    <img src="{{ asset('portal/img/booking-img-1.png') }}" alt="">
                    <img src="{{ asset('portal/img/booking-img-1.png') }}" alt="">
                </div>
                <div class="booking-box">
                    <h6>Tattoo Type</h6>
                    <p>Lorem Ipsum is simply dummy text of the printing.</p>
                </div>
                <div class="booking-box">
                    <h6>Tattoo Color</h6>
                    <p>Lorem Ipsum is simply dummy text of the printing.</p>
                </div>
                <div class="booking-box">
                    <h6>Tattoo Size</h6>
                    <p>Lorem Ipsum is simply dummy text of the printing.</p>
                </div>
                <div class="booking-box">
                    <h6>Tattoo Style</h6>
                    <p>Lorem Ipsum is simply dummy text of the printing.</p>
                </div>
                <div class="booking-box">
                    <h6>Additional Notes</h6>
                    <p>Lorem Ipsum is simply dummy text of the printing.Lorem Ipsum is simply dummy text of the printing.Lorem Ipsum is simply dummy text of the printing.Lorem Ipsum is simply dummy text of the printing.</p>
                </div>
                <div class="booking-timing">
                    <ul>
                        <li>
                            <h6>Time</h6>
                            <p>Monday (9am to 12 pm )</p>
                        </li>
                        <li>
                            <h6>Hours</h6>
                            <p>1- 2</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="booking-cancel">
                <a href="javascript:;" class="back-to-details"><img src="{{ asset('portal/img/circle-left.png') }}" alt=""></a>
                <div class="booking-information">
                    <h3>Cancel Reason</h3>
                </div>
                <p>Select a reason for cancelling this booking.</p>
                <form action="">
                    <div class="form-group">
                        <label for="">Select Reason</label>
                        <select class="form-control" id="exampleSelect">
                            <option value="" disabled selected>Select a reason</option>

                            <optgroup label="Client Reasons">
                                <option value="change_of_mind">Change of mind</option>
                                <option value="scheduling_conflict">Scheduling conflict</option>
                                <option value="found_another_artist">Found another artist</option>
                                <option value="budget_constraints">Budget constraints</option>
                                <option value="design_not_finalized">Design not finalized</option>
                                <option value="need_more_time">Need more time to decide</option>
                                <option value="personal_reasons">Personal reasons</option>
                                <option value="health_related_concern">Health-related concern</option>
                                <option value="travel_issues">Travel issues</option>
                            </optgroup>

                            <optgroup label="Artist / Studio Reasons">
                                <option value="artist_unavailable">Artist unavailable</option>
                                <option value="design_revisions_needed">Design revisions needed</option>
                                <option value="equipment_or_studio_issue">Equipment or studio issue</option>
                                <option value="rescheduled_by_artist">Rescheduled by artist</option>
                            </optgroup>

                            <optgroup label="Booking / System">
                                <option value="incorrect_booking_details">Incorrect booking details</option>
                                <option value="duplicate_booking">Duplicate booking</option>
                                <option value="payment_issue">Payment issue</option>
                            </optgroup>

                            <optgroup label="General">
                                <option value="emergency_situation">Emergency situation</option>
                                <option value="weather_or_transportation_issue">Weather or transportation issue</option>
                                <option value="no_longer_needed">No longer needed</option>
                                <option value="other">Other</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea name="" id="" class="form-control"></textarea>
                    </div>
                    <button class="btn btn-black">Submit</button>
                </form>
            </div>
        </div>
        <div class="booking-designer">
            <div class="designer-info">
                <img src="{{ asset('portal/img/design-user-img.png') }}" alt="">
                <h2>Ink by Nova <span>@inkbynova</span></h2>
            </div>
            <div class="designer-msg">
                <a href="chat.php">
                    <img src="{{ asset('portal/img/message-text.png') }}" alt="">
                </a>
            </div>
        </div>
    </aside>
    <!-- Global Required Scripts Start -->
    <script src="{{ asset('portal/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('portal/js/popper.min.js') }}"></script>
    <script src="{{ asset('portal/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('portal/js/perfect-scrollbar.js') }}"> </script>
    <script src="{{ asset('portal/js/jquery-ui.min.js') }}"> </script>
    <!-- Global Required Scripts End -->
    <!-- Page Specific Scripts Start -->
    <script src="{{ asset('portal/js/slick.min.js') }}"> </script>
    <script src="{{ asset('portal/js/moment.js') }}"> </script>
    <script src="{{ asset('portal/js/Chart.bundle.min.js') }}"> </script>
    <!-- Page Specific Scripts Finish -->
    <!-- Mystic core JavaScript -->
    <script src="{{ asset('portal/js/framework.js') }}"></script>
    <!-- Settings -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <script src="{{ asset('portal/js/settings.js') }}"></script>
    @stack('scripts')
</body>
</html>