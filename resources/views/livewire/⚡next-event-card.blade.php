<?php

use Livewire\Component;

new class extends Component {
    public $game;
    public $train;

    public function mount(): void
    {
        $team = Auth::user()->player
            ? Auth::user()->player->team
            : Auth::user()->team;

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

<div id="next-event" class=" pb-8 grid grid-cols-1 lg:grid-cols-2 gap-5 lg:pb-20">

    @if($game)
        <x-admin.dashboard.event-card
            :href="'/match/' . $game->id"
            title="Prochain match"
            color="blue">

            <div class="mt-4 flex items-center justify-between gap-3">

                @php
                    $team = Auth::user()->team ?? Auth::user()->player?->team;

                    $logo = $team->logo === 'photos/logo_club.png'
                        ? asset('photos/logo_club.png')
                        : asset('storage/' . $team->logo);

                    $photoAway = $game->photo_away === 'photos/logo_club.png'
                        ? asset('photos/logo_club.png')
                        : asset('storage/' . $game->photo_away);
                @endphp

                <div class="flex flex-col items-center flex-1">
                    <img src="{{ $logo }}" alt="{{ $team->name }}"
                         class="w-16 h-16 sm:w-20 sm:h-20 rounded-full object-cover"/>
                    <span class="mt-2 text-center font-semibold text-sm sm:text-base">
                    {{ $team->name }}
                </span>
                </div>

                <span class="text-xl sm:text-3xl font-bold text-blue-400">VS</span>

                <div class="flex flex-col items-center flex-1">
                    <img
                        src="{{ $photoAway }}"
                        alt="{{ $game->name_away }}"
                        class="w-16 h-16 sm:w-20 sm:h-20 rounded-full object-cover"
                    />

                    <span class="mt-2 text-center font-semibold text-sm sm:text-base">
                    {{ $game->name_away }}
                </span>
                </div>

            </div>

            <div class="mt-5 space-y-2 text-center">
                <p>{{ \Carbon\Carbon::parse($game->date_match)->format('d/m/Y') }}</p>
                <p>{{ $game->hours }}</p>
                <p class="text-gray-300">{{ $game->address }}</p>
            </div>

        </x-admin.dashboard.event-card>
    @else
        <x-admin.dashboard.empty-state
            title="Aucun match programmé"
            description="Créez un match depuis le calendrier."
            button-text="Créer un match"
            :href="route('calendrier')"
            text-color="text-blue-400"
            button-color="bg-blue-500 hover:bg-blue-600"
        />
    @endif

    @if($train)
        <x-dashboard.event-card
            :url="'/train/' . $train->id"
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
</div>
