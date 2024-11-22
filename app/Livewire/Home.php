<?php

namespace App\Livewire;

use App\Models\App;
use Livewire\Component;

class Home extends Component
{
    public $app;
    public function mount(){
        $this->app = App::first();
    }
    public function render()
    {
        return view('livewire.home');
    }
}
