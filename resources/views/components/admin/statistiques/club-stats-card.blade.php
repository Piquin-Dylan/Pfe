@props(['wins', 'draws', 'losses', 'goalsFor', 'goalsAgainst', 'winRate', 'recentForm'])

@php
    $goalDifference = $goalsFor - $goalsAgainst;
@endphp

<div class="bg-[#1A1C38] border border-purple-500/20 rounded-3xl p-6 mb-6">

    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
        <h3 class="text-white font-semibold text-lg">
            Statistiques du club
        </h3>

        @if(!empty($recentForm))
            <div class="flex items-center gap-2">
                <span class="text-xs text-gray-400 uppercase">Forme récente</span>

                <div class="flex gap-1">
                    @foreach($recentForm as $result)
                        <span
                            @class([
                                'w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold',
                                'bg-green-500/20 text-green-400' => $result === 'V',
                                'bg-red-500/20 text-red-400' => $result === 'D',
                                'bg-gray-500/20 text-gray-300' => $result === 'N',
                            ])
                        >{{ $result }}</span>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">

        <div class="rounded-2xl bg-[#25284B] p-3 text-center">
            <p class="text-xs text-gray-400 uppercase">Victoires</p>
            <p class="text-green-400 text-xl font-bold">{{ $wins }}</p>
        </div>

        <div class="rounded-2xl bg-[#25284B] p-3 text-center">
            <p class="text-xs text-gray-400 uppercase">Nuls</p>
            <p class="text-gray-300 text-xl font-bold">{{ $draws }}</p>
        </div>

        <div class="rounded-2xl bg-[#25284B] p-3 text-center">
            <p class="text-xs text-gray-400 uppercase">Défaites</p>
            <p class="text-red-400 text-xl font-bold">{{ $losses }}</p>
        </div>

        <div class="rounded-2xl bg-[#25284B] p-3 text-center">
            <p class="text-xs text-gray-400 uppercase">Buts marqués</p>
            <p class="text-white text-xl font-bold">{{ $goalsFor }}</p>
        </div>

        <div class="rounded-2xl bg-[#25284B] p-3 text-center">
            <p class="text-xs text-gray-400 uppercase">Buts encaissés</p>
            <p class="text-white text-xl font-bold">{{ $goalsAgainst }}</p>
        </div>

        <div class="rounded-2xl bg-[#25284B] p-3 text-center">
            <p class="text-xs text-gray-400 uppercase">Diff. de buts</p>
            <p class="{{ $goalDifference >= 0 ? 'text-green-400' : 'text-red-400' }} text-xl font-bold">
                {{ $goalDifference > 0 ? '+' . $goalDifference : $goalDifference }}
            </p>
        </div>

    </div>

    <p class="text-purple-400 text-sm mt-4">
        Taux de victoire : <span class="font-semibold">{{ $winRate }}%</span>
    </p>

</div>
