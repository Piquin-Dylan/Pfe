<?php

use App\Models\Train;
use App\Notifications\ParticipationResponseNotification;
use Livewire\Component;

new class extends Component {

    public Train $trains;

    public ?string $myStatus = null;

    public function mount($id): void
    {
        $this->trains = Train::where('uuid', $id)->firstOrFail();
        $this->authorize('view', $this->trains);

        $myPlayer = Auth::user()->player;

        $convocation = $this->trains->players->firstWhere('id', $myPlayer->id);
        $this->myStatus = $convocation?->pivot->status;
    }

    public function respondConvocation(string $status): void
    {
        if (!in_array($status, ['present', 'absent'])) {
            return;
        }

        $myPlayer = Auth::user()->player;

        $isConvoked = $this->trains->players->contains('id', $myPlayer->id);

        if (!$isConvoked) {
            return;
        }

        $this->trains->players()->updateExistingPivot($myPlayer->id, [
            'status' => $status,
        ]);

        $this->myStatus = $status;

        $this->trains->team->user->notify(
            new ParticipationResponseNotification('train', $status, $myPlayer->id, $this->trains)
        );
    }
};
?>

<div class="max-w-3xl mx-auto">

    <h3 class="title_section text-center" id="tuto">
        Entraînement du
        {{ \Carbon\Carbon::parse($trains->date_train)->locale('fr')->translatedFormat('d F') }}
    </h3>

    <p class="text-white/70 text-center mt-2">
        {{ $trains->address }} — de {{ $trains->hours_start }} à {{ $trains->hours_end }}
    </p>

    <div class="flex flex-col items-center gap-4 pt-8 pb-12">

        @if(is_null($myStatus))

            <p class="text-gray-400 text-center">
                Vous n'êtes pas convoqué pour cet entraînement.
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

</div>
