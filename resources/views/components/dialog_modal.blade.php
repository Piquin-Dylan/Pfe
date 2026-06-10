@props([
    'link'
])

<div
    id="dialog"

    x-data="{
        open: false,

        selectedEvent: {
            title: '',
            address: '',
            hours: '',
            start: '',
            type: '',
            hours_start: '',
            hours_end: '',
            id: '',
        },

        openEvent(event) {

            this.selectedEvent = {
                title: event.title,
                address: event.extendedProps.address ?? '',
                hours: event.extendedProps.hours ?? '',
                start: event.start ?? '',
                type: event.extendedProps.type ?? '',
                hours_start: event.extendedProps.hours_start ?? '',
                hours_end: event.extendedProps.hours_end ?? '',
                id: event.id ?? '',
            };

            this.open = true;
        },

        close() {
            this.open = false;
        }
    }"

    x-on:event-deleted.window="
    window.calendar.refetchEvents();
    close();
"
>

    <template x-if="open">

        <div
            class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
        >

            <div
                @click="close()"
                class="absolute inset-0 bg-black/60 backdrop-blur-sm"
            ></div>

            <div
                @click.stop
                class="relative w-full max-w-4xl rounded-3xl border border-white/10 bg-[#11182D] p-8 md:p-12 text-white shadow-2xl"
            >

                <button
                    @click="close()"
                    class="absolute top-6 right-6 text-white/60 hover:text-white text-3xl leading-none"
                >
                    &times;
                </button>

                <div class="grid md:grid-cols-2 gap-10 items-start">

                    <div>

                        <h2
                            class="text-4xl font-bold mb-4"
                            x-text="selectedEvent.title"
                        ></h2>

                        <ul class="space-y-3 text-gray-300 text-lg">

                            <li x-show="selectedEvent.hours">
                                Heure :
                                <span x-text="selectedEvent.hours"></span>
                            </li>

                            <li
                                class="text-gray-300 text-xl leading-relaxed mb-8"
                                x-text="selectedEvent.address"
                            ></li>

                            <li
                                x-show="selectedEvent.hours_start || selectedEvent.hours_end"
                            >
                                Horaire :
                                <span x-text="selectedEvent.hours_start"></span>
                                -
                                <span x-text="selectedEvent.hours_end"></span>
                            </li>

                            <li x-show="selectedEvent.type">
                                ✓ Type :
                                <span x-text="selectedEvent.type"></span>
                            </li>

                        </ul>

                        @unless(Auth::user()->player)

                            <div class="flex flex-wrap gap-3 mt-8">

                                <a
                                    :href="selectedEvent.title === '⚽ Match'
                                        ? `/match/${selectedEvent.id}`
                                        : `/train/${selectedEvent.id}`"
                                    class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-indigo-500 hover:bg-indigo-600 text-white font-medium transition"
                                >
                                    Voir
                                </a>

                                <button
                                    @click="
        console.log('delete');
        console.log(selectedEvent.id);
        console.log(selectedEvent.type);

        Livewire.dispatch('delete-event', {
            id: selectedEvent.id,
            type: selectedEvent.type
        });
    "
                                    class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-red-500"
                                >
                                    Supprimer l'événement
                                </button>

                            </div>

                        @endunless

                    </div>

                </div>

            </div>

        </div>

    </template>

</div>
