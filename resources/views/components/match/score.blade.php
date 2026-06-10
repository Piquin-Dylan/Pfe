@props([
    'gameId'
])

<div class="flex flex-col sm:flex-row justify-center items-center gap-3 sm:gap-4 mb-10">

    @php
        $game = \App\Models\Game::find($gameId);
    @endphp

    <a
        href="{{ url('match/' . $gameId) }}"
        class="btn-primary">

        {{ $game->score_home !== null && $game->score_away !== null
            ? 'Voir les détails'
            : 'Convocation' }}

    </a>

    <button
        @click="openScoreModal = true"
        class="btn-secondary">
        Score du match
    </button>

</div>
