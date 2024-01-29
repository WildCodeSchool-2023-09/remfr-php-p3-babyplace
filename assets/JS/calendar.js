// Fonction pour charger et afficher la modal
function loadAndShowModal() {
  fetch('/calendar/new')
    .then(response => response.text())
    .then(html => {
      // Insérer le contenu de la modal dans le corps du document
      document.body.insertAdjacentHTML('beforeend', html);

      // Activer la modal après avoir ajouté son contenu au DOM
      const modal = new bootstrap.Modal(document.getElementById('modal'));
      modal.show();

      // Attendre que la modal soit affichée avant d'ajouter le gestionnaire de soumission
      modal._element.addEventListener('shown.bs.modal', addSubmitHandler);
    })
    .catch(error => {
      console.error('Erreur lors du chargement de la modal :', error);
    });
}

// Fonction pour ajouter le gestionnaire de soumission au formulaire de la modal
function addSubmitHandler() {
  // Récupérer le formulaire de la modal
  const formInModal = document.getElementById('myFormInModal');

  formInModal.addEventListener('submit', function (event) {
    event.preventDefault(); // Empêcher le comportement par défaut du formulaire

    // Récupérer les données du formulaire
    const formData = new FormData(formInModal);

    // Configuration de la requête fetch pour soumettre les données du formulaire au serveur
    fetch('/calendar/new', {
      method: 'POST',
      body: formData // Les données du formulaire (FormData)
    })
      .then(response => {
        if (!response.ok) {
          throw new Error('Erreur lors de la requête');
        }
        // Soumission réussie du formulaire, fermer la modal après un court délai
        setTimeout(function () {
          const modal = new bootstrap.Modal(document.getElementById('modal'));
          modal.hide();
          // Recharger la page après la fermeture de la modal
          window.location.reload();
        }, 500); // Attendre 500ms avant de fermer la modal et recharger la page (à des fins de démonstration)
      })
      .catch(error => {
        console.error('Erreur lors de la soumission du formulaire :', error);
        // Gérer les erreurs ici (afficher un message d'erreur, etc.)
      });
  });
}

// Ajouter l'écouteur d'événement au bouton pour charger et afficher la modal
if (document.body.contains(document.getElementById('calendarModalButton'))) {
  document.getElementById('calendarModalButton').addEventListener('click', loadAndShowModal);
}
