<?php

use App\Models\User;
use App\Notifications\MessageGeneralNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component {

    #[Validate('required|min:3')]
    public string $message = '';

    public $notifications;

    public function mount(): void
    {
        $this->notifications = Auth::user()->notifications;
    }

    public function save(): void
    {
        $this->validate();

        $players = Auth::user()
            ->team
            ->players;

        $users = User::whereIn(
            'id',
            $players->pluck('user_id')
        )->get();

        Notification::send(
            $users,
            new MessageGeneralNotification($this->message)
        );

        $this->reset('message');

        $this->dispatch('message-sent');
    }
};
?>

<div
    x-data="{
        openModal: false,
        toast: false
    }"

    x-on:message-sent.window="
        openModal = false;

        toast = true;

        setTimeout(() => {
            toast = false
        }, 3000)
    "

    class="flex justify-center"
>
    @unless(Auth::user()->player)
    <button
        @click="openModal = true"
        class="btn-primary">
        Message général
    </button>
    @endunless

    <template x-if="openModal">
        <div
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
        >

            <div
                @click="openModal = false"
                class="absolute inset-0 bg-black/70 backdrop-blur-sm"
            ></div>

            <div
                @click.stop
                class="relative z-10 w-full max-w-[95vw] sm:max-w-xl lg:max-w-2xl rounded-3xl border border-violet-500/20 bg-[#1F2243] p-5 sm:p-7 lg:p-8 shadow-2xl"
            >

                <button
                    type="button"
                    @click="openModal = false"
                    class="absolute top-4 right-4 text-white/70 hover:text-white text-3xl leading-none transition"
                >
                    &times;
                </button>

                <div class="pr-10">
                    <h2 class="text-white text-2xl sm:text-3xl font-bold">
                        Message général
                    </h2>

                    <p class="text-violet-300 mt-2 text-sm sm:text-base">
                        Envoyer un message à toute votre équipe
                    </p>
                </div>

                <form
                    wire:submit.prevent="save"
                    class="space-y-6 mt-8"
                >

                    <div>

                        <label
                            for="message"
                            class="block text-white font-medium mb-3"
                        >
                            Contenu du message
                        </label>

                        <textarea
                            wire:model="message"
                            id="message"
                            rows="6"
                            placeholder="Entrez votre message..."
                            class="w-full rounded-2xl border border-violet-500/20 bg-[#25284B] px-4 sm:px-5 py-4 text-white placeholder:text-gray-400 outline-none resize-none focus:border-violet-500 text-sm sm:text-base"
                        ></textarea>

                        <div class="pt-2">
                            @error('message')
                            <span class="text-red-400 text-sm">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                    </div>

                    <div class="flex flex-col-reverse sm:flex-row justify-end gap-3">

                        <button
                            type="button"
                            @click="openModal = false"
                            class="btn-secondary w-full sm:w-auto"
                        >
                            Annuler
                        </button>

                        <button
                            type="submit"
                            class="btn-primary w-full sm:w-auto"
                        >
                            Envoyer
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </template>

    <div
        x-show="toast"
        x-transition
        class="fixed bottom-5 right-5 z-[9999] rounded-2xl border border-green-500/30 bg-[#1F2243] px-5 py-4 shadow-2xl"
    >
        <p class="text-white font-medium">
            ✅ Message envoyé avec succès
        </p>
    </div>

</div>
