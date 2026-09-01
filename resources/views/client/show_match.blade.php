<x-layout_form title="Match du {{ \Carbon\Carbon::parse($match->date_match)->locale('fr')->translatedFormat('d F Y') }}">
        <livewire:client.show_match :match="$match"></livewire:client.show_match>
</x-layout_form>
