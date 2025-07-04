<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 50%, #f1c40f 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .forgot-password-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(46, 204, 113, 0.2);
            width: 100%;
            max-width: 450px;
            border: 2px solid rgba(46, 204, 113, 0.3);
        }

        .forgot-password-header h1 {
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

        .forgot-password-header p {
            color: #666;
            font-size: 1.1em;
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

        .btn-submit {
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

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(39, 174, 96, 0.4);
            background: linear-gradient(135deg, #2ecc71, #f39c12);
        }

        .btn-submit:active {
            transform: translateY(0);
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
    </style>
</head>
<body>
    <div class="forgot-password-container">
        <div class="forgot-password-header">
            <h1>Mot de passe oublié</h1>
            <p>Entrez votre adresse e-mail pour recevoir un lien de réinitialisation</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="votre@email.com" required autocomplete="email">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-paper-plane"></i>
                Envoyer le lien de réinitialisation
            </button>
        </form>
    </div>
</body>
</html>
