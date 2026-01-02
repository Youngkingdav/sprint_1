<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espaces pédagogiques - HEROS TECH</title>
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Font Awesome pour icônes supplémentaires -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-blue: #2563EB;
            --dark-blue: #1E3A8A;
            --gold: #F59E0B;
            --light-bg: #F8FAFC;
            --shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--gold) !important;
        }
        
        .navbar-dark .navbar-nav .nav-link.active {
            color: var(--gold) !important;
            font-weight: 600;
        }
        
        .page-header {
            background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 20px 20px;
            box-shadow: var(--shadow);
        }
        
        .page-title {
            font-weight: 800;
            font-size: 2.5rem;
            margin: 0;
        }
        
        .page-subtitle {
            opacity: 0.9;
            margin-top: 0.5rem;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--gold), #D97706);
            border: none;
            border-radius: 12px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
            transition: all 0.3s ease;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.5);
            color: white !important;
        }
        
        .table-container {
            background: white;
            border-radius: 20px;
            box-shadow: var(--shadow);
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        .table thead th {
            background: linear-gradient(135deg, var(--dark-blue), var(--primary-blue));
            color: white;
            font-weight: 700;
            border: none;
            padding: 1.25rem 1rem;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .table tbody tr {
            transition: all 0.2s ease;
        }
        
        .table tbody tr:hover {
            background-color: rgba(37, 99, 235, 0.05);
            transform: scale(1.01);
        }
        
        .table td {
            padding: 1.25rem 1rem;
            vertical-align: middle;
            border-color: rgba(0,0,0,0.05);
        }
        
        .no-data {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            border-radius: 15px;
            padding: 3rem;
            text-align: center;
            color: #64748b;
        }
        
        .no-data i {
            font-size: 4rem;
            color: #cbd5e1;
            margin-bottom: 1rem;
        }
        
        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }
            
            .table-container {
                margin: -1rem;
                border-radius: 0;
            }
        }
        
        .stats-badge {
            background: var(--primary-blue);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <!-- Navbar améliorée -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-graduation-cap me-2"></i>HEROS TECH
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php"><i class="bi bi-house-door me-1"></i>Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-semibold" href="index.php?page=espaces">
                            <i class="bi bi-book-half me-1"></i>Espaces Pédagogiques
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- En-tête de page -->
    <div class="page-header">
        <div class="container">
            <h1 class="page-title">
                <i class="fas fa-chalkboard-teacher me-3"></i>
                Espaces Pédagogiques
            </h1>
            <p class="page-subtitle lead">Gestion complète des espaces d'enseignement</p>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="container mb-5">
        <!-- Statistiques rapides (optionnel - à connecter à PHP) -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100 text-center p-4 bg-primary text-white rounded-3">
                    <i class="fas fa-book fa-3x mb-3 opacity-75"></i>
                    <h3 class="fw-bold"><?= count($espaces ?? []) ?></h3>
                    <p class="mb-0">Espaces actifs</p>
                </div>
            </div>
        </div>

        <!-- Bouton d'action principal -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <h2 class="h3 mb-0 fw-bold text-dark">
                <i class="bi bi-table me-2 text-primary"></i>
                Liste des espaces
            </h2>
            <a href="index.php?page=ajout_espace" class="btn btn-primary-custom btn-lg">
                <i class="fas fa-plus me-2"></i>
                Ajouter un espace
            </a>
        </div>

        <!-- Tableau responsive professionnel -->
        <div class="table-responsive table-container">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th><i class="bi bi-hash"></i> ID</th>
                        <th><i class="bi bi-book"></i> Matière</th>
                        <th><i class="bi bi-people"></i> Promotion</th>
                        <th><i class="bi bi-calendar3"></i> Année académique</th>
                        <th class="text-center"><i class="bi bi-gear"></i> Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($espaces)) : ?>
                        <?php foreach ($espaces as $espace) : ?>
                            <tr>
                                <td>
                                    <span class="stats-badge">#<?= htmlspecialchars($espace['id']) ?></span>
                                </td>
                                <td>
                                    <strong><?= htmlspecialchars($espace['matiere']) ?></strong>
                                </td>
                                <td><?= htmlspecialchars($espace['promotion']) ?></td>
                                <td>
                                    <span class="badge bg-success"><?= htmlspecialchars($espace['annee_academique']) ?></span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="index.php?page=edit&id=<?= $espace['id'] ?>" class="btn btn-outline-primary" title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="index.php?page=delete&id=<?= $espace['id'] ?>" class="btn btn-outline-danger" title="Supprimer" onclick="return confirm('Confirmer la suppression ?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="no-data p-5">
                                <i class="fas fa-inbox"></i>
                                <h4 class="mb-3">Aucun espace pédagogique trouvé</h4>
                                <p class="mb-4">Commencez par ajouter votre premier espace pédagogique.</p>
                                <a href="index.php?page=ajout_espace" class="btn btn-primary-custom">
                                    <i class="fas fa-plus me-2"></i>Ajouter un espace
                                </a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Animation d'apparition fluide
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach((row, index) => {
                row.style.opacity = '0';
                row.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    row.style.transition = 'all 0.4s ease';
                    row.style.opacity = '1';
                    row.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>
