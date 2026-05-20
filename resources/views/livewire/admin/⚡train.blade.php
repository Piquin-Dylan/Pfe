<?php

use App\Models\Player;
use App\Models\Team;
use App\Models\Train;
use Livewire\Component;

new class extends Component {
    public \Illuminate\Support\Collection $trains;

    public function mount(): void
    {

        $current_user = Auth::user()->id;


        if (Auth::user()->player) {
            $player = Player::where('user_id', $current_user)->select('team_id')->value('team_id');
            $this->trains = Train::where('team_id', $player)->orderby('date_train', 'asc')->get();
        } else {
            $team = Team::where('user_id', $current_user)->select('id')->value('id');
            $this->trains = Train::where('team_id', $team)->orderby('date_train', 'asc')->get();
        }
    }
};
?>

<div>
    @if($trains->isEmpty())
        <div class="max-w-2xl mx-auto mt-10 p-8 rounded-3xl bg-white/5 border border-white/10 text-center">
            <h3 class="text-2xl font-bold text-white mb-4">
                Aucun entrainement n'a encore été créer pour le moment
            </h3>

            <p class="text-gray-300 mb-6">
                créer dés maintenant votre premier entrainement dans la page calendrier
            </p>

            <a href="/calendrier" class="btn-primary">Créer mon premier entrainement</a>
        </div>
    @else
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 px-6">

            @foreach($trains as $train)
                <div
                    class="bg-gradient-to-br from-[#0f172a] to-[#020617] border border-white/10 rounded-2xl p-6 flex items-center gap-6 text-white transition hover:translate-y-[-3px] hover:border-white/20">

                    <div
                        class="flex flex-col items-center justify-center bg-white/10 rounded-2xl px-5 py-4 min-w-[90px]">
                <span class="text-2xl font-semibold">
                    {{ \Carbon\Carbon::parse($train->date_train)->format('d') }}
                </span>
                        <span class="text-sm text-gray-300 uppercase tracking-wide">
                    {{ \Carbon\Carbon::parse($train->date_train)->locale('fr')->translatedFormat('F') }}
                </span>
                    </div>

                    <div class="flex flex-col gap-3 flex-1">
                <span class="text-xl font-semibold tracking-wide">
                    Entrainement collectif
                </span>

                        <div class="flex flex-wrap items-center gap-3 text-gray-300 text-sm">
                    <span>
                        {{\Carbon\Carbon::parse($train->hours_start)->format('H\hi')}} - {{\Carbon\Carbon::parse($train->hours_end)->format('H\hi')}}
                    </span>
                            <span class="text-gray-500">•</span>
                            <span class="truncate">
                        {{$train->address}}
                    </span>
                        </div>

                        <div>
                            <a href="train/{{{$train->id}}}"
                               class="inline-block px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 text-white text-sm font-semibold transition hover:scale-[1.03] hover:brightness-110">
                                Voir
                            </a>
                        </div>
                    </div>

                </div>
            @endforeach
        @endif
    </div>
</div>
