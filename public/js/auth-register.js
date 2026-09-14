document.addEventListener('DOMContentLoaded', () => {
    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    // remember which role the user picked in exampleModal
    let selectedRole = 'customer';
    document.querySelectorAll('.choose-role').forEach(link => {
        link.addEventListener('click', () => {
            selectedRole = link.dataset.role; // 'artist' or 'customer'
        });
    });

    const show = id => bootstrap.Modal.getOrCreateInstance(document.getElementById(id)).show();
    const hide = id => bootstrap.Modal.getOrCreateInstance(document.getElementById(id)).hide();

    async function post(url, data, isForm = false) {
        const res = await fetch(url, {
            method: 'POST',
            headers: isForm
                ? { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
                : { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json', 'Content-Type': 'application/json' },
            body: isForm ? data : JSON.stringify(data),
        });
        return { status: res.status, body: await res.json().catch(() => ({})) };
    }

    function clearErrors(form) {
        form.querySelectorAll('.field-error').forEach(el => {
            el.textContent = '';
            el.classList.remove('d-block');
        });
        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    }

    // Show spinner + disable button while a request runs
    function startLoading(btn) {
        if (!btn) return;
        btn.disabled = true;
        btn.dataset.original = btn.innerHTML;     // remember the label
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Please wait...`;
    }

    // Restore the button
    function stopLoading(btn) {
        if (!btn) return;
        btn.disabled = false;
        if (btn.dataset.original) btn.innerHTML = btn.dataset.original;
    }

    function renderFieldErrors(form, errors) {
        Object.entries(errors).forEach(([field, messages]) => {
            const slot = form.querySelector(`.field-error[data-error="${field}"]`);
            if (slot) {
                slot.textContent = messages[0];
                slot.classList.add('d-block');
            }
            const input = form.querySelector(`[name="${field}"]`);
            if (input) input.classList.add('is-invalid');
        });
    }

    // Build the route prefix from the chosen role (artist branch built now)
    const regUrl = (suffix = '') =>
        (selectedRole === 'artist' ? '/register/artist' : '/register/customer') + suffix;

    // ---------- STEP 1: Register ----------
    const registerForm = document.getElementById('registerForm');
    registerForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        clearErrors(registerForm);

        const btn = registerForm.querySelector('button[type="submit"]');
        startLoading(btn);

        const f = e.target;
        try {
            const { status, body } = await post(regUrl(), {
                name: f.name.value,
                username: f.username.value,
                email: f.email.value,
                phone: f.phone.value,
                password: f.password.value,
                password_confirmation: f.password_confirmation.value,
            });

            if (status === 200) {
                hide('registerModal');
                show('oneTimePassowrdModal');
            } else if (status === 422) {
                renderFieldErrors(registerForm, body.errors ?? {});
            } else {
                alert(body.message ?? 'Something went wrong.');
            }
        } finally {
            stopLoading(btn);   // always re-enable
        }
    });

    // ---------- STEP 2: OTP ----------
    const otpForm = document.getElementById('otpForm');
    otpForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        clearErrors(otpForm);

        const btn = otpForm.querySelector('button[type="submit"]');
        startLoading(btn);

        const otp = [...otpForm.querySelectorAll('.otp-digit')].map(i => i.value).join('');
        try {
            const { status, body } = await post(regUrl('/otp'), { otp });

            if (status === 200) {
                // ── CUSTOMER: logged in by the server, redirect to intended page ──
                if (selectedRole === 'customer') {
                    const intended = sessionStorage.getItem('intended_url');
                    sessionStorage.removeItem('intended_url');
                    window.location.href = intended || body.redirect || '/';
                    return;
                }

                // ── ARTIST: continue to the details step ──
                hide('oneTimePassowrdModal');
                show('registerationModal');

            } else if (status === 422) {
                renderFieldErrors(otpForm, body.errors ?? {});
                const slot = otpForm.querySelector('.field-error[data-error="otp"]');
                if (slot && !slot.textContent) {
                    slot.textContent = body.message ?? 'Invalid code.';
                    slot.classList.add('d-block');
                }
            }
        } finally {
            stopLoading(btn);
        }
    });

    // Resend code
    document.getElementById('resendOtp')?.addEventListener('click', async (e) => {
        e.preventDefault();
        await post(regUrl('/otp/resend'), {});
        // restart the visual timer that script.js owns
        document.getElementById('oneTimePassowrdModal')
            ?.dispatchEvent(new Event('shown.bs.modal'));
        alert('A new code has been sent to your email.');
    });

    // ---------- STEP 3: Details ----------
    const detailsForm = document.getElementById('detailsForm');
    detailsForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        clearErrors(detailsForm);
        const f = e.target;

        const { status, body } = await post(regUrl('/details'), {
            country_id: f.country_id.value,
            state_id: f.state_id.value,
            city_id: f.city_id.value,
        });

        if (status === 200) {
            hide('registerationModal');
            show('profileModal');
        } else if (status === 422) {
            renderFieldErrors(detailsForm, body.errors ?? {});
        }
    });

    // ---------- STEP 4: Profile ----------
    const profileForm = document.getElementById('profileForm');
    profileForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        clearErrors(profileForm);

        const btn = profileForm.querySelector('button[type="submit"]');
        startLoading(btn);

        try {
            const { status, body } = await post(regUrl('/profile'), new FormData(profileForm), true);

            if (status === 200) {
                hide('profileModal');
                show('galleryModal');          // ← was accountModal, now gallery
            } else if (status === 422) {
                renderFieldErrors(profileForm, body.errors ?? {});
            }
        } finally {
            stopLoading(btn);
        }
    });



    // Show / hide password (delegated)
    document.addEventListener('click', (e) => {
        const toggle = e.target.closest('.password-toggle');
        if (!toggle) return;
        const input = document.querySelector(`[name="${toggle.dataset.target}"]`);
        if (!input) return;
        const icon = toggle.querySelector('i');
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        icon.classList.toggle('fa-eye', !isHidden);
        icon.classList.toggle('fa-eye-slash', isHidden);
    });

    // ---------- LOGIN ----------
    const loginForm = document.getElementById('loginForm');
    loginForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        clearErrors(loginForm);
        const errBox = document.getElementById('loginError');
        errBox?.classList.add('d-none');

        const btn = loginForm.querySelector('button[type="submit"]');
        startLoading(btn);

        const f = e.target;
        try {
            const { status, body } = await post('/login', {
                email:    f.login_email.value,
                password: f.login_password.value,
            });

            if (status === 200 && body.redirect) {
                const intended = sessionStorage.getItem('intended_url');
                sessionStorage.removeItem('intended_url');
                window.location.href = intended || body.redirect;
            } else if (status === 422) {
                renderFieldErrors(loginForm, body.errors ?? {});
                if (body.message && !body.errors) {
                    errBox.textContent = body.message;
                    errBox.classList.remove('d-none');
                }
            } else {
                errBox.textContent = body.message ?? 'Login failed.';
                errBox.classList.remove('d-none');
            }
        } finally {
            stopLoading(btn);
        }
    });

    document.querySelectorAll('.request-gate').forEach(btn => {
        btn.addEventListener('click', function () {
            sessionStorage.setItem('intended_url', this.dataset.intended);
        });
    });

    document.addEventListener('click', function (e) {
        const guestBtn = e.target.closest('.favourite-guest-btn');
        if (!guestBtn) return;
        sessionStorage.setItem('intended_url', window.location.href);
        sessionStorage.setItem('pendingFavourite', guestBtn.dataset.artistId);
    });

    // "Create an account" from the login modal → always customer
    document.querySelectorAll('.goto-register-customer').forEach(link => {
        link.addEventListener('click', () => {
            selectedRole = 'customer';
        });
    });

    // ========== ARTIST EXTRA STEPS (6–10) ==========

    function makeSlotUploader(inputId, gridId) {
        const input = document.getElementById(inputId);
        const grid  = document.getElementById(gridId);
        if (!input || !grid) return null;

        let files = [];   // parallel to filled slots, in order
        const slots = [...grid.querySelectorAll('.upload-slot')];

        input.addEventListener('change', () => {
            Array.from(input.files).forEach(f => {
                if (files.length >= slots.length) return;             // grid full
                if (files.some(x => x.name === f.name && x.size === f.size)) return; // dedupe
                files.push(f);
            });
            sync();
            render();
        });

        function sync() {
            const dt = new DataTransfer();
            files.forEach(f => dt.items.add(f));
            input.files = dt.files;
        }

        function render() {
            slots.forEach((slot, i) => {
                // clear
                slot.classList.remove('filled');
                slot.querySelector('img')?.remove();
                slot.querySelector('.slot-remove')?.remove();

                if (files[i]) {
                    const url = URL.createObjectURL(files[i]);
                    const img = document.createElement('img');
                    img.src = url;
                    slot.appendChild(img);

                    const rm = document.createElement('button');
                    rm.type = 'button';
                    rm.className = 'slot-remove';
                    rm.innerHTML = '&times;';
                    rm.dataset.i = i;
                    slot.appendChild(rm);

                    slot.classList.add('filled');
                }
            });
        }

        grid.addEventListener('click', e => {
            const rm = e.target.closest('.slot-remove');
            if (!rm) return;
            e.stopPropagation();
            files.splice(parseInt(rm.dataset.i), 1);   // remove → others shift left
            sync();
            render();
        });

        return { count: () => files.length };
    }

    const galleryUp = makeSlotUploader('galleryInput', 'galleryPreviews');
    const flashUp   = makeSlotUploader('flashInput', 'flashPreviews');

    // ---------- STEP 6: Gallery ----------
    const galleryForm = document.getElementById('galleryForm');
    galleryForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        clearErrors(galleryForm);

        const btn = galleryForm.querySelector('button[type="submit"]');
        startLoading(btn);

        try {
            const { status, body } = await post('/register/artist/gallery', new FormData(galleryForm), true);
            if (status === 200) {
                hide('galleryModal');
                show('flashModal');
            } else if (status === 422) {
                renderFieldErrors(galleryForm, body.errors ?? {});
            }
        } finally {
            stopLoading(btn);
        }
    });

    // ---------- STEP 7: Flash Gallery ----------
    const flashForm = document.getElementById('flashForm');
    flashForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        clearErrors(flashForm);

        const btn = flashForm.querySelector('button[type="submit"]');
        startLoading(btn);

        try {
            const { status, body } = await post('/register/artist/flash', new FormData(flashForm), true);
            if (status === 200) {
                hide('flashModal');
                show('availabilityModal');
            } else if (status === 422) {
                renderFieldErrors(flashForm, body.errors ?? {});
            }
        } finally {
            stopLoading(btn);
        }
    });

    // toggle: show/hide the time ranges for a day
    document.querySelectorAll('.day-toggle').forEach(t => {
        t.addEventListener('change', function () {
            const wrap = this.closest('.avail-row').querySelector('.time-wrap');
            if (wrap) wrap.style.display = this.checked ? 'block' : 'none';
        });
    });

    // delegated: + adds another range, − removes one
    document.getElementById('availabilityRows')?.addEventListener('click', function (e) {
        // ADD a range
        const addBtn = e.target.closest('.range-add');
        if (addBtn) {
            const ranges = addBtn.closest('.ranges');
            const item = document.createElement('div');
            item.className = 'range-item d-flex align-items-center gap-2 mb-2';
            item.innerHTML = `
                <input type="time" class="form-control time-from" value="09:00">
                <span>To</span>
                <input type="time" class="form-control time-to" value="21:00">
                <button type="button" class="range-remove">&minus;</button>
            `;
            ranges.appendChild(item);
            return;
        }
        // REMOVE a range
        const rmBtn = e.target.closest('.range-remove');
        if (rmBtn) {
            rmBtn.closest('.range-item').remove();
        }
    });

    // STEP 8: submit — collect every range per day
    const availabilityForm = document.getElementById('availabilityForm');
    availabilityForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        clearErrors(availabilityForm);

        const btn = availabilityForm.querySelector('button[type="submit"]');
        startLoading(btn);

        const availability = [...document.querySelectorAll('.avail-row')].map(row => {
            const enabled = row.querySelector('.day-toggle').checked;
            const ranges = enabled
                ? [...row.querySelectorAll('.range-item')].map(item => ({
                    from: item.querySelector('.time-from').value,
                    to:   item.querySelector('.time-to').value,
                }))
                : [];
            return { day: row.dataset.day, enabled, ranges };
        });

        try {
            const { status, body } = await post('/register/artist/availability', { availability });
            if (status === 200) {
                hide('availabilityModal');
                show('socialModal');
            } else if (status === 422) {
                renderFieldErrors(availabilityForm, body.errors ?? {});
            }
        } finally {
            stopLoading(btn);
        }
    });

    // ---------- STEP 9: Social ----------
    const socialForm = document.getElementById('socialForm');
    socialForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        clearErrors(socialForm);

        const btn = socialForm.querySelector('button[type="submit"]');
        startLoading(btn);

        const f = e.target;
        try {
            const { status, body } = await post('/register/artist/social', {
                facebook:  f.facebook.value,
                instagram: f.instagram.value,
                twitter:   f.twitter.value,
                website:   f.website.value,
            });
            if (status === 200) {
                hide('socialModal');
                show('pricingModal');
            } else if (status === 422) {
                renderFieldErrors(socialForm, body.errors ?? {});
            }
        } finally {
            stopLoading(btn);
        }
    });

    // ---------- STEP 10: Pricing → final ----------
    const pricingForm = document.getElementById('pricingForm');
    pricingForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        clearErrors(pricingForm);

        const btn = pricingForm.querySelector('button[type="submit"]');
        startLoading(btn);

        try {
            const { status, body } = await post('/register/artist/pricing', {
                hourly_rate: e.target.hourly_rate.value,
            });
            if (status === 200) {
                hide('pricingModal');
                show('accountModal');       // STEP 11: Account Created!
            } else if (status === 422) {
                renderFieldErrors(pricingForm, body.errors ?? {});
            }
        } finally {
            stopLoading(btn);
        }
    });

    // guest clicked review → remember page + which artist (KEEP THIS)
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.review-btn');
        if (!btn) return;
        if (!btn.hasAttribute('data-bs-target')) return; // only guests have data-bs-target
        sessionStorage.setItem('intended_url', window.location.href);
        sessionStorage.setItem('pendingReview', JSON.stringify({
            id: btn.dataset.artistId,
            name: btn.dataset.artistName
        }));
    });

    // reopen review modal after login — IIFE runs now (DOM already ready)
    (function () {
        const raw = sessionStorage.getItem('pendingReview');
        if (!raw) return;
        sessionStorage.removeItem('pendingReview');

        const { id, name } = JSON.parse(raw);
        const idEl = document.getElementById('reviewArtistId');
        const nameEl = document.getElementById('reviewArtistName');
        if (!idEl || !nameEl) return;  // review modal not on this page

        idEl.value = id;
        nameEl.textContent = name;

        document.querySelectorAll('#reviewForm .field-error').forEach(el => el.textContent = '');
        document.getElementById('reviewError')?.classList.add('d-none');

        bootstrap.Modal.getOrCreateInstance(document.getElementById('reviewModal')).show();
    })();

    // open report modal (logged-in users only; guests get login modal)
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.report-btn');
        if (!btn) return;
        if (btn.hasAttribute('data-bs-target')) return; // guest → login modal
        e.preventDefault();

        document.getElementById('reportArtistId').value = btn.dataset.artistId;
        document.getElementById('reportArtistName').textContent = btn.dataset.artistName;

        document.querySelectorAll('#reportForm .field-error').forEach(el => el.textContent = '');
        document.getElementById('reportError').classList.add('d-none');

        bootstrap.Modal.getOrCreateInstance(document.getElementById('reportModal')).show();
    });

    // submit report
    document.getElementById('reportForm')?.addEventListener('submit', async function (e) {
        e.preventDefault();
        const id = document.getElementById('reportArtistId').value;
        const errBox = document.getElementById('reportError');
        errBox.classList.add('d-none');
        document.querySelectorAll('#reportForm .field-error').forEach(el => el.textContent = '');

        const res = await fetch(`/artist/${id}/report`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: new FormData(this),
        });

        const body = await res.json().catch(() => ({}));

        if (res.ok) {
            bootstrap.Modal.getInstance(document.getElementById('reportModal')).hide();
            this.reset();
            showFavouriteToast('Thank you. Our team will review this report.');
        } else if (res.status === 422 && body.errors) {
            Object.entries(body.errors).forEach(([field, msgs]) => {
                const slot = document.querySelector(`#reportForm .field-error[data-error="${field}"]`);
                if (slot) slot.textContent = msgs[0];
            });
        } else {
            errBox.textContent = body.message ?? 'Could not submit. Please try again.';
            errBox.classList.remove('d-none');
        }
    });

    // guest clicked report → remember page + artist
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.report-btn');
        if (!btn) return;
        if (!btn.hasAttribute('data-bs-target')) return; // only guests
        sessionStorage.setItem('intended_url', window.location.href);
        sessionStorage.setItem('pendingReport', JSON.stringify({
            id: btn.dataset.artistId,
            name: btn.dataset.artistName
        }));
    });

    // reopen report modal after login (IIFE — runs now)
    (function () {
        const raw = sessionStorage.getItem('pendingReport');
        if (!raw) return;
        sessionStorage.removeItem('pendingReport');

        const { id, name } = JSON.parse(raw);
        const idEl = document.getElementById('reportArtistId');
        const nameEl = document.getElementById('reportArtistName');
        if (!idEl || !nameEl) return;

        idEl.value = id;
        nameEl.textContent = name;

        document.querySelectorAll('#reportForm .field-error').forEach(el => el.textContent = '');
        document.getElementById('reportError')?.classList.add('d-none');

        bootstrap.Modal.getOrCreateInstance(document.getElementById('reportModal')).show();
    })();

});