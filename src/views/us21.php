<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Formateur - HEROS TECH</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            min-height: 100vh;
        }

        .page-header {
            background: linear-gradient(135deg, #2563EB, #1E3A8A);
            color: white;
            padding: 2rem 0;
            border-radius: 0 0 20px 20px;
            margin-bottom: 2rem;
        }

        .form-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 2rem;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #F59E0B, #D97706);
            border: none;
            font-weight: 600;
            border-radius: 12px;
        }
    </style>
</head>
<body>

<!-- HEADER -->
<div class="page-header text-center">
    <h1 class="fw-bold">
        <i class="fas fa-user-plus me-2"></i>
        Création d’un compte Formateur
    </h1>
    <p class="lead mb-0">US 2.1 – Gestion des formateurs</p>
</div>

<!-- CONTENU -->
<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="form-card">

                <?php if (isset($error)) : ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form method="POST">

                    <div class="mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" name="nom" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Prénom</label>
                        <input type="text" name="prenom" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Spécialité</label>
                        <input type="text" name="specialite" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Téléphone</label>
                        <input type="text" name="telephone" class="form-control">
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label class="form-label">Adresse email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Mot de passe</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary-custom w-100 py-2">
                        <i class="fas fa-save me-2"></i>
                        Créer le formateur
                    </button>

                </form>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
