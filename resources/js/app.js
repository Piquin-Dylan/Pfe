/*

import {driver} from "driver.js";
import "driver.js/dist/driver.css";

const driverObj = driver({
    nextBtnText: 'suivant',
    prevBtnText: 'précédent',
    doneBtnText: '✕',
    showProgress: true,
    steps: [
        {
            element: '#tuto',
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


*/

import {Calendar} from '@fullcalendar/core'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
import frLocale from '@fullcalendar/core/locales/fr'

document.addEventListener('DOMContentLoaded', () => {
    const calendarEl = document.getElementById('calendar')

    if (!calendarEl) return

    const calendar = new Calendar(calendarEl, {
        plugins: [
            dayGridPlugin,
            timeGridPlugin,
            interactionPlugin,
        ],

        locale: frLocale,
        initialView: 'dayGridMonth',
        height: 'auto',

        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay',
        },

        buttonText: {
            today: "Aujourd'hui",
            month: 'Mois',
            week: 'Semaine',
            day: 'Jour',
        },

        events: '/calendar/events',

        editable: false,
        selectable: true,
        navLinks: true,
        dayMaxEvents: true,

        eventClick(info) {
            const modal = document.getElementById('dialog');
            console.log(info.event.id)
            Alpine.$data(modal).openEvent(info.event);
        },

        dateClick(info) {
            console.log('Date cliquée :', info.dateStr)
        },
    })

    window.calendar = calendar

    calendar.render()

    window.addEventListener('refresh-calendar', () => {
        window.calendar.refetchEvents()
    })
})
