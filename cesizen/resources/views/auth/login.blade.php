<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Connexion</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 50%, #f1c40f 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(46, 204, 113, 0.2);
            width: 100%;
            max-width: 450px;
            border: 2px solid rgba(46, 204, 113, 0.3);
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h1 {
            color: #333;
            font-size: 2.5em;
            font-weight: 700;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #27ae60, #f1c40f);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .login-header p {
            color: #666;
            font-size: 1.1em;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 0.95em;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e8f5e8;
            border-radius: 12px;
            font-size: 1em;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        .form-control:focus {
            outline: none;
            border-color: #27ae60;
            box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.1);
            background: white;
        }

        .form-control.is-invalid {
            border-color: #e74c3c;
        }

        .invalid-feedback {
            display: block;
            color: #e74c3c;
            font-size: 0.875em;
            margin-top: 5px;
        }

        .password-input {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #666;
            cursor: pointer;
            font-size: 1.1em;
            padding: 5px;
        }

        .toggle-password:hover {
            color: #27ae60;
        }

        .form-check {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 25px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            margin: 0;
        }

        .form-check-label {
            color: #555;
            font-size: 0.9em;
            margin: 0;
        }

        .forgot-password {
            color: #27ae60;
            text-decoration: none;
            font-size: 0.9em;
            font-weight: 600;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #27ae60, #f1c40f);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 10px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(39, 174, 96, 0.4);
            background: linear-gradient(135deg, #2ecc71, #f39c12);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .divider {
            text-align: center;
            margin: 25px 0;
            position: relative;
            color: #666;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(46, 204, 113, 0.3), transparent);
        }

        .divider span {
            background: white;
            padding: 0 15px;
            font-size: 0.9em;
        }

        .register-link {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid rgba(46, 204, 113, 0.3);
        }

        .register-link p {
            color: #666;
            margin: 0;
        }

        .register-link a {
            color: #27ae60;
            text-decoration: none;
            font-weight: 600;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 12px 16px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-size: 0.9em;
        }

        .alert-danger {
            background-color: #fdf2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
        }

        .alert-success {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #16a34a;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .login-container {
                padding: 25px 20px;
                margin: 0;
                border-radius: 15px;
                max-width: 100%;
                box-shadow: 0 10px 25px rgba(46, 204, 113, 0.15);
            }

            .login-header h1 {
                font-size: 2em;
                margin-bottom: 8px;
            }

            .login-header p {
                font-size: 1em;
            }

            .form-group {
                margin-bottom: 18px;
            }

            .form-control {
                padding: 14px 16px;
                font-size: 16px; /* Évite le zoom sur iOS */
            }

            .toggle-password {
                right: 15px;
                padding: 8px;
                font-size: 1.2em;
            }

            .btn-login {
                padding: 16px;
                font-size: 1.1em;
            }

            .form-check {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 20px 15px;
                border-radius: 12px;
            }

            .login-header h1 {
                font-size: 1.8em;
            }

            .login-header p {
                font-size: 0.9em;
            }

            .form-group {
                margin-bottom: 16px;
            }

            .form-control {
                padding: 12px 14px;
                border-radius: 10px;
            }

            .btn-login {
                padding: 14px;
                font-size: 1em;
                border-radius: 10px;
            }

            .password-input .toggle-password {
                right: 12px;
            }
        }

        @media (max-width: 360px) {
            .login-container {
                padding: 18px 12px;
            }

            .login-header {
                margin-bottom: 25px;
            }

            .login-header h1 {
                font-size: 1.6em;
            }

            .form-group {
                margin-bottom: 15px;
            }

            .form-control {
                padding: 12px;
                font-size: 15px;
            }

            .btn-login {
                padding: 12px;
                font-size: 0.95em;
            }

            .register-link {
                margin-top: 20px;
                padding-top: 15px;
            }
        }

        /* Amélioration du touch sur mobile */
        @media (hover: none) and (pointer: coarse) {
            .form-control:focus {
                border-color: #27ae60;
                box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.2);
            }

            .toggle-password {
                padding: 10px;
                min-height: 44px;
                min-width: 44px;
            }

            .btn-login:active {
                transform: translateY(1px);
                box-shadow: 0 4px 15px rgba(39, 174, 96, 0.3);
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Connexion</h1>
            <p>Connectez-vous à votre compte</p>
        </div>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       class="form-control @error('email') is-invalid @enderror"
                       placeholder="votre@email.com"
                       required
                       autocomplete="email">
                @error('email')
                    <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Mot de passe -->
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <div class="password-input">
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Votre mot de passe"
                           required
                           autocomplete="current-password">
                    <button type="button" class="toggle-password" onclick="togglePassword()">
                        <i class="fas fa-eye" id="eye-icon"></i>
                    </button>
                </div>
                @error('password')
                    <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Se souvenir de moi / Mot de passe oublié -->
            <div class="form-check">
                <div class="remember-me">
                    <input type="checkbox" 
                           id="remember" 
                           name="remember" 
                           class="form-check-input"
                           {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        Se souvenir de moi
                    </label>
                </div>
                <a href="{{ url('/forgot-password') }}" class="forgot-password">
                    Mot de passe oublié ?
                </a>
            </div>

            <!-- Bouton de connexion -->
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i>
                Se connecter
            </button>
        </form>

        <div class="divider">
            <span>ou</span>
        </div>

        <div class="register-link">
            <p>Vous n'avez pas de compte ? <a href="{{ url('/register') }}">Créez-en un</a></p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>