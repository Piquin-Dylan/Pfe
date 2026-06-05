import {Calendar} from '@fullcalendar/core'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
import frLocale from '@fullcalendar/core/locales/fr'
import {matchTuto} from './matchTuto.js'
import {matchListTuto} from './matchListTuto.js'
import {dashboardTuto} from "./dashboardTuto.js";
import {settings} from './settings.js'

document.addEventListener('livewire:init', () => {

    Livewire.on('start-match-tutorial', () => {

        if (document.querySelector(settings.match.selector)) {
            matchTuto()
        }

    })

    Livewire.on('start-match-list-tutorial', () => {

        if (document.querySelector(settings.match_list.selector)) {
            matchListTuto()
        }

    })

    Livewire.on('start-dashboard-tutorial', () => {

        if (document.querySelector(settings.dashboard.selector)) {
            dashboardTuto()
        }

    })

})
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
