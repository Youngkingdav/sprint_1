<?php
// ============================================
// FICHIER : form.php
// BUT : Affiche le formulaire HTML
// ============================================
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>US33 - Ajouter un étudiant à un espace pédagogique</title>
    
    <!-- Bootstrap pour un beau design -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            margin-top: 50px;
        }
        
        .card-header {
            background: linear-gradient(135deg, #2575fc 0%, #6a11cb 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 20px;
        }
        
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }
        
        .form-control, .form-select {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px 15px;
            transition: all 0.3s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #6a11cb;
            box-shadow: 0 0 0 0.25rem rgba(106, 17, 203, 0.25);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 8px;
            transition: transform 0.3s;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(106, 17, 203, 0.4);
        }
        
        .loading {
            display: none;
            text-align: center;
            padding: 10px;
            color: #6c757d;
        }
        
        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            position: relative;
        }
        
        .step-indicator:before {
            content: '';
            position: absolute;
            top: 15px;
            left: 10%;
            right: 10%;
            height: 2px;
            background: #e0e0e0;
            z-index: 1;
        }
        
        .step {
            text-align: center;
            z-index: 2;
            position: relative;
        }
        
        .step-number {
            width: 30px;
            height: 30px;
            background: #e0e0e0;
            color: #6c757d;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
            font-weight: bold;
        }
        
        .step.active .step-number {
            background: #6a11cb;
            color: white;
        }
        
        .step-label {
            font-size: 12px;
            color: #6c757d;
        }
        
        .step.active .step-label {
            color: #6a11cb;
            font-weight: 600;
        }
        
        .alert {
            border-radius: 10px;
            border: none;
            animation: slideDown 0.5s ease;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .test-cases {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-top: 30px;
        }
        
        .test-case {
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .test-case:hover {
            background: #e9ecef;
        }
        
        .test-case.success {
            border-left: 4px solid #28a745;
        }
        
        .test-case.error {
            border-left: 4px solid #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h3 class="mb-0"><i class="fas fa-user-graduate me-2"></i>US33 - Ajouter un étudiant à un espace pédagogique</h3>
                        <p class="mb-0 opacity-75">Simulation de test - User Story 33</p>
                    </div>
                    
                    <div class="card-body p-4">
                        <!-- Indicateur d'étapes -->
                        <div class="step-indicator">
                            <div class="step active" id="step1">
                                <div class="step-number">1</div>
                                <div class="step-label">Promotion</div>
                            </div>
                            <div class="step" id="step2">
                                <div class="step-number">2</div>
                                <div class="step-label">Étudiant</div>
                            </div>
                            <div class="step" id="step3">
                                <div class="step-number">3</div>
                                <div class="step-label">Espace</div>
                            </div>
                        </div>
                        
                        <!-- Messages -->
                        <?php if (isset($_SESSION['us33_message'])): ?>
                            <div class="alert alert-<?php echo $_SESSION['us33_message_type'] === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show">
                                <i class="fas <?php echo $_SESSION['us33_message_type'] === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?> me-2"></i>
                                <?php echo $_SESSION['us33_message']; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            <?php 
                            unset($_SESSION['us33_message']);
                            unset($_SESSION['us33_message_type']);
                            ?>
                        <?php endif; ?>
                        
                        <!-- Formulaire -->
                        <form method="POST" action="us33_test.php?action=handleSubmit" id="addForm">
                            <!-- Promotion -->
                            <div class="mb-4">
                                <label for="promotion" class="form-label">
                                    <i class="fas fa-users me-2"></i>Sélectionnez une promotion :
                                </label>
                                <select class="form-select" id="promotion" name="promotion_id" onchange="loadEtudiants()" required>
                                    <option value="">-- Choisissez une promotion --</option>
                                    <?php if (isset($promotions) && is_array($promotions)): ?>
                                        <?php foreach ($promotions as $promo): ?>
                                            <option value="<?php echo htmlspecialchars($promo['id']); ?>">
                                                <?php echo htmlspecialchars($promo['nom']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="1">Promotion 2024 - Informatique</option>
                                        <option value="2">Promotion 2025 - Marketing</option>
                                        <option value="3">Promotion 2024 - Gestion</option>
                                    <?php endif; ?>
                                </select>
                                <div class="form-text">Sélectionnez la promotion de l'étudiant</div>
                            </div>
                            
                            <!-- Étudiant -->
                            <div class="mb-4">
                                <label for="etudiant" class="form-label">
                                    <i class="fas fa-user me-2"></i>Sélectionnez un étudiant :
                                </label>
                                <div id="loadingEtudiants" class="loading">
                                    <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>
                                    Chargement des étudiants...
                                </div>
                                <select class="form-select" id="etudiant" name="etudiant_id" disabled required>
                                    <option value="">-- Choisissez d'abord une promotion --</option>
                                </select>
                                <div class="form-text" id="etudiantHelp">Les étudiants apparaîtront après la sélection de la promotion</div>
                            </div>
                            
                            <!-- Espace pédagogique -->
                            <div class="mb-4">
                                <label for="espace" class="form-label">
                                    <i class="fas fa-book me-2"></i>Sélectionnez un espace pédagogique :
                                </label>
                                <select class="form-select" id="espace" name="espace_id" required>
                                    <option value="">-- Choisissez un espace --</option>
                                    <?php if (isset($espaces) && is_array($espaces)): ?>
                                        <?php foreach ($espaces as $espace): ?>
                                            <option value="<?php echo htmlspecialchars($espace['id']); ?>">
                                                <?php echo htmlspecialchars($espace['nom'] . ' (' . $espace['matiere'] . ')'); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="1">Espace Algorithmique (Algo)</option>
                                        <option value="2">Espace Base de données (BDD)</option>
                                        <option value="3">Espace Développement Web (Web)</option>
                                    <?php endif; ?>
                                </select>
                                <div class="form-text">Sélectionnez l'espace pédagogique (matière)</div>
                            </div>
                            
                            <!-- Boutons -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                <a href="us33_test.php?action=home" class="btn btn-outline-secondary me-2">
                                    <i class="fas fa-arrow-left me-2"></i>Retour
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus-circle me-2"></i>Ajouter l'étudiant à l'espace
                                </button>
                            </div>
                        </form>
                        
                        <!-- Cas de test rapides -->
                        <div class="test-cases mt-5">
                            <h5><i class="fas fa-vial me-2"></i>Tests rapides :</h5>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="test-case success" onclick="fillTest('favorable')">
                                        <strong><i class="fas fa-check-circle text-success me-2"></i>Cas FAVORABLE :</strong>
                                        <small class="d-block text-muted">Bernard Pierre + Espace Développement Web</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="test-case error" onclick="fillTest('defavorable')">
                                        <strong><i class="fas fa-times-circle text-danger me-2"></i>Cas DÉFAVORABLE :</strong>
                                        <small class="d-block text-muted">Dupont Jean + Espace Algorithmique</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Instructions -->
                <div class="alert alert-info mt-3">
                    <h5><i class="fas fa-info-circle me-2"></i>Critères d'acceptation :</h5>
                    <ul class="mb-0">
                        <li><strong>Cas favorable :</strong> Étudiant ajouté avec succès → Message de confirmation</li>
                        <li><strong>Cas défavorable :</strong> Étudiant déjà dans l'espace → Message d'erreur</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Mise à jour des étapes
        function updateSteps() {
            const promotion = document.getElementById('promotion').value;
            const etudiant = document.getElementById('etudiant').value;
            const espace = document.getElementById('espace').value;
            
            // Réinitialiser
            document.getElementById('step1').classList.remove('active');
            document.getElementById('step2').classList.remove('active');
            document.getElementById('step3').classList.remove('active');
            
            // Activer étape 1
            document.getElementById('step1').classList.add('active');
            
            // Si promotion sélectionnée, activer étape 2
            if (promotion) {
                document.getElementById('step2').classList.add('active');
            }
            
            // Si étudiant sélectionné, activer étape 3
            if (etudiant) {
                document.getElementById('step3').classList.add('active');
            }
        }
        
        // Charger les étudiants
        function loadEtudiants() {
            const promotionSelect = document.getElementById('promotion');
            const etudiantSelect = document.getElementById('etudiant');
            const loadingDiv = document.getElementById('loadingEtudiants');
            const helpText = document.getElementById('etudiantHelp');
            
            const promotionId = promotionSelect.value;
            
            // Mettre à jour les étapes
            updateSteps();
            
            if (!promotionId) {
                etudiantSelect.disabled = true;
                etudiantSelect.innerHTML = '<option value="">-- Choisissez d\'abord une promotion --</option>';
                helpText.textContent = 'Les étudiants apparaîtront après la sélection de la promotion';
                return;
            }
            
            // Afficher chargement
            loadingDiv.style.display = 'block';
            etudiantSelect.style.display = 'none';
            helpText.textContent = 'Chargement des étudiants...';
            
            // Données simulées (à remplacer par AJAX si backend fonctionne)
            const etudiantsData = {
                '1': [
                    {id: '101', nom: 'DUPONT', prenom: 'Jean'},
                    {id: '102', nom: 'MARTIN', prenom: 'Marie'},
                    {id: '103', nom: 'BERNARD', prenom: 'Pierre'}
                ],
                '2': [
                    {id: '201', nom: 'THOMAS', prenom: 'Sophie'},
                    {id: '202', nom: 'PETIT', prenom: 'Luc'}
                ],
                '3': [
                    {id: '301', nom: 'ROBERT', prenom: 'Julie'},
                    {id: '302', nom: 'RICHARD', prenom: 'Thomas'},
                    {id: '303', nom: 'DURAND', prenom: 'Laura'}
                ]
            };
            
            // Simuler un délai de chargement
            setTimeout(function() {
                const etudiants = etudiantsData[promotionId] || [];
                
                // Vider et remplir la liste
                etudiantSelect.innerHTML = '<option value="">-- Sélectionnez un étudiant --</option>';
                
                if (etudiants.length === 0) {
                    etudiantSelect.innerHTML = '<option value="">Aucun étudiant dans cette promotion</option>';
                } else {
                    etudiants.forEach(etudiant => {
                        const option = document.createElement('option');
                        option.value = etudiant.id;
                        option.textContent = `${etudiant.nom} ${etudiant.prenom}`;
                        etudiantSelect.appendChild(option);
                    });
                }
                
                // Activer et afficher
                etudiantSelect.disabled = false;
                loadingDiv.style.display = 'none';
                etudiantSelect.style.display = 'block';
                helpText.textContent = `${etudiants.length} étudiant(s) disponible(s)`;
                
                updateSteps();
                
            }, 800); // Délai de 0.8 seconde pour simulation
        }
        
        // Remplir automatiquement pour les tests
        function fillTest(type) {
            if (type === 'favorable') {
                // Cas favorable : Bernard Pierre + Espace Développement Web
                document.getElementById('promotion').value = '1';
                loadEtudiants();
                
                setTimeout(function() {
                    document.getElementById('etudiant').value = '103'; // Bernard Pierre
                    document.getElementById('espace').value = '3'; // Espace Développement Web
                    updateSteps();
                    
                    alert('Formulaire rempli pour le test FAVORABLE :\nPromotion 2024 - Informatique\nÉtudiant: BERNARD Pierre\nEspace: Développement Web');
                }, 1000);
                
            } else if (type === 'defavorable') {
                // Cas défavorable : Dupont Jean + Espace Algorithmique (déjà ajouté)
                document.getElementById('promotion').value = '1';
                loadEtudiants();
                
                setTimeout(function() {
                    document.getElementById('etudiant').value = '101'; // Dupont Jean
                    document.getElementById('espace').value = '1'; // Espace Algorithmique
                    updateSteps();
                    
                    alert('Formulaire rempli pour le test DÉFAVORABLE :\nPromotion 2024 - Informatique\nÉtudiant: DUPONT Jean\nEspace: Algorithmique\n\nCet étudiant est DÉJÀ dans cet espace !');
                }, 1000);
            }
        }
        
        // Validation
        document.getElementById('addForm').addEventListener('submit', function(event) {
            const promotion = document.getElementById('promotion').value;
            const etudiant = document.getElementById('etudiant').value;
            const espace = document.getElementById('espace').value;
            
            if (!promotion || !etudiant || !espace) {
                event.preventDefault();
                alert('❌ Veuillez remplir tous les champs avant de soumettre !');
                return false;
            }
            
            return true;
        });
        
        // Initialiser les étapes
        document.getElementById('espace').addEventListener('change', updateSteps);
        document.getElementById('etudiant').addEventListener('change', updateSteps);
        
        // Initialiser au chargement
        document.addEventListener('DOMContentLoaded', updateSteps);
    </script>
</body>
</html>