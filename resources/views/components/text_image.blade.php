<x-client.array-feature>

<div x-cloak>
    <x-client.feature-tabs/>
</div>

<noscript>
    <div class="max-w-7xl mx-auto mt-24 mb-10">
        <div class="flex items-center gap-4">
            <div class="flex-1 h-px bg-white/10"></div>

            <h3 class="text-3xl font-bold text-white">
                Fonctionnalités joueur
            </h3>

            <div class="flex-1 h-px bg-white/10"></div>
        </div>
    </div>
</noscript>

<div
    x-show="currentTab === 'first'"
    class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 max-w-6xl mx-auto">

    <div>

        <x-client.feature-card
            key="calendar"
            icon="calendar.svg"
            title="Convocations"
            description="Envoyez vos convocations et recevez les réponses en temps réel."/>
    </div>

    <div>

        <x-client.feature-card
            key="players"
            icon="person.svg"
            title="Joueurs de l’équipe"
            description="Consultez les profils, disponibilités et informations de vos joueurs."
            delay="delay-150"/>
    </div>

    <div>

        <x-client.feature-card
            key="matches"
            icon="ball.svg"
            title="Matchs & entraînements"
            description="Retrouvez votre calendrier et toutes les informations importantes."
            delay="delay-300"/>
    </div>

</div>

<noscript>
    <div class="max-w-7xl mx-auto mt-16 mb-10">

        <div class="flex items-center gap-4">
            <div class="flex-1 h-px bg-white/10"></div>

            <h3 class="text-3xl font-bold text-white">
                Fonctionnalités entraîneur
            </h3>

            <div class="flex-1 h-px bg-white/10"></div>
        </div>
    </div>
</noscript>

<div
    x-show="currentTab === 'second'"
    class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 max-w-7xl mx-auto mt-16">

    <div>

        <x-client.feature-card
            key="coach_calendar"
            icon="calendar.svg"
            title="Calendrier complet"
            description="Créez vos matchs et entraînements et retrouvez tous vos événements dans un calendrier centralisé."/>
    </div>

    <div>

        <x-client.feature-card
            key="coach_convocations"
            icon="person.svg"
            title="Convocations"
            description="Sélectionnez les joueurs convoqués et suivez leurs réponses en temps réel."/>
    </div>

    <div>

        <x-client.feature-card
            key="coach_lineup"
            icon="ball.svg"
            title="Composition d’équipe"
            description="Créez votre composition tactique directement après avoir convoqué vos joueurs."/>
    </div>

    <div>

        <x-client.feature-card
            key="coach_squad"
            icon="stats.svg"
            title="Gestion de l’effectif"
            description="Consultez les profils de vos joueurs, leurs postes, leurs disponibilités et leurs statistiques."/>
    </div>

</div>

<div
    x-show="activeFeature"
    x-cloak
    x-transition.opacity
    @click.self="activeFeature = null"
    @keydown.escape.window="activeFeature = null"
    class="fixed inset-0 z-50 flex items-center justify-center bg-[var(--color-overlay)] backdrop-blur-sm p-4">

    <div
        x-show="activeFeature"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        class="relative w-full max-w-6xl rounded-3xl border border-[var(--color-border)] bg-[var(--color-background)] p-6 md:p-8 shadow-2xl">

        <button
            @click="activeFeature = null"
            class="absolute top-4 right-4 text-[var(--color-text-muted)] hover:text-[var(--color-white)] text-3xl leading-none">
            &times;
        </button>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">

            <div>

                <div
                    class="w-20 h-20 mb-6 rounded-2xl bg-[var(--color-primary-medium)] border border-[var(--color-primary-border)] flex items-center justify-center">
                    <img
                        src="/public/team.png"
                        :src="features[activeFeature]?.icon"
                        width="60"
                        alt="Appercu de la fonctionnalité dans le dashboard">
                </div>

                <span
                    x-text="features[activeFeature]?.title"
                    class="block text-[var(--color-white)] text-3xl font-bold mb-6">
                </span>

                <p
                    x-text="features[activeFeature]?.description"
                    class="text-[var(--color-text-secondary)] text-lg leading-relaxed">
                </p>

            </div>

            <div class="flex justify-center">
                <div
                    class="rounded-3xl border border-[var(--color-primary-border)] bg-[var(--color-primary-light)] p-4 w-full">

                    <img
                        src="/public/team.png"
                        :src="features[activeFeature]?.preview"
                        alt="Aperçu d'une fonctionnalité"
                        class="w-full max-h-[500px] object-contain rounded-2xl">
                </div>

            </div>

        </div>

    </div>

</div>

</x-client.array-feature>
