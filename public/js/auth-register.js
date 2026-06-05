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

        const { status, body } = await post(regUrl('/profile'), new FormData(profileForm), true);

        if (status === 200) {
            hide('profileModal');
            show('accountModal');
        } else if (status === 422) {
            renderFieldErrors(profileForm, body.errors ?? {});
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
        errBox.classList.add('d-none');

        const btn = loginForm.querySelector('button[type="submit"]');
        startLoading(btn);

        const f = e.target;
        try {
            const { status, body } = await post('/login', {
                email:    f.login_email.value,
                password: f.login_password.value,
            });

            if (status === 200 && body.redirect) {
                // server tells us where to go (artist dashboard, etc.)
                window.location.href = body.redirect;
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
});