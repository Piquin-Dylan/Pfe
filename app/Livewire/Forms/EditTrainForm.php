<?php

namespace App\Livewire\Forms;

use App\Models\Train;
use Livewire\Attributes\Validate;
use Livewire\Form;

class EditTrainForm extends Form
{
    public ?Train $train = null;

    #[Validate('required', message: 'Le champs date est requis')]
    public string $date = "";

    #[Validate('required', message: 'Le champs lieux  est requis')]
    public string $places = "";

    #[Validate('required', message: 'Le champs heure de début est requis')]
    public string $hours_start = "";

    #[Validate('required', message: 'Le champs heure de fin  est requis')]
    public string $hours_end = "";

    public function mount(Train $train): void
    {
        $this->train = $train;
        $this->date = $train->date_train;
        $this->places = $train->address;
        $this->hours_start = $train->hours_start;
        $this->hours_end = $train->hours_end;
    }

    public function update(): void
    {
        $this->validate();

        $this->train->update([
            'date_train' => $this->date,
            'address' => $this->places,
            'hours_start' => $this->hours_start,
            'hours_end' => $this->hours_end,
        ]);
    }
}
