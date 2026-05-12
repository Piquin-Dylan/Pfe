{{--
@props([
    'name',
    'alt',
    'src',

])
<div class="flex flex-row g-5 items-center">
<span class="order-1 text-white text-[20px]">{{$name}}</span>
<img src="{{$src}}" alt="{{$alt}}">
</div>
--}}
<div
    x-data="{
        currentTab: 'first',
        visible: false,
        activeFeature: null,
        features: {
            stats: {
                title: 'Statistiques personnelles',
                description: 'Analysez vos performances et suivez votre progression au fil de la saison.',
                icon: '{{ asset('stats.svg') }}'
            },
            calendar: {
                title: 'Convocations',
                description: 'Envoyez vos convocations et recevez les réponses en temps réel.',
                icon: '{{ asset('calendar.svg') }}'
            },
            players: {
                title: 'Joueurs de l’équipe',
                description: 'Consultez les profils, disponibilités et informations de vos joueurs.',
                icon: '{{ asset('person.svg') }}'
            },
            matches: {
                title: 'Matchs & entraînements',
                description: 'Retrouvez votre calendrier et toutes les informations importantes.',
                icon: '{{ asset('ball.svg') }}'
            }
        }
    }"
    x-intersect.once="visible = true"
>
    <div class="flex gap-10 justify-center pt-6 pb-16">
        <button
            @click="currentTab = 'first'"
            :class="currentTab === 'first'
                ? 'text-white border-b-2 border-violet-500'
                : 'text-white/70 border-b-2 border-transparent hover:text-white'"
            class="pb-2 font-semibold transition-all duration-300 text-2xl cursor-pointer"
        >
            Joueur
        </button>

        <button
            @click="currentTab = 'second'"
            :class="currentTab === 'second'
                ? 'text-white border-b-2 border-violet-500'
                : 'text-white/70 border-b-2 border-transparent hover:text-white'"
            class="pb-2 font-semibold transition-all duration-300 text-2xl cursor-pointer"
        >
            Entraîneur
        </button>
    </div>

    <div
        x-show="currentTab === 'first'"
        class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 max-w-7xl mx-auto"
    >
        <div
            @click="activeFeature = 'stats'"
            x-show="visible"
            x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 translate-y-10"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="cursor-pointer bg-white/5 border border-white/10 rounded-3xl
                   p-8 min-h-[340px] h-full flex flex-col
                   hover:border-violet-500/70 hover:bg-white/10 hover:-translate-y-2
                   transition-all duration-300"
        >
            <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-violet-500/10 border border-violet-500/20 flex items-center justify-center">
                <img width="60" src="{{ asset('stats.svg') }}" alt="">
            </div>

            <h3 class="text-white text-xl font-semibold text-center mb-3">
                Statistiques personnelles
            </h3>

            <p class="text-white/70 text-center text-sm leading-relaxed flex-grow">
                Analysez vos performances et suivez votre progression au fil de la saison.
            </p>

            <p class="text-violet-400 text-sm text-center mt-6 font-medium">
                Cliquez pour découvrir →
            </p>
        </div>

        <div
            @click="activeFeature = 'calendar'"
            x-show="visible"
            x-transition:enter="transition ease-out duration-700 delay-150"
            x-transition:enter-start="opacity-0 translate-y-10"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="cursor-pointer bg-white/5 border border-white/10 rounded-3xl
                   p-8 min-h-[340px] h-full flex flex-col
                   hover:border-violet-500/70 hover:bg-white/10 hover:-translate-y-2
                   transition-all duration-300"
        >
            <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-violet-500/10 border border-violet-500/20 flex items-center justify-center">
                <img width="60" src="{{ asset('calendar.svg') }}" alt="">
            </div>

            <h3 class="text-white text-xl font-semibold text-center mb-3">
                Convocations
            </h3>

            <p class="text-white/70 text-center text-sm leading-relaxed flex-grow">
                Envoyez vos convocations et recevez les réponses en temps réel.
            </p>

            <p class="text-violet-400 text-sm text-center mt-6 font-medium">
                Cliquez pour découvrir →
            </p>
        </div>

        <div
            @click="activeFeature = 'players'"
            x-show="visible"
            x-transition:enter="transition ease-out duration-700 delay-300"
            x-transition:enter-start="opacity-0 translate-y-10"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="cursor-pointer bg-white/5 border border-white/10 rounded-3xl
                   p-8 min-h-[340px] h-full flex flex-col
                   hover:border-violet-500/70 hover:bg-white/10 hover:-translate-y-2
                   transition-all duration-300"
        >
            <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-violet-500/10 border border-violet-500/20 flex items-center justify-center">
                <img width="60" src="{{ asset('person.svg') }}" alt="">
            </div>

            <h3 class="text-white text-xl font-semibold text-center mb-3">
                Joueurs de l’équipe
            </h3>

            <p class="text-white/70 text-center text-sm leading-relaxed flex-grow">
                Consultez les profils, disponibilités et informations de vos joueurs.
            </p>

            <p class="text-violet-400 text-sm text-center mt-6 font-medium">
                Cliquez pour découvrir →
            </p>
        </div>

        <div
            @click="activeFeature = 'matches'"
            x-show="visible"
            x-transition:enter="transition ease-out duration-700 delay-500"
            x-transition:enter-start="opacity-0 translate-y-10"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="cursor-pointer bg-white/5 border border-white/10 rounded-3xl
                   p-8 min-h-[340px] h-full flex flex-col
                   hover:border-violet-500/70 hover:bg-white/10 hover:-translate-y-2
                   transition-all duration-300"
        >
            <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-violet-500/10 border border-violet-500/20 flex items-center justify-center">
                <img width="60" src="{{ asset('ball.svg') }}" alt="">
            </div>

            <h3 class="text-white text-xl font-semibold text-center mb-3">
                Matchs & entraînements
            </h3>

            <p class="text-white/70 text-center text-sm leading-relaxed flex-grow">
                Retrouvez votre calendrier et toutes les informations importantes.
            </p>

            <p class="text-violet-400 text-sm text-center mt-6 font-medium">
                Cliquez pour découvrir →
            </p>
        </div>
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
            class="relative w-full max-w-4xl rounded-3xl border border-white/10
                   bg-[#111827] p-8 shadow-2xl"
        >
            <button
                @click="activeFeature = null"
                class="absolute top-4 right-4 text-white/60 hover:text-white text-3xl leading-none"
            >
                &times;
            </button>

            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <div class="w-20 h-20 mb-6 rounded-2xl bg-violet-500/10 border border-violet-500/20 flex items-center justify-center">
                        <img :src="features[activeFeature].icon" width="60" alt="">
                    </div>

                    <h3
                        x-text="features[activeFeature].title"
                        class="text-3xl font-bold text-white mb-4"
                    ></h3>

                    <p
                        x-text="features[activeFeature].description"
                        class="text-white/70 text-lg leading-relaxed"
                    ></p>

                    <ul class="mt-6 space-y-3 text-white/70">
                        <li>✓ Interface intuitive et rapide</li>
                        <li>✓ Données mises à jour en temps réel</li>
                        <li>✓ Accessible sur mobile et ordinateur</li>
                    </ul>
                </div>

                <div class="flex justify-center">
                    <div class="rounded-2xl border border-violet-500/20 bg-violet-500/5 p-4">
                        <img
                            src="{{ asset('dashboard-preview.png') }}"
                            alt="Aperçu du dashboard"
                            class="max-h-[500px] object-contain rounded-xl"
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
