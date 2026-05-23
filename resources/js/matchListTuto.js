import {driver} from "driver.js";
import "driver.js/dist/driver.css";

export function matchListTuto() {

    const driverObj = driver({
        nextBtnText: 'suivant',
        prevBtnText: 'précédent',
        doneBtnText: '✕',
        showProgress: true,

        steps: [
            {
                element: '#address',
                popover: {
                    title: 'Adresse du match',
                    description: "Vous retrouverez l'adresse du match ici",
                    side: "left",
                    align: 'start'
                }
            },

            {
                element: '#affiche',
                popover: {
                    title: 'Affiche du match',
                    description: 'Vous trouverez ici l heure du match ainsi que l équipe adverse contre lequel vous jouez prochainement',
                    side: "bottom",
                    align: 'start'
                }
            },

            {
                element: '#cta_convocation',
                popover: {
                    title: 'Convocation pour le match',
                    description: "Ce bouton vous permet d'accéder à la fiche complète du match afin de réaliser vos convocations, gérer la feuille de match et créer votre composition d'équipe.",
                    side: "bottom",
                    align: 'start'
                }
            },
        ]
    });

    driverObj.drive();
}
