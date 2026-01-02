<?php
session_start(); 
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'directeur') { header('Location: login.php'); exit(); }
include 'config.php';

$nom_directeur = $_SESSION['user_nom'];

// Gérer suppression
if (isset($_GET['delete'])) { 
    $pdo->prepare("DELETE FROM espaces WHERE id=?")->execute([$_GET['delete']]); 
    header('Location: dashboard.php?updated=1'); exit();
}

// Récupérer thème (3 options)
$theme = isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'light';

// Stats globales
$total_espaces = $pdo->query("SELECT COUNT(*) FROM espaces")->fetchColumn();
$total_etudiants = $pdo->query("SELECT COUNT(*) FROM etudiants")->fetchColumn();
$total_formateurs = $pdo->query("SELECT COUNT(*) FROM formateurs")->fetchColumn();

// Requête espaces
$stmt = $pdo->query("
    SELECT e.id, e.nom, c.nom as centre, p.nom as promotion, 
           COALESCE(f.nom, 'Non assigné') as formateur, 
           COALESCE(m.nom, '') as matiere,
           COALESCE(COUNT(DISTINCT etu.id), 0) as nb_etudiants
    FROM espaces e 
    JOIN centres c ON e.centre_id = c.id 
    JOIN promotions p ON e.promotion_id = p.id
    LEFT JOIN formateurs f ON e.formateur_id = f.id
    LEFT JOIN matieres m ON e.matiere_id = m.id
    LEFT JOIN etudiants etu ON etu.promotion_id = p.id
    GROUP BY e.id, e.nom, c.nom, p.nom, f.nom, m.nom
    ORDER BY e.nom
");
$espaces = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?= $nom_directeur ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #667eea; --secondary: #764ba2; --danger: #ff4757; --success: #2ed573; --warning: #ffa502;
        }
        
        /* THÈME CLAIR */
        :root { --bg-primary: #f0f2f5; --bg-secondary: #ffffff; --text-primary: #1a1a2e; --text-secondary: #6c757d; --shadow: rgba(0,0,0,0.08); --border: #dee2e6; }
        
        /* THÈME SOMBRE */
        [data-theme="dark"] { --bg-primary: #0f0f23; --bg-secondary: #1a1a2e; --text-primary: #ffffff; --text-secondary: #adb5bd; --shadow: rgba(0,0,0,0.6); --border: #2c2c54; }
        
        /* THÈME VÉLIN */
        [data-theme="beige"] { --bg-primary: #fdf6e3; --bg-secondary: #fff8dc; --text-primary: #5d4037; --text-secondary: #8d6e63; --shadow: rgba(0,0,0,0.1); --border: #d7ccc8; }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, sans-serif; 
            background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 100%); 
            min-height: 100vh; color: var(--text-primary); 
            transition: all 0.5s ease;
        }
        
        /* Navbar */
        .navbar { 
            background: var(--bg-secondary); padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; 
            box-shadow: 0 4px 20px var(--shadow); position: sticky; top: 0; z-index: 100;
            border-bottom: 1px solid var(--border);
        }
        .navbar h1 { color: var(--primary); font-size: 1.4rem; font-weight: 700; }
        .navbar h1 i { margin-right: 8px; }
        
        /* 1 SEUL BOUTON THÈME */
        .theme-toggle { 
            background: var(--primary); color: white; border: none; padding: 10px 16px; 
            border-radius: 25px; cursor: pointer; font-size: 14px; transition: all 0.3s; 
            display: flex; align-items: center; gap: 8px; font-weight: 600;
            position: relative;
        }
        .theme-toggle:hover { transform: scale(1.05); box-shadow: 0 5px 15px rgba(102,126,234,0.4); }
        .theme-menu {
            position: absolute; top: 100%; right: 0; background: var(--bg-secondary); 
            border-radius: 15px; box-shadow: 0 10px 30px var(--shadow); min-width: 120px;
            display: none; flex-direction: column; z-index: 1000; border: 1px solid var(--border);
        }
        .theme-menu.show { display: flex; }
        .theme-option {
            padding: 12px 16px; cursor: pointer; transition: all 0.2s; border: none; 
            background: none; text-align: left; font-size: 14px; color: var(--text-primary);
        }
        .theme-option:hover { background: rgba(102,126,234,0.1); }
        .theme-option.active { background: rgba(102,126,234,0.2); font-weight: 600; }
        
        /* Bouton Déconnexion GRAND */
        .btn-logout { 
            background: var(--danger); color: white; padding: 12px 20px; border-radius: 25px; 
            text-decoration: none; font-size: 14px; font-weight: 600; transition: all 0.3s; 
            display: flex; align-items: center; gap: 8px; margin-left: 1rem;
        }
        .btn-logout:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(255,71,87,0.4); }
        
        .container { max-width: 1200px; margin: 1.5rem auto; padding: 0 1rem; }
        
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
        .stat-card { 
            background: var(--bg-secondary); padding: 1.5rem 1rem; border-radius: 15px; text-align: center; 
            box-shadow: 0 10px 30px var(--shadow); transition: all 0.4s; position: relative; 
            border: 1px solid var(--border);
        }
        .stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, var(--primary), var(--secondary)); }
        .stat-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px var(--shadow); }
        .stat-icon { font-size: 2.2rem; margin-bottom: 0.5rem; }
        .stat-card:nth-child(1) .stat-icon { color: var(--primary); }
        .stat-card:nth-child(2) .stat-icon { color: var(--success); }
        .stat-card:nth-child(3) .stat-icon { color: var(--warning); }
        .stat-number { font-size: 2rem; font-weight: 700; margin-bottom: 0.3rem; }
        .stat-label { color: var(--text-secondary); font-size: 0.95rem; font-weight: 500; }
        
        .empty-state { 
            background: var(--bg-secondary); padding: 3rem 2rem; border-radius: 20px; text-align: center; 
            box-shadow: 0 15px 40px var(--shadow); max-width: 500px; margin: 2rem auto; 
            border: 1px solid var(--border);
        }
        .empty-icon { font-size: 4rem; color: #ff6b6b; margin-bottom: 1rem; }
        
        .btn-primary { 
            background: linear-gradient(45deg, var(--primary), var(--secondary)); color: white; 
            padding: 12px 30px; border-radius: 25px; text-decoration: none; font-size: 1rem; 
            font-weight: 600; display: inline-block; transition: all 0.3s; 
            box-shadow: 0 8px 25px rgba(102,126,234,0.3); border: none;
        }
        .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 15px 35px rgba(102,126,234,0.4); }
        
        .espaces-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
        .espace-card { 
            background: var(--bg-secondary); border-radius: 20px; padding: 1.5rem; 
            box-shadow: 0 12px 30px var(--shadow); transition: all 0.4s; 
            border: 1px solid var(--border); position: relative; overflow: hidden;
        }
        .espace-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, var(--primary), var(--secondary)); }
        .espace-card:hover { transform: translateY(-10px); box-shadow: 0 25px 50px var(--shadow); }
        .card-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem; }
        .card-title { font-size: 1.2rem; font-weight: 600; color: var(--text-primary); }
        .btn-delete { 
            background: var(--danger); color: white; border: none; width: 40px; height: 40px; 
            border-radius: 50%; cursor: pointer; font-size: 1rem; transition: all 0.3s; 
            box-shadow: 0 5px 15px rgba(255,71,87,0.3); margin-top: -5px;
        }
        .btn-delete:hover { background: #ff3838; transform: scale(1.1); }
        .stat-row { 
            display: flex; align-items: center; gap: 10px; margin-bottom: 1rem; padding: 12px; 
            background: rgba(248,249,250,0.6); border-radius: 12px; transition: all 0.3s; 
            border: 1px solid var(--border);
        }
        [data-theme="dark"] .stat-row, [data-theme="beige"] .stat-row { background: rgba(255,255,255,0.1); }
        .stat-row:hover { transform: translateX(5px); background: rgba(102,126,234,0.1); }
        .stat-icon { color: var(--primary); font-size: 1.2rem; width: 30px; text-align: center; }
        .stat-value { font-weight: 600; font-size: 1rem; }
        .stat-label { color: var(--text-secondary); font-size: 0.85rem; }
        
        .action-bar { text-align: center; padding: 2rem 0; }
        .success-message { background: var(--success); color: white; padding: 12px 20px; border-radius: 15px; text-align: center; margin: 1rem 0; font-weight: 600; font-size: 0.95rem; }
        
        .title { text-align: center; color: var(--text-primary); margin-bottom: 2rem; font-size: 1.8rem; font-weight: 700; }
        
        @media (max-width: 768px) { 
            .navbar { padding: 1rem; flex-wrap: wrap; gap: 0.5rem; } 
            .container { padding: 0 0.5rem; margin: 1rem auto; } 
            .espaces-grid { grid-template-columns: 1fr; }
            .stats-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body data-theme="<?= $theme ?>">
    <nav class="navbar">
        <h1><i class="fas fa-graduation-cap"></i> Bonjour <?= htmlspecialchars($nom_directeur) ?> !</h1>
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="position: relative;">
                <button class="theme-toggle" onclick="toggleThemeMenu()" title="Thèmes">
                    <i class="fas fa-palette"></i> Thème
                </button>
                <div class="theme-menu" id="themeMenu">
                    <div class="theme-option <?= $theme=='light' ? 'active' : '' ?>" onclick="setTheme('light')">
                        <i class="fas fa-sun"></i> Clair
                    </div>
                    <div class="theme-option <?= $theme=='dark' ? 'active' : '' ?>" onclick="setTheme('dark')">
                        <i class="fas fa-moon"></i> Sombre
                    </div>
                    <div class="theme-option <?= $theme=='beige' ? 'active' : '' ?>" onclick="setTheme('beige')">
                        <i class="fas fa-image"></i> Vélin
                    </div>
                </div>
            </div>
            <a href="login.php?logout=1" class="btn-logout">
                <i class="fas fa-sign-out-alt"></i> Déconnexion
            </a>
        </div>
    </nav>

    <div class="container">
        <?php if (isset($_GET['updated'])): ?>
            <div class="success-message">✅ Espace supprimé ! Stats mises à jour (<?= $total_espaces ?> espaces)</div>
        <?php endif; ?>

        <div class="stats-grid">
            <div class="stat-card">
                <i class="fas fa-layer-group stat-icon"></i>
                <div class="stat-number"><?= $total_espaces ?></div>
                <div class="stat-label">Espaces</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-users stat-icon"></i>
                <div class="stat-number"><?= $total_etudiants ?></div>
                <div class="stat-label">Étudiants</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-chalkboard-teacher stat-icon"></i>
                <div class="stat-number"><?= $total_formateurs ?></div>
                <div class="stat-label">Formateurs</div>
            </div>
        </div>

        <?php if (empty($espaces)): ?>
            <div class="empty-state">
                <i class="fas fa-inbox empty-icon"></i>
                <h2>Aucun espace trouvé</h2>
                <a href="ajouter_espace.php" class="btn-primary">➕ Créer Espace</a>
            </div>
        <?php else: ?>
            <h2 class="title"><i class="fas fa-list"></i> Espaces Pédagogiques</h2>
            <div class="espaces-grid">
                <?php foreach($espaces as $espace): ?>
                <div class="espace-card">
                    <div class="card-header">
                        <div class="card-title"><?= htmlspecialchars($espace['nom']) ?></div>
                        <a href="?delete=<?= $espace['id'] ?>" class="btn-delete" onclick="return confirm('Supprimer ?')" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                    
                    <div class="stat-row">
                        <i class="fas fa-map-marker-alt stat-icon"></i>
                        <div><div class="stat-value"><?= htmlspecialchars($espace['centre']) ?></div><div class="stat-label">Centre</div></div>
                    </div>
                    
                    <div class="stat-row">
                        <i class="fas fa-users stat-icon"></i>
                        <div><div class="stat-value"><?= $espace['promotion'] ?> (<?= $espace['nb_etudiants'] ?>)</div><div class="stat-label">Promo</div></div>
                    </div>
                    
                    <div class="stat-row">
                        <i class="fas fa-chalkboard-teacher stat-icon"></i>
                        <div><div class="stat-value"><?= htmlspecialchars($espace['formateur']) ?></div><div class="stat-label">Formateur</div></div>
                    </div>
                    
                    <?php if ($espace['matiere']): ?>
                    <div class="stat-row">
                        <i class="fas fa-book-open stat-icon"></i>
                        <div><div class="stat-value"><?= htmlspecialchars($espace['matiere']) ?></div><div class="stat-label">Matière</div></div>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="action-bar">
                <a href="ajouter_espace.php" class="btn-primary"><i class="fas fa-plus"></i> Nouvel Espace</a>
            </div>
        <?php endif; ?>
    </div>

    <script>
        let themeMenuVisible = false;
        
        function toggleThemeMenu() {
            const menu = document.getElementById('themeMenu');
            themeMenuVisible = !themeMenuVisible;
            menu.classList.toggle('show');
        }
        
        function setTheme(theme) {
            document.body.setAttribute('data-theme', theme);
            document.querySelectorAll('.theme-option').forEach(opt => opt.classList.remove('active'));
            event.target.classList.add('active');
            localStorage.setItem('theme', theme);
            document.cookie = `theme=${theme}; path=/; max-age=31536000`;
            document.getElementById('themeMenu').classList.remove('show');
            themeMenuVisible = false;
        }
        
        // Fermer menu en cliquant ailleurs
        document.addEventListener('click', function(e) {
            const themeToggle = document.querySelector('.theme-toggle');
            const themeMenu = document.getElementById('themeMenu');
            if (!themeToggle.contains(e.target) && !themeMenu.contains(e.target) && themeMenuVisible) {
                themeMenu.classList.remove('show');
                themeMenuVisible = false;
            }
        });
        
        // Charger thème
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.body.setAttribute('data-theme', savedTheme);
        document.querySelector(`[onclick="setTheme('${savedTheme}')"]`).classList.add('active');

        // Animations
        document.querySelectorAll('.espace-card, .stat-card').forEach((el, index) => {
            el.style.opacity = '0'; el.style.transform = 'translateY(20px)';
            setTimeout(() => {
                el.style.transition = 'all 0.5s ease';
                el.style.opacity = '1'; el.style.transform = 'translateY(0)';
            }, index * 100);
        });
    </script>
</body>
</html>
