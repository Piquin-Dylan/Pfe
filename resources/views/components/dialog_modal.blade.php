@props([
    'link'
])
<div
    id="dialog"
    x-data="{
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

            this.$refs.dialogRef.showModal();
        },

        close() {
            this.$refs.dialogRef.close();
        }
    }"
>
    <dialog
        x-ref="dialogRef"
        class="backdrop:bg-black/60 bg-transparent border-0 p-0
               fixed inset-0 m-auto
               w-[95vw] max-w-4xl overflow-visible"
    >
        <div class="relative bg-[#11182D] text-white rounded-3xl border border-white/10 shadow-2xl p-8 md:p-12">

            <button
                @click="close()"
                class="absolute top-6 right-6 text-white/60 hover:text-white text-3xl leading-none">
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
                            Heure : <span x-text="selectedEvent.hours"></span>
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
                    <a
                        :href="
        selectedEvent.title === '⚽ Match'
            ? `/match/${selectedEvent.id}`
            : `/train/${selectedEvent.id}`
    "
                        class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-indigo-500 hover:bg-indigo-600 text-white font-medium transition"
                    >
                        Voir
                    </a>
                </div>

                {{--  <div class="flex items-center justify-center">
                      <div
                          class="w-full h-64 rounded-2xl border border-indigo-500/30
                                 bg-[#1B2340] flex items-center justify-center
                                 text-gray-400 text-lg">
                          Aperçu du dashboard
                      </div>
                  </div>--}}

            </div>
        </div>
    </dialog>
</div>
