$(document).ready(initApp);

function initApp() {
    loadUserTable();
    loadClasses();  // charger la liste des classes dans le formulaire

    // Gestion ajout utilisateur
    $('#ajout').click(function (e) {
        e.preventDefault();
        ajouterUtilisateur();
    });

    // Gestion modification utilisateur
    $('#modif').click(function (e) {
        e.preventDefault();
        modifierUtilisateur();
    });

    // Gestion suppression utilisateur
    $('#delUser').click(function (e) {
        e.preventDefault();
        supprimerUtilisateur();
    });
}

function loadUserTable() {
    $.ajax({
        url: '../Controleurs/controleur_utilisateur.php',
        method: 'GET',
        data: { action: 'getUsers' },
        dataType: 'json',
        success: function(users) {
            renderUserTable(users);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            showAjaxError(jqXHR, textStatus, errorThrown);
        }
    });
}

function renderUserTable(users) {
    const $tbody = $('#user-table tbody');
    $tbody.empty();

    if (!Array.isArray(users) || users.length === 0) {
        $tbody.append("<tr><td colspan='5'>Aucun utilisateur trouvé.</td></tr>");
        return;
    }

    users.forEach(user => {
        const row = `
            <tr>
                <td>${user.id_utilisateur}</td>
                <td>${escapeHtml(user.nom)}</td>
                <td>${escapeHtml(user.prenom)}</td>
                <td>${escapeHtml(user.nom_classe || 'Non assignée')}</td>
                <td>
                    <button class="btn btn-warning btn-sm btn-modifier" 
                        data-id="${user.id_utilisateur}" 
                        data-nom="${escapeHtml(user.nom)}" 
                        data-prenom="${escapeHtml(user.prenom)}" 
                        data-classe="${user.id_classes || ''}">
                        Modifier
                    </button>
                    <button class="btn btn-danger btn-sm btn-supprimer" data-id="${user.id_utilisateur}">
                        Supprimer
                    </button>
                </td>
            </tr>`;
        $tbody.append(row);
    });

    // Boutons modifier : ouvrir modal avec valeurs remplies
    $('.btn-modifier').click(function () {
        const id = $(this).data('id');
        const nom = $(this).data('nom');
        const prenom = $(this).data('prenom');
        const classe = $(this).data('classe');

        $('#idUserMod').val(id);
        $('#nomMod').val(nom);
        $('#prenomMod').val(prenom);
        $('#classeMod').val(classe);

        const modModal = new bootstrap.Modal(document.getElementById('modUserModal'));
        modModal.show();
    });

    // Boutons supprimer : ouvrir modal de confirmation
    $('.btn-supprimer').click(function () {
        const id = $(this).data('id');
        $('#idUserDel').val(id);

        const delModal = new bootstrap.Modal(document.getElementById('delUserModal'));
        delModal.show();
    });
}

// Fonction ajouter utilisateur (via AJAX)
function ajouterUtilisateur() {
    const nom = $('#nomAdd').val().trim();
    const prenom = $('#prenomAdd').val().trim();
    const classe = $('#classeAdd').val();

    if (!nom || !prenom || !classe) {
        alert('Veuillez remplir tous les champs');
        return;
    }

    $.ajax({
        url: '../Controleurs/controleur_utilisateur.php',
        method: 'POST',
        data: {
            action: 'ajouterUtilisateur',
            nom: nom,
            prenom: prenom,
            classe: classe
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#addUserModal').modal('hide');
                loadUserTable();
                $('#addUserForm')[0].reset();
            } else {
                alert(response.message || 'Erreur lors de l\'ajout');
            }
        },
        error: function() {
            alert('Erreur AJAX lors de l\'ajout');
        }
    });
}

// Fonction modifier utilisateur (via AJAX)
function modifierUtilisateur() {
    const id = $('#idUserMod').val();
    const nom = $('#nomMod').val().trim();
    const prenom = $('#prenomMod').val().trim();
    const classe = $('#classeMod').val();

    if (!nom || !prenom || !classe) {
        alert('Veuillez remplir tous les champs');
        return;
    }

    $.ajax({
        url: '../Controleurs/controleur_utilisateur.php',
        method: 'POST',
        data: {
            action: 'modifierUtilisateur',
            id: id,
            nom: nom,
            prenom: prenom,
            classe: classe
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#modUserModal').modal('hide');
                loadUserTable();
            } else {
                alert(response.message || 'Erreur lors de la modification');
            }
        },
        error: function() {
            alert('Erreur AJAX lors de la modification');
        }
    });
}

// Fonction supprimer utilisateur (via AJAX)
function supprimerUtilisateur() {
    const id = $('#idUserDel').val();

    $.ajax({
        url: '../Controleurs/controleur_utilisateur.php',
        method: 'POST',
        data: {
            action: 'supprimerUtilisateur',
            id: id
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#delUserModal').modal('hide');
                loadUserTable();
            } else {
                alert(response.message || 'Erreur lors de la suppression');
            }
        },
        error: function() {
            alert('Erreur AJAX lors de la suppression');
        }
    });
}

function loadClasses() {
    $.ajax({
        url: '../Controleurs/controleur_utilisateur.php',
        method: 'GET',
        data: { action: 'getClasses' },
        dataType: 'json',
        success: function(classes) {
            const $selectAdd = $('#classeAdd');
            const $selectMod = $('#classeMod');
            $selectAdd.empty();
            $selectMod.empty();

            $selectAdd.append('<option value="">-- Sélectionnez une classe --</option>');
            $selectMod.append('<option value="">-- Sélectionnez une classe --</option>');

            classes.forEach(classe => {
                $selectAdd.append(`<option value="${classe.id_classes}">${escapeHtml(classe.nom_classe)}</option>`);
                $selectMod.append(`<option value="${classe.id_classes}">${escapeHtml(classe.nom_classe)}</option>`);
            });
        },
        error: function() {
            alert('Erreur lors du chargement des classes');
        }
    });
}

function showAjaxError(xhr, status, error) {
    $('#user-table tbody').html(`<tr><td colspan="5" class='alert alert-danger'>Erreur AJAX : ${error}</td></tr>`);
}

function escapeHtml(str) {
    return $('<div>').text(str).html();
}
