import {driver} from "driver.js";

export function dashboardTuto() {

    const driverObj = driver({
        nextBtnText: 'suivant',
        prevBtnText: 'précédent',
        doneBtnText: '✕',
        showProgress: true,

        steps: [
            {
                element: '#stats',
                popover: {
                    title: 'Statistiques générales',
                    description: 'Retrouvez ici le nombre de joueurs, matchs et entraînements associés à votre équipe.',
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
                element: '#convocation',
                popover: {
                    title: 'Convocation pour le match',
                    description: 'Dans cette partie de la page vous pourrez convoqué les joueurs que vous souhaitez prendre',
                    side: "bottom",
                    align: 'start'
                }
            },

            {
                element: '#feuille_de_match',
                popover: {
                    title: 'Feuille de match',
                    description: 'Dans la partie feuille de match vous pourrez retrouver tout les joueurs convoqué avec leur status',
                    side: "left",
                    align: 'start'
                }
            },

            {
                element: '#composition',
                popover: {
                    title: "Composition d'équipe",
                    description: 'Dans cette partie vous pourrez créer directement votre compos pour le match avec les joueur présent',
                    side: "top",
                    align: 'start'
                }
            },
        ]
    });

    driverObj.drive();
}
