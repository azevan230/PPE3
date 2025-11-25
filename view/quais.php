<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Quais - Port de La Rochelle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container-main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .table-actions {
            width: 120px;
        }
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
        }
    </style>
</head>
<body>
    <div class="container-main">
        <!-- Main content -->
        <main>
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="bi bi-pier"></i> Gestion des Quais
                </h1>
                <a href="index.php?page=creer_quai" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Nouveau Quai
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

            <!-- Debug info (à retirer en production) -->
            <div class="alert alert-info d-none">
                <strong>Debug Info:</strong><br>
                Nombre de quais: <?= isset($quais) ? count($quais) : '0' ?><br>
                Type de variable: <?= isset($quais) ? gettype($quais) : 'non définie' ?>
            </div>

            <!-- Tableau des quais -->
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-list"></i> Liste des Quais
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (empty($quais)): ?>
                        <div class="alert alert-info text-center">
                            <i class="bi bi-info-circle"></i> Aucun quai enregistré dans la base de données
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom du Quai</th>
                                        <th>Tirant d'eau max (m)</th>
                                        <th>Postes d'Accostage</th>
                                        <th class="table-actions">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($quais as $quai): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($quai->getId_quai()) ?></td>
                                            <td>
                                                <strong><?= htmlspecialchars($quai->getNom()) ?></strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <?= htmlspecialchars($quai->getTirant_eau_max()) ?> m
                                                </span>
                                            </td>
                                            <td>
                                                <a href="index.php?page=postes&id_quai=<?= $quai->getId_quai() ?>" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i> Voir les postes
                                                </a>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="index.php?page=modifier_quai&id_quai=<?= $quai->getId_quai() ?>" 
                                                       class="btn btn-outline-secondary" 
                                                       title="Modifier">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <a href="index.php?page=supprimer_quai&id_quai=<?= $quai->getId_quai() ?>" 
                                                       class="btn btn-outline-danger" 
                                                       title="Supprimer"
                                                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer le quai <?= addslashes($quai->getNom()) ?> ?')">
                                                        <i class="bi bi-trash"></i>
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

            <!-- Statistiques -->
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4><?= isset($quais) ? count($quais) : '0' ?></h4>
                                    <p class="mb-0">Quais</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="bi bi-pier fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>