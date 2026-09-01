<x-layout_form title="Match du {{ \Carbon\Carbon::parse($match->date_match)->locale('fr')->translatedFormat('d F Y') }}">
        <livewire:admin.show_match :match="$match"></livewire:admin.show_match>
</x-layout_form>
