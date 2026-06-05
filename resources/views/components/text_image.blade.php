<x-client.array-feature>

    <x-client.feature-tabs></x-client.feature-tabs>

    <div
        x-show="currentTab === 'first'"
        class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 max-w-6xl mx-auto"
    >

        <x-client.feature-card
            key="calendar"
            icon="calendar.svg"
            title="Convocations"
            description="Envoyez vos convocations et recevez les réponses en temps réel."
        />

        <x-client.feature-card
            key="players"
            icon="person.svg"
            title="Joueurs de l’équipe"
            description="Consultez les profils, disponibilités et informations de vos joueurs."
            delay="delay-150"
        />

        <x-client.feature-card
            key="matches"
            icon="ball.svg"
            title="Matchs & entraînements"
            description="Retrouvez votre calendrier et toutes les informations importantes."
            delay="delay-300"
        />

    </div>

    <div
        x-show="activeFeature"
        x-cloak
        x-transition.opacity
        @click.self="activeFeature = null"
        @keydown.escape.window="activeFeature = null"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm p-4"
    >

        <div
            x-show="activeFeature"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            class="relative w-full max-w-6xl rounded-3xl border border-white/10
                   bg-[#111827] p-6 md:p-8 shadow-2xl"
        >

            <button
                @click="activeFeature = null"
                class="absolute top-4 right-4 text-white/60 hover:text-white text-3xl leading-none"
            >
                &times;
            </button>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">

                <div>

                    <div
                        class="w-20 h-20 mb-6 rounded-2xl bg-violet-500/10 border border-violet-500/20 flex items-center justify-center"
                    >
                        <img :src="features[activeFeature]?.icon" width="60" alt="">
                    </div>

                    <span
                        x-text="features[activeFeature]?.title"
                        class="text-white text-3xl font-bold mb-6"
                    ></span>

                    <p
                        x-text="features[activeFeature]?.title"
                        class="text-white/70 text-lg leading-relaxed"
                    ></p>

                    <ul class="mt-6 space-y-3 text-white/70">
                        <li>✓ Interface intuitive et rapide</li>
                        <li>✓ Données mises à jour en temps réel</li>
                        <li>✓ Accessible sur mobile et ordinateur</li>
                    </ul>

                </div>

                <div class="flex justify-center">

                    <div
                        class="rounded-3xl border border-violet-500/20
                               bg-violet-500/5 p-4 w-full"
                    >

                        <img
                            :src="features[activeFeature]?.preview"
                            alt="Aperçu du dashboard"
                            class="w-full max-h-[500px] object-contain rounded-2xl"
                        >

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div
        x-show="currentTab === 'second'"
        class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 max-w-7xl mx-auto">
        <x-client.feature-card
            key="coach_calendar"
            icon="calendar.svg"
            title="Calendrier complet"
            description="Créez vos matchs et entraînements et retrouvez tous vos événements dans un calendrier centralisé."/>

        <x-client.feature-card
            key="coach_convocations"
            icon="person.svg"
            title="Convocations"
            description="Sélectionnez les joueurs convoqués et suivez leurs réponses en temps réel."/>

        <x-client.feature-card
            key="coach_lineup"
            icon="ball.svg"
            title="Composition d’équipe"
            description="Créez votre composition tactique directement après avoir convoqué vos joueurs."/>

        <x-client.feature-card
            key="coach_squad"
            icon="stats.svg"
            title="Gestion de l’effectif"
            description="Consultez les profils de vos joueurs, leurs postes, leurs disponibilités et leurs statistiques."/>

    </div>


</x-client.array-feature>
