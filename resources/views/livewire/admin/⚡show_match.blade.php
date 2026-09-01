<?php

use App\Livewire\Concerns\HandlesTutorial;
use App\Models\Game;
use Livewire\Component;

new class extends Component {

    use HandlesTutorial;

    public Game $games;

    public function mount(Game $match): void
    {
        $this->games = $match;
        $this->authorize('view', $this->games);

        $this->initializeTutorial('match_convocation', 'start-match-tutorial');
    }

};
?>

<div class="max-w-7xl mx-auto">

    <h3 class="title_section " id="tuto">
        Match du
        {{ \Carbon\Carbon::parse($games->date_match)->locale('fr')->translatedFormat('d F') }}
        : {{$games->address}}
    </h3>

    <div class="grid grid-cols-[1fr_auto_1fr] items-start gap-6 pt-4 pb-8" id="affiche">

        <div class="flex flex-col items-center text-center min-w-0">

            @php
                $team = Auth::user()->currentTeam();
            @endphp

            <div class="w-40 h-40 flex items-center justify-center mb-6">
                <img
                    class="max-w-full max-h-full object-contain"
                    alt="{{ $team->name }}"
                    src="{{ $team->logo_url }}">
            </div>

            <span class="text-white text-2xl max-w-[220px] break-words leading-tight">
    {{ $team->name }}
</span>
        </div>

        <div class="flex items-center justify-center h-full">
        <span class="text-2xl text-white font-semibold whitespace-nowrap">
            {{ $games->hours }}
        </span>
        </div>

        <div class="flex flex-col items-center text-center min-w-0">
            <div class="w-40 h-40 flex items-center justify-center mb-6">
                <img
                    class="max-w-full max-h-full object-contain"
                    alt="{{ $games->name_away }}"
                    src="{{ $games->photo_away_url }}">
            </div>

            <span class="text-white text-2xl max-w-[220px] break-words leading-tight">
            {{ $games->name_away }}
        </span>
        </div>

    </div>

    <div x-data="{ currentTab: 'first' }">
        @include('livewire.components.navigation_match')

        <div x-show="currentTab === 'first'">
            <livewire:admin.show_match.convocation :match="$games" :key="'convocation-'.$games->uuid" />
        </div>

        <div x-show="currentTab === 'second'">
            <livewire:admin.show_match.sheet :match="$games" :key="'sheet-'.$games->uuid" />
        </div>

        <div x-show="currentTab === 'third'">
            <livewire:admin.show_match.composition :match="$games" :key="'composition-'.$games->uuid" />
        </div>
    </div>

</div>
