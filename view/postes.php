<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Postes d'Accostage - Port de La Rochelle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        .container-main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container-main">
        <main>
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="bi bi-geo-alt"></i> Postes d'Accostage - <?= htmlspecialchars($quai->getNom()) ?>
                </h1>
                <div>
                    <a href="index.php?page=quais" class="btn btn-secondary me-2">
                        <i class="bi bi-arrow-left"></i> Retour aux quais
                    </a>
                    <a href="index.php?page=creer_poste&id_quai=<?= $quai->getId_quai() ?>" 
                       class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Nouveau Poste
                    </a>
                </div>
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

            <!-- Informations du quai -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="card-title mb-0">Informations du Quai</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>ID:</strong> <?= htmlspecialchars($quai->getId_quai()) ?></p>
                            <p><strong>Nom:</strong> <?= htmlspecialchars($quai->getNom()) ?></p>
                            <p><strong>Tirant d'eau maximum:</strong> 
                                <span class="badge bg-primary">
                                    <?= htmlspecialchars($quai->getTirant_eau_max()) ?> m
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="card-title mb-0">Types de Fret Autorisés</h5>
                        </div>
                        <div class="card-body">
                            <?php if (empty($typesFret)): ?>
                                <p class="text-muted">Aucun type de fret spécifié</p>
                            <?php else: ?>
                                <div class="d-flex flex-wrap gap-1">
                                    <?php foreach ($typesFret as $fret): ?>
                                        <span class="badge bg-secondary">
                                            <?= htmlspecialchars($fret['type']) ?>
                                            <?php if ($fret['danger']): ?>
                                                <i class="bi bi-exclamation-triangle-fill text-warning"></i>
                                            <?php endif; ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tableau des postes -->
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-list"></i> Liste des Postes d'Accostage
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (empty($postesAvecDisponibilite)): ?>
                        <div class="alert alert-info text-center">
                            <i class="bi bi-info-circle"></i> Aucun poste d'accostage pour ce quai
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID Poste</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($postesAvecDisponibilite as $item): 
                                        $poste = $item['poste'];
                                        $disponible = $item['disponible'];
                                    ?>
                                        <tr>
                                            <td>
                                                <strong>#<?= htmlspecialchars($poste->getId_poste_accostage()) ?></strong>
                                            </td>
                                            <td>
                                                <?php if ($disponible): ?>
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle"></i> Disponible
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">
                                                        <i class="bi bi-x-circle"></i> Occupé
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="index.php?page=supprimer_poste&id_poste_accostage=<?= $poste->getId_poste_accostage() ?>" 
                                                       class="btn btn-outline-danger" 
                                                       title="Supprimer"
                                                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer le poste #<?= $poste->getId_poste_accostage() ?> ?')">
                                                        <i class="bi bi-trash"></i> Supprimer
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>