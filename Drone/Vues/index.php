<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Liste des Utilisateurs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap 5 CSS & JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

    <style>
        .mod {
            color: blue;
            cursor: pointer;
        }
        .supp {
            color: red;
            cursor: pointer;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="acceuil.php">Accueil</a></li>
        <li class="nav-item"><a class="nav-link" href="historique.php">Historique</a></li>
        <li class="nav-item"><a class="nav-link" href="stat.php">Statistiques</a></li>
        <li class="nav-item"><a class="nav-link" href="ajouter.php">Ajout élève</a></li>
        <li class="nav-item"><a class="nav-link" href="connection.php">Connexion</a></li>
    </ul>
</nav>

<div class="container my-4">
    <header class="d-flex justify-content-between my-4">
        <h1>Liste des Utilisateurs</h1>
        <button class="btn btn-primary" id="btnAddUser" data-bs-toggle="modal" data-bs-target="#addUserModal">
            Ajouter un Utilisateur
        </button>
    </header>

    <table id="user-table" class="table table-striped table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Classe</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Contenu chargé dynamiquement via AJAX -->
        </tbody>
    </table>
</div>

<!-- Modal Ajouter -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un utilisateur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    <div class="mb-3">
                        <label for="nomAdd" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="nomAdd" required />
                    </div>
                    <div class="mb-3">
                        <label for="prenomAdd" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="prenomAdd" required />
                    </div>
                    <div class="mb-3">
                        <label for="classeAdd" class="form-label">Classe</label>
                        <select id="classeAdd" class="form-control" required>
                            <option value="">-- Sélectionnez une classe --</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button class="btn btn-primary" id="ajout">Ajouter</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Modifier -->
<div class="modal fade" id="modUserModal" tabindex="-1" aria-labelledby="modUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier un utilisateur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <form id="modUserForm">
                    <div class="mb-3">
                        <label for="nomMod" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="nomMod" required />
                    </div>
                    <div class="mb-3">
                        <label for="prenomMod" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="prenomMod" required />
                    </div>
                    <div class="mb-3">
                        <label for="classeMod" class="form-label">Classe</label>
                        <select id="classeMod" class="form-control" required>
                            <option value="">-- Sélectionnez une classe --</option>
                        </select>
                    </div>
                    <input type="hidden" id="idUserMod" />
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button class="btn btn-primary" id="modif">Mettre à jour</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Supprimer -->
<div class="modal fade" id="delUserModal" tabindex="-1" aria-labelledby="delUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Supprimer un utilisateur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <p>Voulez-vous vraiment supprimer cet utilisateur ?</p>
                <input type="hidden" id="idUserDel" />
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button class="btn btn-danger" id="delUser">Supprimer</button>
            </div>
        </div>
    </div>
</div>

<script src="js/utilisateurs.js"></script>
</body>
</html>
