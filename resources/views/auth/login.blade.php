<x-parent-layout :class="'login-wrapper'">
    @section('title', 'Login')

    <div class="container">
        <div class="row min-vh-100 justify-content-center align-items-center">
            <div class="col-md-6 col-lg-5">
                <div class="login-card p-4">
                    <!-- Logo Section -->
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mb-3" style="max-height: 60px;">
                        <h4 class="text-dark mb-1">Welcome Back!</h4>
                        <p class="text-muted small">Please login to your account</p>
                    </div>

                    <div class="card-body px-0">
                        <form method="POST" action="{{ route('login') }}" class="login-form">
                            @csrf

                            <!-- Email Field -->
                            <div class="mb-4">
                                <label for="email" class="form-label small fw-semibold">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-envelope text-muted"></i>
                                    </span>
                                    <input id="email" type="email"
                                        class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" placeholder="Enter your email"
                                        required autocomplete="email" autofocus>
                                </div>
                                @error('email')
                                    <span class="invalid-feedback d-block mt-1" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Password Field -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="password" class="form-label small fw-semibold">Password</label>
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}"
                                            class="text-primary small text-decoration-none">
                                            Forgot Password?
                                        </a>
                                    @endif
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-lock text-muted"></i>
                                    </span>
                                    <input id="password" type="password"
                                        class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror"
                                        name="password" placeholder="Enter your password" required
                                        autocomplete="current-password">

                                </div>
                                @error('password')
                                    <span class="invalid-feedback d-block mt-1" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input custom-checkbox" type="checkbox" name="remember"
                                        id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="remember">
                                        Keep me logged in
                                    </label>
                                </div>
                            </div>

                            <!-- Login Button -->
                            <div class="mb-4">
                                <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login to Account
                                </button>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-parent-layout>
