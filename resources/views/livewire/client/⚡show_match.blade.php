<?php

use App\Models\Game;
use App\Models\MatchComposition;
use App\Notifications\ParticipationResponseNotification;
use Livewire\Component;

new class extends Component {

    public Game $games;

    public string $match_composition = "4-4-2";

    public array $player_position = [];

    public ?string $myStatus = null;

    public ?string $myPosition = null;

    public function mount($id): void
    {
        $this->games = Game::where('uuid', $id)->firstOrFail();
        $this->authorize('view', $this->games);

        $myPlayer = Auth::user()->player;

        $convocation = $this->games->players->firstWhere('id', $myPlayer->id);
        $this->myStatus = $convocation?->pivot->status;

        $compositions = MatchComposition::where('match_id', $this->games->id)->get();

        foreach ($compositions as $composition) {
            $this->player_position[$composition->position] = $composition->player_id;

            if ($composition->player_id === $myPlayer->id) {
                $this->myPosition = $composition->position;
            }
        }
    }

    public function respondConvocation(string $status): void
    {
        if (!in_array($status, ['present', 'absent'])) {
            return;
        }

        $myPlayer = Auth::user()->player;

        $isConvoked = $this->games->players->contains('id', $myPlayer->id);

        if (!$isConvoked) {
            return;
        }

        $this->games->players()->updateExistingPivot($myPlayer->id, [
            'status' => $status,
        ]);

        $this->myStatus = $status;

        $this->games->team->user->notify(
            new ParticipationResponseNotification('match', $status, $myPlayer->id, $this->games)
        );
    }
};
?>

<div class="max-w-7xl mx-auto">

    <h3 class="title_section" id="tuto">
        Match du
        {{ \Carbon\Carbon::parse($games->date_match)->locale('fr')->translatedFormat('d F') }}
        : {{ $games->address }}
    </h3>

    <div class="grid grid-cols-[1fr_auto_1fr] items-start gap-6 pt-4 pb-8" id="affiche">

        <div class="flex flex-col items-center text-center min-w-0">

            @php
                $team = $games->team;
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

    <div class="flex flex-col items-center gap-4 pb-12">

        @if(is_null($myStatus))

            <p class="text-gray-400 text-center">
                Vous n'êtes pas convoqué pour ce match.
            </p>

        @else

            <div class="flex items-center gap-3">
                <span class="text-white">Votre statut :</span>
                <x-status-badge :status="$myStatus" />
            </div>

            <div class="flex gap-4">
                <button
                    wire:click="respondConvocation('present')"
                    @disabled($myStatus === 'present')
                    class="btn-primary disabled:opacity-40 disabled:cursor-not-allowed">
                    Je serai présent
                </button>

                <button
                    wire:click="respondConvocation('absent')"
                    @disabled($myStatus === 'absent')
                    class="bg-red-500/20 text-red-400 border border-red-500/40 px-6 py-3 rounded-2xl font-semibold hover:bg-red-500/30 transition cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed">
                    Je ne serai pas présent
                </button>
            </div>

        @endif

    </div>

    @if(!empty($player_position))

        <div class="pb-12">
            <h2 class="text-white text-2xl font-bold text-center mb-6">
                Composition
            </h2>

            @if($myPosition)
                <p class="text-purple-400 text-center mb-4">
                    Vous jouez au poste : <span class="font-semibold">{{ $myPosition }}</span>
                </p>
            @endif

            <div
                x-data="{ selectedPlayer: @js($myPosition) }"
                class="relative w-full max-w-3xl mx-auto h-[700px] rounded-3xl overflow-hidden">
                @foreach(config('player_compositions.' . $match_composition) as $slot)

                    @php
                        $displayName = $slot['poste'];
                        $displayImage = null;

                        if (isset($player_position[$slot['poste']])) {
                            $playerId = $player_position[$slot['poste']];
                            $placedPlayer = $games->players->firstWhere('id', $playerId);

                            if ($placedPlayer) {
                                $displayName = $placedPlayer->firstName;
                                $displayImage = $placedPlayer->user->image_url;
                            }
                        }
                    @endphp

                    <x-player_position
                        x="{{ $slot['x'] }}"
                        y="{{ $slot['y'] }}"
                        poste="{{ $displayName }}"
                        activePoste="{{ $slot['poste'] }}"
                        :image="$displayImage"
                    />

                @endforeach
            </div>
        </div>

    @endif

</div>
