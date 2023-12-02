// main.js

document.addEventListener('DOMContentLoaded', function () {
    // Sélectionnez tous les éléments .dropdown
    var dropdowns = document.querySelectorAll('.dropdown');
  
    // Attachez un gestionnaire d'événements à chaque élément .dropdown
    dropdowns.forEach(function (dropdown) {
      var trigger = dropdown.querySelector('.dropdown-trigger');
  
      // Gestionnaire d'événement pour le clic sur le bouton déclencheur
      trigger.addEventListener('click', function () {
        // Basculez la classe active sur le conteneur .dropdown
        dropdown.classList.toggle('active');
      });
    });
  });
  