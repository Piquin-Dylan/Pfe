<?php

use Livewire\Component;

new class extends Component {

    public \Illuminate\Support\Collection $notifications;

    public function mount(): void
    {
        $user = Auth::user();

        $this->notifications = $user->notifications;

    }
};
?>

<div>
    @foreach($notifications as $notification)
        <div class="flex justify-center">{{ $notification->data['date_match'] ?? ""}}</div>
    @endforeach
</div>
