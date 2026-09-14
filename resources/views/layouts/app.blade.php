<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <title>@yield('title', 'Tattoosaurus')</title>
    @stack('styles')
</head>
<body>

    @include('partials.sidebar')
    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.modals')

    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1090;">
        <div id="favouriteToast" class="toast align-items-center text-white border-0"
            role="alert" aria-live="assertive" aria-atomic="true"
            style="background-color: #2C2B2B;">
            <div class="d-flex">
                <div class="toast-body">
                    <span id="favouriteToastMsg"></span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto"
                        data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
    <script src="https://npmcdn.com/masonry-layout@4.0/dist/masonry.pkgd.min.js"></script>
    <script src="{{ asset('js/auth-register.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.board-btn');
            if (!btn) return;
            e.preventDefault();

            const artistName = btn.dataset.artistName || 'Artist';

            fetch("{{ route('customer.board.toggle') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    artist_id: btn.dataset.artistId,
                    image: btn.dataset.image
                })
            })
            .then(res => res.json())
            .then(data => {
                btn.classList.toggle('active', data.saved);
                const wrapper = btn.closest('.artist-bottom');
                if (wrapper) wrapper.classList.toggle('active', data.saved);

                if (data.saved) {
                    showFavouriteToast(`${artistName}'s design has been saved to your Board`);
                } else {
                    showFavouriteToast(`${artistName}'s design has been removed from your Board`);
                }
            })
            .catch(() => console.error('Failed to toggle board item'));
        });

        // guest: remember which image they tried to save
        document.addEventListener('click', function (e) {
            const guestBtn = e.target.closest('.board-guest-btn');
            if (!guestBtn) return;
            sessionStorage.setItem('pendingBoardItem', JSON.stringify({
                artistId: guestBtn.dataset.artistId,
                image: guestBtn.dataset.image
            }));
        });

        // call this after login/register succeeds
        function applyPendingBoardItem() {
            const raw = sessionStorage.getItem('pendingBoardItem');
            if (!raw) return;
            const { artistId, image } = JSON.parse(raw);

            fetch("{{ route('customer.board.toggle') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ artist_id: artistId, image: image })
            })
            .then(res => res.json())
            .then(() => {
                sessionStorage.removeItem('pendingBoardItem');
                window.location.reload();
            })
            .catch(() => console.error('Failed to apply pending board item'));
        }

        document.addEventListener('click', async function (e) {
            const btn = e.target.closest('.share-btn');
            if (!btn) return;
            e.preventDefault();
            const url = btn.dataset.shareUrl;
            const name = btn.dataset.shareName;

            if (navigator.share) {
                try { await navigator.share({ title: name + ' — Tattoosaurus', url }); } catch (_) {}
            } else {
                await navigator.clipboard.writeText(url);
                alert('Profile link copied to clipboard!');
            }
        });

        // guest clicked favourite → remember where they are + which artist
        document.addEventListener('click', function (e) {
            const guestBtn = e.target.closest('.favourite-guest-btn');
            if (!guestBtn) return;
            sessionStorage.setItem('intended_url', window.location.href);
            sessionStorage.setItem('pendingFavourite', guestBtn.dataset.artistId);
            sessionStorage.setItem('pendingFavouriteName', guestBtn.dataset.artistName || 'Artist');
        });

        function applyPendingFavourite() {
            const artistId = sessionStorage.getItem('pendingFavourite');
            if (!artistId) return;

            fetch(`/artists/${artistId}/favourite`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                const name = sessionStorage.getItem('pendingFavouriteName') || 'Artist';
                sessionStorage.removeItem('pendingFavourite');
                sessionStorage.removeItem('pendingFavouriteName');
                const btn = document.querySelector(`.favourite-btn[data-artist-id="${artistId}"]`);
                if (btn) btn.classList.toggle('active', data.favourited);
                if (data.favourited) showFavouriteToast(`${name} has been added to your Favourite Artists`);
            })
            .catch(() => console.error('Failed to apply pending favourite'));
        }

        // run on page load — after login redirect brings them back here
        document.addEventListener('DOMContentLoaded', applyPendingFavourite);

        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.favourite-btn');
            if (!btn) return;
            e.preventDefault();

            const artistId = btn.dataset.artistId;
            const artistName = btn.dataset.artistName || 'Artist';

            fetch(`/artists/${artistId}/favourite`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                btn.classList.toggle('active', data.favourited);
                // show toast with the right message
                if (data.favourited) {
                    showFavouriteToast(`${artistName} has been added to your Favourite Artists`);
                } else {
                    showFavouriteToast(`${artistName} has been removed from your Favourite Artists`);
                }
            })
            .catch(() => console.error('Failed to toggle favourite'));
        });
        // open review modal (logged-in customers only)
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.review-btn');
            if (!btn) return;
            if (btn.hasAttribute('data-bs-target')) return; // guest → login modal
            e.preventDefault();

            document.getElementById('reviewArtistId').value = btn.dataset.artistId;
            document.getElementById('reviewArtistName').textContent = btn.dataset.artistName;

            // clear previous errors
            document.querySelectorAll('#reviewForm .field-error').forEach(el => el.textContent = '');
            document.getElementById('reviewError').classList.add('d-none');

            bootstrap.Modal.getOrCreateInstance(document.getElementById('reviewModal')).show();
        });

        // submit review
        document.getElementById('reviewForm')?.addEventListener('submit', async function (e) {
            e.preventDefault();
            const id = document.getElementById('reviewArtistId').value;
            const errBox = document.getElementById('reviewError');
            errBox.classList.add('d-none');
            document.querySelectorAll('#reviewForm .field-error').forEach(el => el.textContent = '');

            const res = await fetch(`/artist/${id}/review`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: new FormData(this),
            });

            const body = await res.json().catch(() => ({}));

            if (res.ok) {
                bootstrap.Modal.getInstance(document.getElementById('reviewModal')).hide();
                this.reset();
                showFavouriteToast('Thanks for your review!');
            } else if (res.status === 422 && body.errors) {
                // render field errors into the slots
                Object.entries(body.errors).forEach(([field, msgs]) => {
                    const slot = document.querySelector(`#reviewForm .field-error[data-error="${field}"]`);
                    if (slot) slot.textContent = msgs[0];
                });
            } else {
                errBox.textContent = body.message ?? 'Could not submit. Please try again.';
                errBox.classList.remove('d-none');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>