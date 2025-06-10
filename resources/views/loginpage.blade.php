<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FABLAB - Login</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/loginpage.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container">
        <a href="{{ url('/') }}" class="back-button">
            <i class="fas fa-arrow-left"></i>
            <span>Back</span>
        </a>
        <div class="left-side">
            <div class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="FABLAB Logo" class="logo-img">
                <p>Innovation • Creation • Collaboration</p>
            </div>
            <!-- You can add some decorative elements or information here -->
        </div>

        <div class="right-side">
            <div class="auth-tabs">
                <button class="tab-btn active" onclick="switchTab('login')">Login</button>
                <button class="tab-btn" onclick="switchTab('register')">Register</button>
            </div>

            <!-- Login Form -->
            <div id="login-form" class="form-section active">
                <form action="{{ route('google.login') }}">
                    @csrf
                    <button type="submit" class="google-btn">
                        <div class="google-icon"></div>
                        Continue with Google
                    </button>
                </form>

                <div class="divider">
                    <span>or login with email</span>
                </div>

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="login-email">Email Address</label>
                        <input type="email" id="login-email" name="email" required value="{{ old('email') }}">
                        @error('email')
                            <span class="error" style="color: red; font-size: 0.8rem;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="login-password">Password</label>
                        <div class="input-wrapper">
                            <input type="password" id="login-password" name="password" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('login-password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="error" style="color: red; font-size: 0.8rem;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="recaptcha-container">
                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                        @error('g-recaptcha-response')
                            <span class="error" style="color: red; font-size: 0.8rem;">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="submit-btn">Sign In</button>
                </form>

                <div class="forgot-password">
                    <a href="#" onclick="showForgotPassword()">Forgot your password?</a>
                </div>
            </div>

            <!-- Register Form -->
            <div id="register-form" class="form-section">
                <form action="{{ route('google.login') }}" >
                    @csrf
                    <button type="submit" class="google-btn">
                        <div class="google-icon"></div>
                        Sign Up with Google
                    </button>
                </form>

                <div class="divider">
                    <span>or create account</span>
                </div>

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="register-name">User Name</label>
                        <input type="text" id="register-name" name="name" required value="{{ old('name') }}">
                        @error('name')
                            <span class="error" style="color: red; font-size: 0.8rem;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="register-email">Email Address</label>
                        <input type="email" id="register-email" name="email" required value="{{ old('email') }}">
                        @error('email')
                            <span class="error" style="color: red; font-size: 0.8rem;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="register-password">Password</label>
                        <div class="input-wrapper">
                            <input type="password" id="register-password" name="password" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('register-password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="error" style="color: red; font-size: 0.8rem;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="confirm-password">Confirm Password</label>
                        <div class="input-wrapper">
                            <input type="password" id="confirm-password" name="password_confirmation" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('confirm-password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="submit-btn">Create Account</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tab) {
            // Update tab buttons
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');

            // Switch forms
            document.querySelectorAll('.form-section').forEach(section => section.classList.remove('active'));
            document.getElementById(tab + '-form').classList.add('active');
        }

        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = event.target.closest('.password-toggle').querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Simple form submission handler
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Show loading toast
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });

                Toast.fire({
                    icon: 'info',
                    title: 'Processing...'
                });

                // Submit form
                form.submit();
            });
        });

        // Toast notification function
        const showToast = (icon, message) => {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: icon,
                title: message
            });
        };

        // Show alerts for session messages
        @if(session('success'))
            showToast('success', '{{ session('success') }}');
        @endif

        @if(session('error'))
            showToast('error', '{{ session('error') }}');
        @endif

        @if($errors->any())
            showToast('error', '{{ $errors->first() }}');
        @endif
    </script>
</body>
</html>