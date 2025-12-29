<?php 
include 'config.php';
session_start(); 
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'directeur') { header('Location: login.php'); exit(); }

if ($_POST) {
    $stmt = $pdo->prepare("INSERT INTO espaces (nom, centre_id, promotion_id, formateur_id, matiere_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$_POST['nom'], $_POST['centre'], $_POST['promotion'], $_POST['formateur'], $_POST['matiere']]);
    header('Location: dashboard.php?success=1');
}

$centres = $pdo->query("SELECT * FROM centres ORDER BY nom")->fetchAll();
$promotions = $pdo->query("SELECT * FROM promotions ORDER BY nom")->fetchAll();
$formateurs = $pdo->query("SELECT f.id, f.nom, m.nom as matiere FROM formateurs f JOIN matieres m ON f.matiere = m.nom ORDER BY f.nom")->fetchAll();
$matieres = $pdo->query("SELECT * FROM matieres ORDER BY nom")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Espace Pédagogique</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --primary: #667eea; --secondary: #764ba2; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .form-container { background: rgba(255,255,255,0.95); backdrop-filter: blur(20px); padding: 3rem; border-radius: 25px; box-shadow: 0 25px 50px rgba(0,0,0,0.2); max-width: 600px; width: 90%; animation: slideIn 0.8s ease; }
        @keyframes slideIn { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .form-header { text-align: center; color: var(--primary); margin-bottom: 2rem; }
        .form-header i { font-size: 3.5rem; margin-bottom: 1rem; display: block; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem; }
        .form-group { margin-bottom: 1.5rem; }
        .form-group.full { grid-column: span 2; }
        label { display: block; margin-bottom: 8px; color: #2d3436; font-weight: 500; }
        input, select { width: 100%; padding: 15px; border: 2px solid #e1e5e9; border-radius: 12px; font-size: 16px; transition: all 0.3s; background: white; }
        input:focus, select:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(102,126,234,0.1); }
        .formateur-preview { background: #f8f9fa; padding: 15px; border-radius: 12px; margin-top: 10px; display: none; }
        .formateur-preview.show { display: block; animation: fadeIn 0.3s; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        .btn-group { display: flex; gap: 1rem; margin-top: 2rem; }
        .btn-primary, .btn-secondary { flex: 1; padding: 15px; border-radius: 25px; text-decoration: none; font-weight: bold; text-align: center; transition: all 0.3s; font-size: 16px; }
        .btn-primary { background: linear-gradient(45deg, var(--primary), var(--secondary)); color: white; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 15px 30px rgba(102,126,234,0.4); }
        .btn-secondary { background: #636e72; color: white; }
        .btn-secondary:hover { background: #2d3436; transform: translateY(-2px); }
        @media (max-width: 768px) { .form-grid { grid-template-columns: 1fr; } .form-group.full { grid-column: span 1; } }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <i class="fas fa-plus-circle"></i>
            <h2>Ajouter Nouvel Espace Pédagogique</h2>
        </div>
        <form method="POST">
            <div class="form-grid">
                <div class="form-group">
                    <label><i class="fas fa-tag"></i> Nom de l'Espace</label>
                    <input type="text" name="nom" placeholder="Ex: Espace SI1 Porto-Novo" required>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-map-marker-alt"></i> Centre</label>
                    <select name="centre" required>
                        <?php foreach($centres as $centre): ?>
                        <option value="<?= $centre['id'] ?>"><?= htmlspecialchars($centre['nom']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group full">
                <label><i class="fas fa-users"></i> Promotion</label>
                <select name="promotion" required>
                    <?php foreach($promotions as $promotion): ?>
                    <option value="<?= $promotion['id'] ?>"><?= htmlspecialchars($promotion['nom']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label><i class="fas fa-chalkboard-teacher"></i> Formateur</label>
                    <select name="formateur" id="formateur" required>
                        <option value="">Choisir un formateur</option>
                        <?php foreach($formateurs as $formateur): ?>
                        <option value="<?= $formateur['id'] ?>" data-matiere="<?= htmlspecialchars($formateur['matiere']) ?>">
                            <?= htmlspecialchars($formateur['nom']) ?> 
                            <small style="color:#666;">(<?= $formateur['matiere'] ?>)</small>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="formateur-preview" id="preview">
                        <strong><i class="fas fa-user-tie"></i> Sélectionné :</strong> 
                        <span id="preview-nom"></span> - <span id="preview-matiere"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-book"></i> Matière Enseignée</label>
                    <select name="matiere" id="matiere" required>
                        <option value="">Choisir une matière</option>
                        <?php foreach($matieres as $matiere): ?>
                        <option value="<?= $matiere['id'] ?>"><?= htmlspecialchars($matiere['nom']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Créer Espace Complet
                </button>
                <a href="dashboard.php" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour Dashboard
                </a>
            </div>
        </form>
    </div>

    <script>
        // Preview formateur en temps réel
        document.getElementById('formateur').addEventListener('change', function() {
            const preview = document.getElementById('preview');
            const previewNom = document.getElementById('preview-nom');
            const previewMatiere = document.getElementById('preview-matiere');
            const matiereSelect = document.getElementById('matiere');
            
            if (this.value) {
                const matiere = this.options[this.selectedIndex].dataset.matiere;
                previewNom.textContent = this.options[this.selectedIndex].textContent;
                previewMatiere.textContent = matiere;
                preview.classList.add('show');
                matiereSelect.value = matiere; // Auto-sélectionne la matière
            } else {
                preview.classList.remove('show');
            }
        });
    </script>
</body>
</html>
