<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Inventory Management System</title>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="styles.css" />
  </head>
  <body>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header text-center">Login</div>

            <div class="card-body">
              <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="row g-3">
                  <!-- Email Field -->
                  <div class="col-12">
                    <label for="email" class="form-label">Email Address</label>
                    <input
                      id="email"
                      type="email"
                      class="form-control @error('email') is-invalid @enderror"
                      name="email"
                      value="{{ old('email') }}"
                      required
                      autocomplete="email"
                      autofocus
                    />

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>

                  <!-- Password Field -->
                  <div class="col-12 position-relative">
                    <label for="password" class="form-label">Password</label>
                    <input
                      id="password"
                      type="password"
                      class="form-control @error('password') is-invalid @enderror"
                      name="password"
                      required
                      autocomplete="current-password"
                    />

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                  </div>

                  <!-- Remember Me Checkbox -->
                  <div class="col-12">
                    <div class="form-check">
                      <input
                        class="form-check-input"
                        type="checkbox"
                        name="remember"
                        id="remember"
                        {{ old('remember') ? 'checked' : '' }}
                      />
                      <label class="form-check-label" for="remember">
                        Remember Me
                      </label>
                    </div>
                  </div>

                  <!-- Submit Button -->
                  <div class="col-12">
                    <button type="submit" class="btn btn-primary w-100 py-2">
                      Login
                    </button>
                  </div>


                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>


</body>
</html>
