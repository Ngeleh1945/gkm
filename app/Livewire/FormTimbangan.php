<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class FormTimbangan extends Component
{
    public $barcode;
    public $kd_material;
    public $flavour;
    public $po;
    public $tanggal;
    public $batch;

    public function handleBarcodeEnter()
    {

        $this->kd_material = substr(substr($this->barcode, 0, 18), -6);
        $flavour = DB::table('produk')->where('kd_material', $this->kd_material)->get();
        $this->flavour = $flavour->kd_produk;
        $this->po = substr($this->barcode, 19, 11);
        $this->tanggal = $this->convertProductionDate(substr($this->barcode, 33, 5));
        $this->batch = substr($this->barcode, 30, 13);
        Log::info($this->tanggal);
    }

    public function submit()
    {
        // Handle form submission
    }

    private function convertProductionDate($barcodeDate)
    {
        $day = substr($barcodeDate, 0, 2);
        $monthCode = substr($barcodeDate, 2, 1);
        $year = '20' . substr($barcodeDate, 3, 2);

        // Mapping dari huruf ke bulan
        $months = [
            'A' => '01', 'B' => '02', 'C' => '03', 'D' => '04',
            'E' => '05', 'F' => '06', 'G' => '07', 'H' => '08',
            'I' => '09', 'J' => '10', 'K' => '11', 'L' => '12'
        ];

        $month = $months[strtoupper($monthCode)] ?? '00'; // Default ke '00' jika tidak ditemukan

        return "{$month}/{$day}/{$year}";
    }

    public function render()
    {
        return view('livewire.form-timbangan');
    }
}
