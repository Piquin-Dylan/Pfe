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
    <h2 class=" mt-4 mb-4  title_section  lg:mt-12 lg:mb-4">Messages</h2>
    <section class="ml-6 mr-6  lg:items-center lg:flex-col ">

        @foreach($notifications as $notification)
            <a href="#">
            <div
                class="flex items-center mt-6 mb-6 flex-col min-w-full  justify-between bg-gradient-to-r from-[#1E293B] to-[#0F172A] border border-white rounded-2xl p-5 w-full max-w-3xl shadow-lg">
                <span class="text-white lg:text-2xl"> {{ $notification->data['message'] ?? "" }} </span>
                <div class="mt-4 flex gap-6">
                <x-button>Présent</x-button>
                <x-button>Absent</x-button>
                </div>
            </div>
            </a>
        @endforeach
    </section>
</div>

