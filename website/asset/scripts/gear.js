    // Ajoutez un écouteur d'événement pour le clic sur le lien "Ajouter du matériel"
    gearLink.addEventListener('click', function() {
        const modal = document.getElementById('modal-gear');
        modal.style.display = 'block';
    });

    // Fermez la modal lorsque l'utilisateur clique en dehors de la modal
window.addEventListener('click', function(event) {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});