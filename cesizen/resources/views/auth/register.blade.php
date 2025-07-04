<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Inscription</title>
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

        .register-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(46, 204, 113, 0.2);
            width: 100%;
            max-width: 500px;
            border: 2px solid rgba(46, 204, 113, 0.3);
        }

        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .register-header h1 {
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

        .register-header p {
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
            gap: 10px;
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

        .form-check-label a {
            color: #27ae60;
            text-decoration: none;
            font-weight: 600;
        }

        .form-check-label a:hover {
            text-decoration: underline;
        }

        .btn-register {
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

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(39, 174, 96, 0.4);
            background: linear-gradient(135deg, #2ecc71, #f39c12);
        }

        .btn-register:active {
            transform: translateY(0);
        }

        .login-link {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid rgba(46, 204, 113, 0.3);
        }

        .login-link p {
            color: #666;
            margin: 0;
        }

        .login-link a {
            color: #27ae60;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .register-container {
                padding: 25px 20px;
                margin: 0;
                border-radius: 15px;
                max-width: 100%;
                box-shadow: 0 10px 25px rgba(46, 204, 113, 0.15);
            }

            .register-header h1 {
                font-size: 2em;
                margin-bottom: 8px;
            }

            .register-header p {
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

            .btn-register {
                padding: 16px;
                font-size: 1.1em;
            }
        }

        @media (max-width: 480px) {
            .register-container {
                padding: 20px 15px;
                border-radius: 12px;
            }

            .register-header h1 {
                font-size: 1.8em;
            }

            .register-header p {
                font-size: 0.9em;
            }

            .form-group {
                margin-bottom: 16px;
            }

            .form-control {
                padding: 12px 14px;
                border-radius: 10px;
            }

            .btn-register {
                padding: 14px;
                font-size: 1em;
                border-radius: 10px;
            }

            .form-check {
                align-items: flex-start;
                gap: 8px;
            }

            .form-check-label {
                font-size: 0.85em;
                line-height: 1.4;
            }

            .password-input .toggle-password {
                right: 12px;
            }
        }

        @media (max-width: 360px) {
            .register-container {
                padding: 18px 12px;
            }

            .register-header {
                margin-bottom: 25px;
            }

            .register-header h1 {
                font-size: 1.6em;
            }

            .form-group {
                margin-bottom: 15px;
            }

            .form-control {
                padding: 12px;
                font-size: 15px;
            }

            .btn-register {
                padding: 12px;
                font-size: 0.95em;
            }

            .login-link {
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

            .btn-register:active {
                transform: translateY(1px);
                box-shadow: 0 4px 15px rgba(39, 174, 96, 0.3);
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <h1>Inscription</h1>
            <p>Créez votre compte pour commencer</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="register-form">
            @csrf

            <!-- Nom -->
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" 
                       id="nom" 
                       name="nom" 
                       value="{{ old('nom') }}" 
                       class="form-control @error('nom') is-invalid @enderror"
                       placeholder="Entrez votre nom"
                       required>
                @error('nom')
                    <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Prénom -->
            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" 
                       id="prenom" 
                       name="prenom" 
                       value="{{ old('prenom') }}" 
                       class="form-control @error('prenom') is-invalid @enderror"
                       placeholder="Entrez votre prénom"
                       required>
                @error('prenom')
                    <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       class="form-control @error('email') is-invalid @enderror"
                       placeholder="votre@email.com"
                       required>
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
                           placeholder="Mot de passe sécurisé"
                           required>
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

            <!-- Confirmation mot de passe -->
            <div class="form-group">
                <label for="password_confirmation">Confirmer le mot de passe</label>
                <input type="password" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       class="form-control"
                       placeholder="Confirmez votre mot de passe"
                       required>
            </div>

            <!-- Age -->
            <div class="form-group">
                <label for="age">Âge</label>
                <input type="number" 
                       id="age" 
                       name="age" 
                       value="{{ old('age') }}" 
                       class="form-control @error('age') is-invalid @enderror"
                       placeholder="Votre âge"
                       min="13"
                       max="120"
                       required>
                @error('age')
                    <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Conditions d'utilisation -->
            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" 
                           id="terms" 
                           name="terms" 
                           class="form-check-input @error('terms') is-invalid @enderror"
                           required>
                    <label class="form-check-label" for="terms">
                        J'accepte les <a href="#" onclick="return false;">conditions d'utilisation</a>
                    </label>
                    @error('terms')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <!-- Bouton d'inscription -->
            <button type="submit" class="btn-register">
                <i class="fas fa-user-plus"></i>
                S'inscrire
            </button>
        </form>

        <div class="login-link">
            <p>Vous avez déjà un compte ? <a href="{{ url('/login') }}">Connectez-vous</a></p>
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