{{--
@props([
    'name',
    'alt',
    'src',

])
<div class="flex flex-row g-5 items-center">
<span class="order-1 text-white text-[20px]">{{$name}}</span>
<img src="{{$src}}" alt="{{$alt}}">
</div>
--}}

<div x-data="{ currentTab : 'first' }">

    <div class="flex gap-5 justify-center pt-6 pb-16">
    <button class="btn-primary" @click="currentTab = 'first'">Joueur</button>
    <button class="btn-secondary" @click="currentTab = 'second' ">Coach</button>
    </div>
    <div x-show=" currentTab === 'first' " class="flex flex-col gap-20 lg:flex-row ">

        <div class="flex flex-row items-center gap-5 lg:flex-col">
            <span class="order-1 text-white text-[20px]">Statistiques personneles du joueur</span>
            <img width="120px" src="{{asset('stats.svg')}}" alt="">
        </div>
        <div class="flex flex-row items-center gap-5 lg:flex-col">
            <span class="order-1 text-white text-[20px]">Convocation directement sur l’application</span>
            <img width="120px"  src="{{asset('calendar.svg')}}" alt="">
        </div>

        <div class="flex flex-row items-center gap-5 lg:flex-col">
            <span class="order-1 text-white text-[20px]">Consulter les Joueurs de l’équipe</span>
            <img class="h-30" height="120px" width="120px" src="{{asset('person.svg')}}" alt="">
        </div>
        <div class="flex flex-row items-center gap-5 lg:flex-col">
            <span class="order-1 text-white text-[20px]">Consulter les matchs / entrainements</span>
            <img width="120px" src="{{asset('ball.svg')}}" alt="">
        </div>
    </div>

    <div x-show=" currentTab === 'second' " class="flex flex-col g-5 items-center">
        <div class="flex flex-row items-center">
            <span class="order-1 text-white text-[20px]">coach 1</span>
            <img src="{{asset('stats.svg')}}" alt="">
        </div>
        <div class="flex flex-row">
            <span class="order-1 text-white text-[20px]">coach 2</span>
            <img src="{{asset('stats.svg')}}" alt="">
        </div>
    </div>
</div>
