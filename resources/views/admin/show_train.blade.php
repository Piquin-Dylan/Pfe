<x-layout_form title="Entraînement du {{ \Carbon\Carbon::parse($train->date_train)->locale('fr')->translatedFormat('d F Y') }}">
        <livewire:admin.show_train :train="$train"></livewire:admin.show_train>
</x-layout_form>
