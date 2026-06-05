<div
    x-data="{
    currentTab: 'first',
    visible: false,
    activeFeature: null,

    features: {

        calendar: {
            title: 'Convocations',
            description: 'Envoyez vos convocations et recevez les réponses en temps réel.',
            icon: '{{ asset('calendar.svg') }}',
            preview: '{{ asset('calendrier.png') }}'
        },

        players: {
            title: 'Joueurs de l’équipe',
            description: 'Consultez les profils, disponibilités et informations de vos joueurs.',
            icon: '{{ asset('person.svg') }}',
            preview: '{{ asset('team.png') }}'
        },

        matches: {
            title: 'Matchs & entraînements',
            description: 'Retrouvez votre calendrier et toutes les informations importantes.',
            icon: '{{ asset('ball.svg') }}',
            preview: '{{ asset('match.png') }}'
        },

        coach_calendar: {
            title: 'Calendrier complet',
            description: 'Créez vos matchs et entraînements et retrouvez tous vos événements dans un calendrier centralisé.',
            icon: '{{ asset('calendar.svg') }}',
            preview: '{{ asset('calendrier.png') }}'
        },

        coach_convocations: {
            title: 'Convocations',
            description: 'Sélectionnez les joueurs convoqués et suivez leurs réponses en temps réel.',
            icon: '{{ asset('person.svg') }}',
            preview: '{{ asset('convoc.png') }}'
        },

        coach_lineup: {
            title: 'Composition d’équipe',
            description: 'Créez votre composition tactique directement après avoir convoqué vos joueurs.',
            icon: '{{ asset('ball.svg') }}',
            preview: '{{ asset('compos.png') }}'
        },

        coach_squad: {
            title: 'Gestion de l’effectif',
            description: 'Consultez les profils de vos joueurs, leurs postes, leurs disponibilités et leurs statistiques.',
            icon: '{{ asset('stats.svg') }}',
            preview: '{{ asset('team.png') }}'
        }
    }
}"
    x-intersect.once="visible = true">

    {{$slot}}
</div>
