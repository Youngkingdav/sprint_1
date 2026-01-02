<?php
session_start();
require_once __DIR__ . '/core/Database.php';

$pdo = Database::getInstance();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($email === '' || $password === '') {
        $error = "Veuillez remplir tous les champs.";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Comparaison simple car mot de passe en clair pour test
                if ($password === $user['mot_de_passe']) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role_id'] = $user['role_id']; 

                    // Redirection vers la page espaces du routeur
                    header("Location: ../public/index.php?page=espaces");
                    exit;
                } else {
                    $error = "Email ou mot de passe incorrect.";
                }
            } else {
                $error = "Email ou mot de passe incorrect.";
            }
        } catch (PDOException $e) {
            $error = "Erreur de connexion à la base de données.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - HEROS TECH Espaces Pédagogiques</title>
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-blue: #2563EB;
            --dark-blue: #1E3A8A;
            --gold: #F59E0B;
            --light-bg: #F8FAFC;
            --shadow: 0 20px 40px rgba(0,0,0,0.1);
            --shadow-hover: 0 25px 50px rgba(0,0,0,0.15);
        }
        
        * {
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-attachment: fixed;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin: 0;
        }
        
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: var(--shadow);
            width: 100%;
            max-width: 420px;
            padding: 2.5rem;
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
        }
        
        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--gold), var(--primary-blue));
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        
        .login-logo {
            width: 85px;
            height: 85px;
            background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 12px 35px rgba(37, 99, 235, 0.3);
            position: relative;
        }
        
        .login-logo::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 15px solid transparent;
            border-right: 15px solid transparent;
            border-top: 15px solid var(--primary-blue);
        }
        
        .login-logo i {
            font-size: 2.6rem;
            color: white;
        }
        
        .login-title {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--dark-blue);
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .login-subtitle {
            color: #64748b;
            font-size: 0.95rem;
            margin: 0;
            font-weight: 500;
        }
        
        .form-floating {
            margin-bottom: 1.5rem;
        }
        
        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            padding: 1.1rem 1.3rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(12px);
            height: 60px;
        }
        
        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.3rem rgba(37, 99, 235, 0.15);
            background: white;
            transform: translateY(-2px);
        }
        
        .form-floating > label {
            color: #64748b;
            font-weight: 500;
            padding-left: 1.3rem;
            transform: translateY(0.5rem);
        }
        
        .btn-login {
            background: linear-gradient(135deg, var(--gold), #D97706);
            border: none;
            border-radius: 14px;
            padding: 1.1rem 2.2rem;
            font-size: 1.1rem;
            font-weight: 700;
            width: 100%;
            box-shadow: 0 12px 30px rgba(245, 158, 11, 0.4);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-transform: uppercase;
            letter-spacing: 1px;
            height: 60px;
        }
        
        .btn-login:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(245, 158, 11, 0.5);
            color: white !important;
        }
        
        .btn-login:active {
            transform: translateY(-2px);
        }
        
        .alert-error {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            border: 1px solid #fecaca;
            border-radius: 14px;
            color: #dc2626;
            padding: 1.1rem 1.3rem;
            margin-bottom: 1.8rem;
            animation: shake 0.6s cubic-bezier(0.36, 0.07, 0.19, 0.97);
            border-left: 5px solid #ef4444;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-4px); }
            20%, 40%, 60%, 80% { transform: translateX(4px); }
        }
        
        .features {
            margin-top: 2.2rem;
            padding-top: 2rem;
            border-top: 2px solid #e2e8f0;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            color: #64748b;
            font-size: 0.92rem;
        }
        
        .feature-item i {
            color: var(--primary-blue);
            margin-right: 0.9rem;
            width: 22px;
            font-size: 1.1rem;
        }
        
        .loading {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        
        @media (max-width: 480px) {
            body {
                padding: 10px;
            }
            
            .login-container {
                margin: 0.5rem;
                padding: 2rem 1.8rem;
            }
            
            .login-title {
                font-size: 1.6rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container position-relative">
        <!-- En-tête -->
        <div class="login-header">
            <div class="login-logo">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <h1 class="login-title">HEROS TECH</h1>
            <p class="login-subtitle">Portail des Espaces Pédagogiques</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger alert-error">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <!-- Formulaire de connexion -->
        <form method="POST" action="" novalidate>
            <div class="form-floating position-relative">
                <input type="email" class="form-control" id="email" name="email" placeholder="email@exemple.com" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                <label for="email">
                    <i class="bi bi-envelope me-2"></i>
                    Adresse email
                </label>
            </div>
            
            <div class="form-floating position-relative">
                <input type="password" class="form-control" id="password" name="password" placeholder="Votre mot de passe" required>
                <label for="password">
                    <i class="bi bi-lock-fill me-2"></i>
                    Mot de passe
                </label>
            </div>
            
            <button type="submit" class="btn btn-warning btn-login position-relative overflow-hidden">
                <span class="btn-text">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    Se connecter
                </span>
                <div class="loading">
                    <i class="fas fa-spinner fa-spin me-2"></i>
                    Connexion...
                </div>
            </button>
        </form>

        <!-- Fonctionnalités mises en avant -->
        <div class="features">
            <div class="feature-item">
                <i class="fas fa-shield-alt"></i>
                Connexion sécurisée
            </div>
            <div class="feature-item">
                <i class="fas fa-database"></i>
                Gestion des espaces pédagogiques
            </div>
        
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const btn = document.querySelector('.btn-login');
            const btnText = btn.querySelector('.btn-text');
            const loading = btn.querySelector('.loading');
            
            // Focus automatique
            emailInput.focus();
            
            // Navigation clavier optimisée
            emailInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    passwordInput.focus();
                }
            });
            
            passwordInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    btn.click();
                }
            });
            
            // Animation de soumission
            form.addEventListener('submit', function() {
                btnText.style.display = 'none';
                loading.style.display = 'inline-flex';
                btn.disabled = true;
            });
            
            // Pré-remplissage email si erreur
            if (emailInput.value) {
                setTimeout(() => passwordInput.focus(), 100);
            }
        });
    </script>
</body>
</html>
