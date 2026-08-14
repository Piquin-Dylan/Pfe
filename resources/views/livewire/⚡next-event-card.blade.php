<?php

use Livewire\Component;

new class extends Component {
    public $game;
    public $train;

    public function mount(): void
    {
        $team = Auth::user()->currentTeam();

        if ($team) {
            $this->game = $team->games()
                ->whereDate('date_match', '>=', today())
                ->orderBy('date_match')
                ->first();

            $this->train = $team->trains()
                ->whereDate('date_train', '>=', today())
                ->orderBy('date_train')
                ->first();
        }
    }
};
?>
<div class="max-w-7xl mx-auto">

    <section
        id="next-event"
        aria-labelledby="next-event-title"
        class="pb-8 lg:pb-20">

        <header class="mb-8">
            <h2
                id="next-event-title"
                class="text-2xl font-bold text-white">
                Les prochaines échéances
            </h2>

            <p class="text-gray-400 mt-1">
                Consultez les prochains événements dès maintenant.
            </p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

            @if($game)
                <x-admin.dashboard.event-card
                    :href="'/match/' . $game->uuid"
                    title="Prochain match"
                    color="blue">

                    <div class="flex-1 flex flex-col justify-center">

                        <div class="mt-4 flex items-center justify-between gap-3">

                            @php
                                $team = Auth::user()->currentTeam();
                            @endphp

                            <div class="flex flex-col items-center flex-1">
                                <div class="w-20 h-20 flex items-center justify-center">
                                    <img
                                        src="{{ $team->logo_url }}"
                                        alt="{{ $team->name }}"
                                        class="w-full h-full object-contain">
                                </div>

                                <span class="mt-2 text-center font-semibold text-sm sm:text-base">
                                    {{ $team->name }}
                                </span>
                            </div>

                            <span class="text-xl sm:text-3xl font-bold text-blue-400">
                                VS
                            </span>

                            <div class="flex flex-col items-center flex-1">
                                <div class="w-20 h-20 flex items-center justify-center">
                                    <img
                                        src="{{ $game->photo_away_url }}"
                                        alt="{{ $game->name_away }}"
                                        class="w-full h-full object-contain">
                                </div>

                                <span class="mt-2 text-center font-semibold text-sm sm:text-base">
                                    {{ $game->name_away }}
                                </span>
                            </div>

                        </div>

                        <div class="mt-8 space-y-3 text-center">
                            <p>{{ \Carbon\Carbon::parse($game->date_match)->format('d/m/Y') }}</p>
                            <p>{{ $game->hours }}</p>

                            <p class="text-gray-300 break-words">
                                {{ $game->address }}
                            </p>
                        </div>

                    </div>

                </x-admin.dashboard.event-card>
            @else
                <x-admin.dashboard.empty-state
                    title="Aucun match programmé"
                    description="Créez un match depuis le calendrier."
                    button-text="Créer un match"
                    :href="route('calendrier')"
                    text-color="text-blue-400"
                    button-color="bg-blue-500 hover:bg-blue-600"/>
            @endif

            @if($train)
                <x-dashboard.event-card
                    :url="'/train/' . $train->uuid"
                    label="Prochain entraînement"
                    :date="$train->date_train"
                    title="Entraînement collectif"
                    :start="$train->hours_start"
                    :end="$train->hours_end"
                    :address="$train->address"/>
            @else
                <x-admin.dashboard.empty-state
                    title="Aucun entraînement programmé"
                    description="Créez un entraînement depuis le calendrier."
                    button-text="Créer un entraînement"
                    :href="route('calendrier')"
                    text-color="text-green-400"
                    button-color="bg-green-500 hover:bg-green-600"/>
            @endif

        </div>

    </section>

</div>
