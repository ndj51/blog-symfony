// public/js/share.js
console.log("// public/js/share.js");
/**
 * Cette fonction contient la logique d'initialisation du bouton
 */
function initShareButton() {
    console.log("je clic sur le bouton");
    const btn = document.getElementById('copy-share-link');
    const feedback = document.getElementById('share-success');

    if (btn && feedback) {
        // On retire un éventuel ancien écouteur pour éviter les doublons
        btn.replaceWith(btn.cloneNode(true));
        
        // On récupère la nouvelle référence après le clone
        const newBtn = document.getElementById('copy-share-link');

        newBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const urlToCopy = newBtn.getAttribute('data-url');

            navigator.clipboard.writeText(urlToCopy).then(() => {
                feedback.style.opacity = '1';
                newBtn.style.transform = 'translate(2px, 2px)';
                newBtn.style.boxShadow = 'none';
                console.log("lien copie");
                setTimeout(() => {
                    feedback.style.opacity = '0';
                    newBtn.style.transform = '';
                    newBtn.style.boxShadow = '';
                }, 2000);
            }).catch(err => {
                console.error('Erreur :', err);
            });
        });
    }
}

// 1. Pour le premier chargement classique
document.addEventListener('DOMContentLoaded', initShareButton);

// 2. Pour les changements de page via Symfony Turbo
document.addEventListener('turbo:load', initShareButton);