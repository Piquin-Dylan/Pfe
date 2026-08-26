@props(['rate'])

<span
    class="inline-flex w-fit items-center gap-1 rounded-full px-2 py-0.5 text-[10px] font-semibold
        {{ $rate >= 75 ? 'bg-green-500/15 text-green-400' : ($rate >= 50 ? 'bg-yellow-500/15 text-yellow-400' : 'bg-red-500/15 text-red-400') }}"
    title="Présence aux entraînements"
>
    {{ $rate }}% présence
</span>
