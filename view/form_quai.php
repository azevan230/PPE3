<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($quai) && $quai->getId_quai() ? 'Modifier' : 'Créer' ?> un Quai - Port de La Rochelle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        .container-main {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .fret-checkbox {
            border-left: 4px solid #0d6efd;
            padding-left: 10px;
            margin-bottom: 8px;
        }
        .fret-danger {
            border-left: 4px solid #dc3545;
        }
    </style>
</head>
<body>
    <div class="container-main">
        <main>
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="bi bi-pier"></i> <?= isset($quai) && $quai->getId_quai() ? 'Modifier le Quai' : 'Nouveau Quai' ?>
                </h1>
                <a href="index.php?page=quais" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Retour
                </a>
            </div>

            <!-- Messages d'alerte -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> 
                    <?= htmlspecialchars($_SESSION['success']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['erreur'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle"></i> 
                    <?= htmlspecialchars($_SESSION['erreur']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['erreur']); ?>
            <?php endif; ?>

            <!-- Formulaire -->
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-pencil"></i> Informations du Quai
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom du Quai *</label>
                            <input type="text" class="form-control" id="nom" name="nom" 
                                   value="<?= isset($quai) ? htmlspecialchars($quai->getNom()) : '' ?>" 
                                   required maxlength="50">
                        </div>

                        <div class="mb-3">
                            <label for="tirant_eau_max" class="form-label">Tirant d'eau maximum (m) *</label>
                            <input type="number" class="form-control" id="tirant_eau_max" name="tirant_eau_max" 
                                   step="0.1" min="0.1" 
                                   value="<?= isset($quai) ? htmlspecialchars($quai->getTirant_eau_max()) : '' ?>" 
                                   required>
                        </div>

                        <!-- Sélection des types de fret -->
                        <div class="mb-3">
                            <label class="form-label">Types de fret autorisés *</label>
                            <div class="border p-3 rounded">
                                <?php if (empty($typesFret)): ?>
                                    <div class="alert alert-warning">
                                        <i class="bi bi-exclamation-triangle"></i> Aucun type de fret disponible
                                    </div>
                                <?php else: ?>
                                    <?php 
                                    // CORRECTION : Récupérer les IDs des types de fret déjà sélectionnés
                                    $typesFretQuaiIds = [];
                                    if (isset($typesFretQuai) && is_array($typesFretQuai)) {
                                        foreach ($typesFretQuai as $fretQuai) {
                                            $typesFretQuaiIds[] = $fretQuai['id_fret'];
                                        }
                                    }
                                    ?>
                                    
                                    <?php foreach ($typesFret as $fret): ?>
                                        <div class="form-check fret-checkbox <?= $fret['danger'] ? 'fret-danger' : '' ?>">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="types_fret[]" 
                                                   value="<?= $fret['id_fret'] ?>" 
                                                   id="fret_<?= $fret['id_fret'] ?>"
                                                   <?= in_array($fret['id_fret'], $typesFretQuaiIds) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="fret_<?= $fret['id_fret'] ?>">
                                                <strong><?= htmlspecialchars($fret['type']) ?></strong> 
                                                - <?= htmlspecialchars($fret['libelle']) ?>
                                                <?php if ($fret['danger']): ?>
                                                    <span class="badge bg-danger ms-2">Dangereux</span>
                                                <?php endif; ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <div class="form-text">Sélectionnez les types de fret que ce quai peut accueillir</div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="index.php?page=quais" class="btn btn-secondary me-md-2">
                                <i class="bi bi-x-circle"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> 
                                <?= isset($quai) && $quai->getId_quai() ? 'Modifier' : 'Créer' ?> le Quai
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>