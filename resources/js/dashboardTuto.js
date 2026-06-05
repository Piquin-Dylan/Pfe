import {driver} from "driver.js";

export function dashboardTuto() {

    const driverObj = driver({
        nextBtnText: 'suivant',
        prevBtnText: 'précédent',
        doneBtnText: '✕',
        showProgress: true,

        steps: [
            {
                element: '#code',
                popover: {
                    title: 'Partager le code d’équipe',
                    description: 'Partagez ce code avec vos joueurs afin qu’ils puissent rejoindre facilement votre équipe.',
                    side: "left",
                    align: 'start'
                }
            },

            {
                element: '#message',
                popover: {
                    title: 'Messagerie',
                    description: 'Communiquez facilement avec les membres de votre équipe et partagez les informations importantes en temps réel.',
                    side: "left",
                    align: 'start'
                }
            },

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
                element: '#next-event',
                popover: {
                    title: 'Prochains événements',
                    description: 'Retrouvez ici vos prochains matchs et entraînements, avec les dates, horaires et informations importantes à venir.',
                    side: "bottom",
                    align: 'start'
                }
            },

            {
                element: '#match',
                popover: {
                    title: 'Gestion des matchs',
                    description: 'Consultez les matchs de votre équipe, ajoutez de nouvelles rencontres et enregistrez les résultats une fois les matchs terminés.',
                    side: "bottom",
                    align: 'start'
                }
            },
            {
                element: '#train',
                popover: {
                    title: 'Gestion des entraînements',
                    description: 'Planifiez les séances d’entraînement de votre équipe, consultez les entraînements à venir et gérez les informations associées.',
                    side: "bottom",
                    align: 'start'
                }
            },
            {
                element: '#team',
                popover: {
                    title: 'Équipe',
                    description: 'Retrouvez tous les membres de votre équipe, gérez les informations du groupe et invitez de nouveaux joueurs.',
                    side: "bottom",
                    align: 'start'
                }
            },
            {
                element: '#calendrier',
                popover: {
                    title: 'Calendrier',
                    description: 'Consultez l’ensemble des événements de votre équipe, notamment les matchs et les entraînements à venir.',
                    side: "bottom",
                    align: 'start'
                }
            },
            {
                element: '#settings',
                popover: {
                    title: 'Mon profil',
                    description: 'Consultez et modifiez vos informations personnelles afin de maintenir votre profil à jour.',
                    side: "bottom",
                    align: 'start'
                }
            },
        ]
    });

    driverObj.drive();
}
