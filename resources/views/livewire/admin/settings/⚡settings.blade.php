<?php

use Livewire\Component;

new class extends Component {

    public string $activeTab = 'profile';

    public function switchTab(string $tab): void
    {
        $this->activeTab = $tab;
    }
};
?>
<div>
    <nav class="flex gap-8">

        <button
            wire:click="switchTab('profile')"
            @class([
                'pb-3 text-lg font-semibold transition border-b-2',
                'text-white border-white' => $activeTab === 'profile',
                'text-gray-400 border-transparent hover:text-white' => $activeTab !== 'profile',
            ])
        >
            Profil
        </button>

        @if(Auth::user()->team)
            <button
                wire:click="switchTab('team')"
                @class([
                    'pb-3 text-lg font-semibold transition border-b-2',
                    'text-white border-white' => $activeTab === 'team',
                    'text-gray-400 border-transparent hover:text-white' => $activeTab !== 'team',
                ])
            >
                Équipe
            </button>
        @endif

        <button
            wire:click="switchTab('security')"
            @class([
                'pb-3 text-lg font-semibold transition border-b-2',
                'text-white border-white' => $activeTab === 'security',
                'text-gray-400 border-transparent hover:text-white' => $activeTab !== 'security',
            ])
        >
            Sécurité
        </button>

    </nav>
    <div class="pt-6">

        @if($activeTab === 'profile')
            <livewire:admin.settings.profile-settings/>
        @endif

        @if($activeTab === 'team' && Auth::user()->team)
            <livewire:admin.settings.team-settings/>
        @endif

         @if($activeTab === 'security')
             <livewire:admin.settings.reset-password />
         @endif

    </div>
</div>
