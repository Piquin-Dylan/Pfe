<div class="flex gap-10 justify-center pt-6 pb-16">

    <button
        @click="currentTab = 'first'"
        :class="currentTab === 'first'
                ? 'text-white border-b-2 border-violet-500'
                : 'text-white/70 border-b-2 border-transparent hover:text-white'"
        class="pb-2 font-semibold transition-all duration-300 text-2xl cursor-pointer"
    >
        Joueur
    </button>

    <button
        @click="currentTab = 'second'"
        :class="currentTab === 'second'
                ? 'text-white border-b-2 border-violet-500'
                : 'text-white/70 border-b-2 border-transparent hover:text-white'"
        class="pb-2 font-semibold transition-all duration-300 text-2xl cursor-pointer">
        Entraîneur
    </button>

</div>
