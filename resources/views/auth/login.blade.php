<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - SysNISE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1e3a8a;
            --secondary-color: #3b82f6;
            --accent-color: #10b981;
            --dark-blue: #0f172a;
            --light-gray: #f8fafc;
        }

        body {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
            pointer-events: none;
        }

        .login-container {
            position: relative;
            z-index: 1;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .login-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            /*padding: 3rem 2rem;*/
            text-align: center;
            position: relative;
        }

        .login-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--accent-color);
        }

        .logo-container {
            margin-bottom: 1.5rem;
        }

        .logo-container img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: white;
            padding: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .system-title {
            color: white;
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            letter-spacing: 2px;
        }

        .system-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9rem;
            margin-top: 0.5rem;
            font-weight: 400;
        }

        .login-body {
            padding: 2.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-blue);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.1);
        }

        .input-group-text {
            background: transparent;
            border: 2px solid #e2e8f0;
            border-right: none;
            border-radius: 10px 0 0 10px;
            color: var(--secondary-color);
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }

        .input-group:focus-within .input-group-text {
            border-color: var(--secondary-color);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            border-radius: 10px;
            padding: 0.9rem;
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
        }

        .form-check-input:checked {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .form-check-label {
            color: #64748b;
            font-size: 0.9rem;
        }

        .alert-danger {
            border-radius: 10px;
            border: none;
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #dc2626;
        }

        .institutional-badge {
            background: rgba(16, 185, 129, 0.1);
            color: var(--accent-color);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
            margin-top: 1rem;
        }

        .footer-text {
            text-align: center;
            color: rgba(255, 255, 255, 0.8);
            margin-top: 2rem;
            font-size: 0.85rem;
        }

        @media (max-width: 768px) {
            .login-card {
                margin: 1rem;
            }
            
            .system-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>

<div class="container login-container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="login-card">
                <div class="login-header">
                    <div class="logo-container">
                        <img src="/img/logo.png" alt="Logo SysNISE" onerror="this.style.display='none'">
                    </div>
                    <h1 class="system-title">SysNISE</h1>
                    <p class="system-subtitle">Système National Intégré de Suivi Évaluation</p>
                    <div class="institutional-badge">
                        <i class="bi bi-shield-check"></i> Plateforme Officielle
                    </div>
                </div>
                
                <div class="login-body">
                    @if($errors->any())
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <div>{{ $errors->first() }}</div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope me-1"></i> Adresse e-mail
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-person-circle"></i>
                                </span>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       class="form-control" 
                                       placeholder="votre.email@example.com"
                                       required 
                                       autofocus 
                                       value="{{ old('email') }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">
                                <i class="bi bi-lock me-1"></i> Mot de passe
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-key-fill"></i>
                                </span>
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       class="form-control"
                                       placeholder="••••••••" 
                                       required>
                            </div>
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="remember" 
                                   id="remember">
                            <label class="form-check-label" for="remember">
                                Se souvenir de moi
                            </label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-login btn-primary text-white">
                                <i class="bi bi-box-arrow-in-right me-2"></i>
                                Se connecter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="footer-text">
                <i class="bi bi-shield-lock me-1"></i>
                Connexion sécurisée et cryptée
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
