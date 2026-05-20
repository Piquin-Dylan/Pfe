<div class="lg:flex lg:gap-8 lg:justify-center lg:pb-8">
    <div class="flex flex-row justify-center items-center gap-5 lg:gap-12 pt-6 sm:flex-row">
           <span
               class="filter_position {{ $this->filters === 'tout' ? 'active' : '' }}"
               wire:click="filter('tout')">Tout</span>
        <span
            class="filter_position {{ $this->filters === 'attaquant' ? 'active' : '' }}"
            wire:click="filter('attaquant')">Attaquant</span>
        <span
            class="filter_position {{ $this->filters === 'milieux' ? 'active' : '' }}"
            wire:click="filter('milieux')">Milieux</span>
    </div>
    <div class="flex flex-row justify-center items-center pt-6 pb-6 gap-5 lg:pb-0 lg:gap-12">
<span
    class="filter_position {{ $this->filters === 'defenseur' ? 'active' : '' }}"
    wire:click="filter('defenseur')">Défenseur</span>
        <span
            class="filter_position {{ $this->filters === 'gardien' ? 'active' : '' }}"
            wire:click="filter('gardien')">Gardien</span>
    </div>
</div>
