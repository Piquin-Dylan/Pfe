<?php

use Livewire\Component;

public
$game

new class extends Component {
    public function mount()
    {
        $this->game = Auth::user()->team->games()->get()
    }
};
?>

<div>
    @foreach($game as $info)
        <span>{{$info->id}}</span>
    @endforeach
</div>
