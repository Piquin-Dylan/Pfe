<x-layout>
    <livewire:client.convocation-response
        :match="$match ?? null"
        :train="$train ?? null"
        :player="$player"
        :status="$status"
    />
</x-layout>
