<?php

use App\Models\Game;
use App\Models\Player;
use App\Models\Train;
use App\Notifications\ParticipationResponseNotification;
use Livewire\Component;

new class extends Component {

    public ?Game $match = null;

    public ?Train $train = null;

    public string $type;

    public string $status;

    public function mount(Player $player, string $status, ?Game $match = null, ?Train $train = null): void
    {
        $this->status = $status;
        $this->match = $match;
        $this->train = $train;

        if ($this->train) {
            $this->type = 'train';

            $this->train->players()->updateExistingPivot($player->id, [
                'status' => $status,
            ]);

            $this->train->team->user->notify(
                new ParticipationResponseNotification('train', $status, $player->id, $this->train)
            );

            return;
        }

        $this->type = 'match';

        $this->match->players()->updateExistingPivot($player->id, [
            'status' => $status,
        ]);

        $this->match->team->user->notify(
            new ParticipationResponseNotification('match', $status, $player->id, $this->match)
        );
    }
};
?>

<div class="min-h-[70vh] flex items-center justify-center px-4 py-24">
    <div class="w-full max-w-lg rounded-3xl border border-violet-500/20 bg-[#1F2243] p-8 text-center shadow-2xl">

        @if($status === 'present')
            <div class="text-5xl mb-4">✅</div>
            <h1 class="text-2xl font-bold text-white mb-2">C'est noté, vous êtes présent(e) !</h1>
        @else
            <div class="text-5xl mb-4">❌</div>
            <h1 class="text-2xl font-bold text-white mb-2">C'est noté, vous êtes absent(e).</h1>
        @endif

        <p class="text-violet-300 mb-6">
            @if($type === 'train')
                Entraînement du {{ \Carbon\Carbon::parse($train->date_train)->locale('fr')->translatedFormat('d F Y') }}
                de {{ $train->hours_start }} à {{ $train->hours_end }} — {{ $train->address }}
            @else
                Match du {{ \Carbon\Carbon::parse($match->date_match)->locale('fr')->translatedFormat('d F Y') }}
                à {{ $match->hours }} — {{ $match->address }}
            @endif
        </p>

        <a href="{{ route('login') }}" class="btn-primary inline-block">
            Retour à l'application
        </a>
    </div>
</div>
