@props([
    'gameId'
])

<div class="flex flex-col sm:flex-row justify-center items-center gap-3 sm:gap-4 mb-10">

    <a
        href="{{ url('match/' . $gameId) }}"
        class="btn-primary">

        Convocation

    </a>

    <button
        @click="openScoreModal = true"
        class="btn-secondary">

        Score du match

    </button>

</div>
