document.addEventListener('DOMContentLoaded', function() {
    // Sélectionner tous les boutons d'accordéon dans la section FAQ
    const faqButtons = document.querySelectorAll('.bg-white.p-6.rounded-lg button');
    
    faqButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Trouver le contenu associé à ce bouton (la réponse)
            const content = this.nextElementSibling;
            // Trouver l'icône de flèche
            const arrow = this.querySelector('svg');
            
            // Basculer la visibilité du contenu
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                // Rotation de la flèche
                arrow.classList.add('rotate-180');
            } else {
                content.classList.add('hidden');
                // Remettre la flèche dans sa position initiale
                arrow.classList.remove('rotate-180');
            }
        });
    });
});