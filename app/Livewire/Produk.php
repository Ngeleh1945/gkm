<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\produkModel;

class Produk extends Component
{
    public function render()
    {
        $produk = produkModel::all();
        return view('livewire.produk', compact('produk'));
    }
}
