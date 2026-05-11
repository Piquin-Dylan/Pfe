<div class="flex gap-8 justify-center pt-6 pb-16">
    <button
        @click="currentTab = 'first'"
        :class="currentTab === 'first'
                ? 'text-white border-b-2 border-white'
                : 'text-white/70 border-b-2 border-transparent hover:text-white'"
        class="pb-2 font-semibold transition-all duration-200">
        Convocation
    </button>

    <button
        @click="currentTab = 'second'"
        :class="currentTab === 'second'
                ? 'text-white border-b-2 border-white'
                : 'text-white/70 border-b-2 border-transparent hover:text-white'"
        class="pb-2 font-semibold transition-all duration-200">
        Feuille de match
    </button>

    <button
        @click="currentTab = 'third'"
        :class="currentTab === 'third'
                ? 'text-white border-b-2 border-white'
                : 'text-white/70 border-b-2 border-transparent hover:text-white'"
        class="pb-2 font-semibold transition-all duration-200">
        Composition
    </button>
</div>
