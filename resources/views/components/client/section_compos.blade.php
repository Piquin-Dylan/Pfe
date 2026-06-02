<section class=" lg:mr-8 lg-ml-8  lg:py-20 lg:px-8">
    <h2 class="title_section pl-4 pr-4 mb-12">Présentation fonctionnalité création de compos</h2>
<div

    class="grid grid-cols-1 xl:grid-cols-[1fr_400px] gap-6 "
    x-data="{
        selectedPlayer: null,

        players: [
            { id: 1, name: 'Lucas', position: 'AG' },
            { id: 2, name: 'Nathan', position: 'AG' },
            { id: 3, name: 'Mathis', position: 'DC' },
            { id: 4, name: 'Enzo', position: 'DC' },
            { id: 5, name: 'Theo', position: 'DD' },
            { id: 6, name: 'Noah', position: 'DG' },
            { id: 7, name: 'Liam', position: 'MDC' },
            { id: 8, name: 'Ethan', position: 'MDC' },
            { id: 9, name: 'Jules', position: 'MC' },
            { id: 10, name: 'Tom', position: 'MC' },
            { id: 11, name: 'Adam', position: 'MOC' },
            { id: 12, name: 'Sacha', position: 'AD' },
            { id: 13, name: 'Aaron', position: 'AD' },
            { id: 14, name: 'Yanis', position: 'BU' },
            { id: 15, name: 'Leo', position: 'BU' },
            { id: 16, name: 'Hugo', position: 'GB' },
        ],

        assignedPlayers: {},

        formations: {
            '4-3-3': [
                { poste: 'GB', x: 50, y: 90 },

                { poste: 'DG', x: 15, y: 72 },
                { poste: 'DC', x: 38, y: 74 },
                { poste: 'DC2', x: 62, y: 74 },
                { poste: 'DD', x: 85, y: 72 },

                { poste: 'MC', x: 25, y: 52 },
                { poste: 'MDC', x: 50, y: 58 },
                { poste: 'MOC', x: 75, y: 52 },

                { poste: 'AG', x: 18, y: 22 },
                { poste: 'BU', x: 50, y: 16 },
                { poste: 'AD', x: 82, y: 22 },
            ],

            '4-4-2': [
                { poste: 'GB', x: 50, y: 90 },

                { poste: 'DG', x: 15, y: 72 },
                { poste: 'DC', x: 38, y: 74 },
                { poste: 'DC2', x: 62, y: 74 },
                { poste: 'DD', x: 85, y: 72 },

                { poste: 'MG', x: 18, y: 48 },
                { poste: 'MC', x: 40, y: 55 },
                { poste: 'MC2', x: 60, y: 55 },
                { poste: 'MD', x: 82, y: 48 },

                { poste: 'BU', x: 38, y: 22 },
                { poste: 'BU2', x: 62, y: 22 },
            ]
        },

        currentFormation: '4-3-3'
    }"
>
    <div class="rounded-3xl p-6">

        <div class="flex justify-center mb-6">

            <select
                x-model="currentFormation"
                class="w-fit min-w-[220px] rounded-2xl bg-[#25284B]
                       border border-purple-500/20 px-4 py-3 text-center
                       text-white outline-none transition"
            >
                <option value="4-3-3">4-3-3</option>
                <option value="4-4-2">4-4-2</option>
            </select>

        </div>

        <div
            class="relative w-full h-[700px] rounded-3xl overflow-hidden
                   border border-purple-500/20"
            style="
                background-image: url('{{ asset('terrain.jpg') }}');
                background-size: cover;
                background-position: center;
            "
        >

            <template
                x-for="player in formations[currentFormation]"
                :key="player.poste"
            >

                <div
                    @click="selectedPlayer = player.poste"
                    class="absolute -translate-x-1/2 -translate-y-1/2 cursor-pointer"
                    :style="`left:${player.x}%; top:${player.y}%`"
                >

                    <div
                        class="flex flex-col items-center gap-2"
                    >

                        <div
                            class="w-16 h-16 rounded-full bg-[#1F2243]
                                   flex items-center justify-center
                                   text-white font-bold text-sm shadow-xl">
                        </div>

                        <div
                            class="
                                   px-3 py-1 rounded-xl text-white text-sm font-semibold
                                   min-w-[80px] text-center"
                            x-text="assignedPlayers[player.poste] || player.poste"
                        ></div>

                    </div>

                </div>

            </template>

        </div>

    </div>

    <div
        class="hidden xl:flex rounded-3xl border border-purple-500/20
               bg-[#1A1C38] p-5 h-[820px] flex-col"
    >

        <div class="mb-6">

            <span class="text-white text-2xl font-bold">
                Joueurs
            </span>

            <p
                class="text-sm text-purple-400 mt-1"
                x-show="selectedPlayer"
                x-text="'Poste sélectionné : ' + selectedPlayer"
            ></p>

        </div>

        <div class="flex-1 overflow-y-auto space-y-4 pr-2">

            <template
                x-for="player in players"
                :key="player.id"
            >

                <div
                    @click="assignedPlayers[selectedPlayer] = player.name"
                    class="flex items-center justify-between rounded-2xl
                           border border-purple-500/20 bg-[#25284B]
                           p-4 cursor-pointer transition hover:bg-[#2D315D]"
                >

                    <div class="flex items-center gap-4">

                        <div
                            class="w-12 h-12 rounded-full overflow-hidden
                                   border border-purple-500/30"
                        >
                            <img
                                src="{{ asset('person.png') }}"
                                class="w-full h-full object-cover"
                                alt=""
                            >
                        </div>

                        <div>

                            <p class="text-white font-semibold">
                                <span x-text="player.name"></span>
                            </p>

                            <p
                                class="text-xs text-gray-400 uppercase"
                                x-text="player.position"
                            ></p>

                        </div>

                    </div>

                    <div
                        class="h-4 w-4 rounded-full bg-green-400"
                    ></div>

                </div>

            </template>

        </div>

    </div>

    <div
        x-show="selectedPlayer"
        x-transition
        class="fixed inset-0 z-50 flex xl:hidden items-center justify-center bg-black/50 p-4"
        style="display:none;"
    >

        <div
            @click.away="selectedPlayer = null"
            class="relative w-full max-w-md rounded-3xl
                   border border-purple-500/30 bg-[#1F2243]
                   shadow-2xl overflow-hidden"
        >

            <div class="flex items-center justify-between p-6 pb-4">

                <div>

                    <h2 class="text-white text-2xl font-bold">
                        Choisir un joueur
                    </h2>

                    <p class="text-sm text-gray-400 mt-1">
                        Poste :
                        <span
                            class="text-purple-400 font-semibold"
                            x-text="selectedPlayer"
                        ></span>
                    </p>

                </div>

                <button
                    @click="selectedPlayer = null"
                    class="text-white text-xl hover:opacity-70"
                >
                    ✕
                </button>

            </div>

            <div class="px-6 pb-6 overflow-y-auto max-h-[500px] space-y-3">

                <template
                    x-for="player in players"
                    :key="player.id"
                >

                    <div
                        @click="
                            assignedPlayers[selectedPlayer] = player.name;
                            selectedPlayer = null;
                        "
                        class="flex items-center justify-between rounded-2xl
                               border border-purple-500/20 bg-[#25284B]
                               p-4 cursor-pointer hover:bg-[#2D315D] transition"
                    >

                        <div class="flex items-center gap-4">

                            <div
                                class="w-12 h-12 rounded-full overflow-hidden
                                       border border-purple-500/30"
                            >
                                <img
                                    src="{{ asset('person.png') }}"
                                    class="w-full h-full object-cover"
                                    alt=""
                                >
                            </div>

                            <div>

                                <p
                                    class="text-white font-semibold"
                                    x-text="player.name"
                                ></p>

                                <p
                                    class="text-xs text-gray-400 uppercase"
                                    x-text="player.position"
                                ></p>

                            </div>

                        </div>

                        <div
                            class="h-4 w-4 rounded-full bg-green-400"
                        ></div>

                    </div>

                </template>

            </div>

        </div>

    </div>

</div>
</section>
