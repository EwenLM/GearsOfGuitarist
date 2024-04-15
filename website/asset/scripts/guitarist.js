
// =======================Couleurs page guitariste ======================

let bentoGuitarists = document.getElementsByClassName('bentoGuitarist');
let bentoBoxGuitarists = document.querySelectorAll('.bentoBoxGuitarist');

//Attribue aléatoirement une couleur aux classes 'bentoGuitarist'
let colors = ['#0054D1', '#00BD4C', '#BD0022', '#980FEC', '#EC790F'];
let randomIndex = Math.floor(Math.random() * colors.length);
let backgroundColor = colors[randomIndex];

for (let i = 0; i < bentoGuitarists.length; i++) {
    bentoGuitarists[i].style.backgroundColor = backgroundColor;
}

// Fonction pour obtenir la couleur secondaire associée à celle attribue aléatoirement
function randomColor(backgroundColor) {
    switch (backgroundColor) {
        case '#0054D1':
            return '#1570F9';
        case '#00BD4C':
            return '#62C88B';
        case '#BD0022':
            return '#ED4160';
        case '#980FEC':
            return '#B336FF';
        case '#EC790F':
            return '#FF9330';
        default:
            return '#FFFFFF';
    }
}

let color2 = randomColor(backgroundColor);

for (let i = 0; i < bentoBoxGuitarists.length; i++) {
    bentoBoxGuitarists[i].style.backgroundColor = color2;
}





//==================== Accordeon pour les musiques=====================

// Récupération class des musiques
let trackTitles = document.querySelectorAll('.track-title');


trackTitles.forEach(function (title) {
    title.addEventListener('click', function () {

        let content = this.nextElementSibling;
        // Si le contenu est déjà ouvert, le fermer, sinon l'ouvrir
        if (content.style.display === 'block') {
            content.style.display = 'none';
            this.classList.remove('active');
        } else {
            // Fermer 
            let allContents = document.querySelectorAll('.track-content');
            allContents.forEach(function (item) {
                item.style.display = 'none';
            });
            let allTitles = document.querySelectorAll('.track-title');
            allTitles.forEach(function (item) {
                item.classList.remove('active');
            });
            // Ouvrir
            content.style.display = 'block';
            this.classList.add('active');
        }
    });
});


//========================= Boite modal des albums=========================


// Sélectionnez les éléments nécessaires
const albumLinks = document.querySelectorAll('.album-link');
const gearLink = document.querySelector('.gear');

// Ajoutez des écouteurs d'événements pour le clic sur les liens d'album
albumLinks.forEach(link => {
    link.addEventListener('click', function() {
        const albumTitle = this.getAttribute('data-album');
        const modal = document.getElementById(`modal-${albumTitle}`);
        modal.style.display = 'block';
    });
});




// Fermez la modal lorsque l'utilisateur clique sur le bouton de fermeture
const closeButtons = document.querySelectorAll('.close');
closeButtons.forEach(button => {
    button.addEventListener('click', function() {
        const modal = this.parentElement.parentElement;
        modal.style.display = 'none';
    });
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



