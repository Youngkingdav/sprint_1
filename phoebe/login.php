<?php 
session_start(); 
include 'config.php';

if (isset($_GET['logout'])) { session_destroy(); header('Location: login.php'); exit(); }

$error = '';
if ($_POST) {
    $stmt = $pdo->prepare("SELECT u.id, u.nom, r.nom as role FROM utilisateurs u JOIN roles r ON u.role_id = r.id WHERE email = ? AND mot_de_passe = ?");
    $stmt->execute([$_POST['email'], $_POST['password']]);
    $user = $stmt->fetch();
    
    if ($user && $user['role'] == 'directeur') {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nom'] = $user['nom'];
        $_SESSION['role'] = 'directeur';
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "❌ Identifiants invalides ou pas de droits directeur";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Directeur Espaces Pédagogiques</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #667eea; --secondary: #764ba2; --danger: #ff4757; --success: #2ed573;
            --bg-primary: #f0f2f5; --bg-secondary: #ffffff; --text-primary: #1a1a2e; --text-secondary: #6c757d;
        }
        [data-theme="dark"] {
            --bg-primary: #0f0f23; --bg-secondary: #1a1a2e; --text-primary: #ffffff; --text-secondary: #adb5bd;
        }
        [data-theme="beige"] {
            --bg-primary: #fdf6e3; --bg-secondary: #fff8dc; --text-primary: #5d4037; --text-secondary: #8d6e63;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, sans-serif; 
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); 
            min-height: 100vh; display: flex; align-items: center; justify-content: center; 
            padding: 1rem;
        }
        .login-container { 
            background: var(--bg-secondary); padding: 3rem 2.5rem; border-radius: 25px; 
            box-shadow: 0 25px 60px rgba(0,0,0,0.2); text-align: center; max-width: 420px; width: 100%; 
            border: 1px solid rgba(255,255,255,0.2); backdrop-filter: blur(10px);
            animation: slideIn 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        @keyframes slideIn { from { opacity: 0; transform: translateY(40px) scale(0.95); } to { opacity: 1; transform: translateY(0) scale(1); } }
        .login-header { margin-bottom: 2rem; }
        .login-header i { font-size: 3.5rem; color: var(--primary); margin-bottom: 1rem; display: block; filter: drop-shadow(0 5px 15px rgba(102,126,234,0.3)); }
        .login-header h2 { color: var(--text-primary); font-size: 1.8rem; font-weight: 700; margin-bottom: 0.5rem; }
        .error { background: var(--danger); color: white; padding: 12px 20px; border-radius: 12px; margin-bottom: 1.5rem; font-weight: 500; animation: shake 0.5s; display: none; }
        .error.show { display: block; }
        @keyframes shake { 0%,100%{transform:translateX(0);} 25%{transform:translateX(-5px);} 75%{transform:translateX(5px);} }
        
        .form-group { position: relative; margin-bottom: 1.5rem; text-align: left; }
        label { display: block; margin-bottom: 8px; color: var(--text-secondary); font-weight: 500; font-size: 0.95rem; }
        input { width: 100%; padding: 16px 20px 16px 50px; border: 2px solid var(--border); border-radius: 15px; font-size: 16px; transition: all 0.3s; background: rgba(255,255,255,0.9); color: var(--text-primary); }
        input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 4px rgba(102,126,234,0.1); background: white; transform: translateY(-2px); }
        .password-toggle { 
            position: absolute; right: 15px; top: 50%; transform: translateY(-50%); 
            background: none; border: none; color: var(--text-secondary); cursor: pointer; 
            font-size: 1.2rem; padding: 5px; transition: all 0.3s;
        }
        .password-toggle:hover { color: var(--primary); transform: translateY(-50%) scale(1.1); }
        
        .btn-login { 
            width: 100%; background: linear-gradient(45deg, var(--primary), var(--secondary)); 
            color: white; border: none; padding: 18px; border-radius: 25px; cursor: pointer; 
            font-size: 1.1rem; font-weight: 700; transition: all 0.4s; 
            box-shadow: 0 10px 30px rgba(102,126,234,0.4); margin-top: 1rem;
        }
        .btn-login:hover { transform: translateY(-3px); box-shadow: 0 20px 40px rgba(102,126,234,0.5); }
        .btn-login:active { transform: translateY(-1px); }
    </style>
</head>
<body data-theme="light">
    <div class="login-container">
        <div class="login-header">
            <i class="fas fa-graduation-cap"></i>
            <h2>🔐 Connexion Directeur</h2>
        </div>
        
        <?php if ($error): ?>
            <div class="error show"><?= $error ?></div>
        <?php endif; ?>
        
        <form method="POST" id="loginForm">
            <div class="form-group">
                <label><i class="fas fa-envelope"></i> Email</label>
                <input type="email" name="email" placeholder="Email directeur" required autocomplete="email">
            </div>
            
            <div class="form-group">
                <label><i class="fas fa-lock"></i> Mot de passe</label>
                <input type="password" name="password" id="password" placeholder="Mot de passe" required autocomplete="current-password">
                <button type="button" class="password-toggle" onclick="togglePassword()" title="Montrer/masquer mot de passe">
                    <i class="fas fa-eye-slash" id="toggleIcon"></i>
                </button>
            </div>
            
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Accéder au Dashboard
            </button>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.className = 'fas fa-eye';
            } else {
                passwordInput.type = 'password';
                toggleIcon.className = 'fas fa-eye-slash';
            }
        }
        
        // Focus auto sur email
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('input[name="email"]').focus();
        });
    </script>
</body>
</html>
