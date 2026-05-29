<div class="flex flex-wrap justify-center gap-3 sm:gap-4 md:gap-5 lg:gap-8 pt-6 pb-6">

    <span
        class="filter_position text-sm md:text-base {{ $this->filters === 'tout' ? 'active' : '' }}"
        wire:click="filter('tout')">
        Tout
    </span>

    <span
        class="filter_position text-sm md:text-base {{ $this->filters === 'attaquant' ? 'active' : '' }}"
        wire:click="filter('attaquant')">
        Attaquant
    </span>

    <span
        class="filter_position text-sm md:text-base {{ $this->filters === 'milieux' ? 'active' : '' }}"
        wire:click="filter('milieux')">
        Milieux
    </span>

    <span
        class="filter_position text-sm md:text-base {{ $this->filters === 'defenseur' ? 'active' : '' }}"
        wire:click="filter('defenseur')">
        Défenseur
    </span>

    <span
        class="filter_position text-sm md:text-base {{ $this->filters === 'gardien' ? 'active' : '' }}"
        wire:click="filter('gardien')">
        Gardien
    </span>

</div>
