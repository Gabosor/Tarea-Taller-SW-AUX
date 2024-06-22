<?php

namespace App\Livewire;

use App\Models\Movie;
use Livewire\Component;

class MostrarPeliculas extends Component
{
    public function render()
    {
        $peliculas = Movie::all();
        return view('livewire.mostrar-peliculas', [
            'peliculas' => $peliculas
        ]);
    }
}
