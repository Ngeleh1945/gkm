<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\produkModel;
use Livewire\WithPagination;

class Produk extends Component
{
    use WithPagination;

    public $search = '';
    public $pages = 10;

    protected $updatesQueryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        $produk = produkModel::where('deskripsi', 'like', '%' . $this->search . '%')->orWhere('kd_produk', 'like', '%' . $this->search . '%')
            ->orderBy('kd_produk', 'asc')->paginate($this->pages);
        return view('livewire.produk', ['produk' => $produk]);
    }
}
