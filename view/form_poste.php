<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Poste d'Accostage - Port de La Rochelle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        .container-main {
            max-width: 600px;
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
                    <i class="bi bi-plus-circle"></i> Nouveau Poste d'Accostage
                </h1>
                <a href="index.php?page=postes&id_quai=<?= $quai->getId_quai() ?>" class="btn btn-secondary">
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
                        <i class="bi bi-pencil"></i> Informations du Poste
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label">Quai associé</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($quai->getNom()) ?> (ID: <?= $quai->getId_quai() ?>)" disabled>
                            <input type="hidden" name="id_quai" value="<?= $quai->getId_quai() ?>">
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> 
                            Le poste d'accostage sera créé avec un identifiant automatique. 
                            Vous pourrez le visualiser dans la liste des postes après création.
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="index.php?page=postes&id_quai=<?= $quai->getId_quai() ?>" class="btn btn-secondary me-md-2">
                                <i class="bi bi-x-circle"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Créer le Poste
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