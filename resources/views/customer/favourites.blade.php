@extends('customer.layouts.app')
@section('title', 'My Tattoo Favourite Artists')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2 class="title border-title">Tattoo Favourite Artists</h2>
    </div>
</div>
<div class="favourite-artists-wrapper">
    <div class="row">
        <div class="col-md-3">
            <div class="favourite-artists-box">
                <img src="https://samplelinkweb.site/custom-html/tattoosaurus-front/user/img/favourite-artists-img-1.png" alt="">
                <h4>Riley Shade</h4>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                <a href="../tattoo-artist-details.php" class="btn btn-dark">more details</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="favourite-artists-box">
                <img src="https://samplelinkweb.site/custom-html/tattoosaurus-front/user/img/favourite-artists-img-1.png" alt="">
                <h4>Damien Trace</h4>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                <a href="../tattoo-artist-details.php" class="btn btn-dark">more details</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="favourite-artists-box">
                <img src="https://samplelinkweb.site/custom-html/tattoosaurus-front/user/img/favourite-artists-img-1.png" alt="">
                <h4>Ink by Nova</h4>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                <a href="../tattoo-artist-details.php" class="btn btn-dark">more details</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="favourite-artists-box">
                <img src="https://samplelinkweb.site/custom-html/tattoosaurus-front/user/img/favourite-artists-img-1.png" alt="">
                <h4>Ren Wolfe</h4>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                <a href="../tattoo-artist-details.php" class="btn btn-dark">more details</a>
            </div>
        </div>
    </div>
</div>
@endsection