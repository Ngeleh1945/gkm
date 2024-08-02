<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ViewReportBS extends Component
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
        $datasGK = DB::table('form_timbangan')
            ->select(
                'form_timbangan.*',
                'produk.kd_produk as kd_produk',
                'karyawan.nama as operator',
                DB::raw('CONVERT(date, form_timbangan.updated_at) as updated')
            )
            ->where(function ($query) {
                $query->where('form_timbangan.tanggal', 'like', '%' . $this->search . '%')
                    ->orWhere('form_timbangan.nik', 'like', '%' . $this->search . '%')
                    ->orWhere('form_timbangan.batch', 'like', '%' . $this->search . '%')
                    ->orWhere('form_timbangan.po', 'like', '%' . $this->search . '%')
                    ->orWhere('karyawan.nama', 'like', '%' . $this->search . '%');
            })
            ->leftJoin(DB::connection('sqlsrv2')->getDatabaseName() . '.dbo.produk', 'form_timbangan.kd_material', '=', 'produk.kd_material')
            ->leftJoin(DB::connection('sqlsrv2')->getDatabaseName() . '.dbo.karyawan', 'form_timbangan.nik', '=', 'karyawan.nik')
            ->orderBy('form_timbangan.updated_at', 'asc')
            ->orderBy('produk.kd_produk', 'asc')
            ->paginate($this->pages);

        $year = DB::connection('sqlsrv2')->table('Calendar')->select('Tahun')->groupBy('Tahun')->get();
        $calendar1 = DB::connection('sqlsrv2')->table('Calendar')->get();
        $calendar2 = DB::connection('sqlsrv2')->table('Calendar')->get();
        return view('livewire.view-report-b-s', ['datasGK' => $datasGK, 'calendar1' => $calendar1, 'calendar2' => $calendar2, 'year' => $year]);
    }
}
