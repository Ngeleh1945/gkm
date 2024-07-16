<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

class FormTimbangan extends Component
{

    public $barcode;
    public $kd_material;
    public $flavour;
    public $po;
    public $tanggal;
    public $batch;
    public $nik;
    public $nama;
    public $mesin;
    public $weight;
    public $dibuat;

    protected $listeners = ['weightUpdated'];

    protected $rules = [
        'barcode' => 'required',
        'kd_material' => 'required',
        'po' => 'required',
        'tanggal' => 'required|date_format:d-m-Y',
        'batch' => 'required',
        'nik' => 'required',
        'nama' => 'required',
        'weight' => 'required|numeric',
        'dibuat' => 'required',
    ];

    public function weightUpdated($newWeight)
    {
        $this->weight = $newWeight;
    }
    public function mount()
    {
        $this->dibuat = Auth::user()->nik;
    }
    public function handleBarcodeEnter()
    {
        $this->kd_material = substr(substr($this->barcode, 0, 18), -6);
        try {
            $flavour = DB::connection('sqlsrv2')->table('produk')->where('kd_material', $this->kd_material)->first();

            if ($flavour) {
                $this->flavour = $flavour->kd_produk;
            } else {
                $this->flavour = 'Data tidak ditemukan';
            }
        } catch (\Exception $e) {
            Log::error("Error: " . $e->getMessage());
            $this->flavour = 'Error: Tabel tidak ditemukan';
        }
        $this->po = substr($this->barcode, 19, 11);
        $this->tanggal = $this->convertProductionDate(substr($this->barcode, 33, 5));
        $this->batch = substr($this->barcode, 30, 13);
        $this->mesin = (int) substr($this->batch, 8, 3);
        try {
            $jadwal = DB::connection('sqlsrv2')->table('jadwal')
                ->where('tanggal', $this->convertDate($this->tanggal))
                ->where('mesin', $this->mesin)
                ->where('shift_label', substr($this->batch, 2, 1))->first();

            if ($jadwal) {
                $this->nik = $jadwal->nik;
                $this->nama = $jadwal->nama;
            } else {
                $this->nik = 'Data tidak ditemukan';
                $this->nama = 'Data tidak ditemukan';
            }
        } catch (\Exception $e) {
            Log::error("Error: " . $e->getMessage());
            $this->nik = 'Error: Tabel tidak ditemukan';
            $this->nama = 'Error: Tabel tidak ditemukan';
        }
        Log::info($this->tanggal);
    }

    public function startPolling()
    {
        $this->emit('fetchWeight');
    }

    public function submit(Request $request)
    {
        $validatedData = $request->validate([
            'barcode' => 'required',
            'kd_material' => 'required',
            'flavour' => 'required',
            'po' => 'required',
            'tanggal' => 'required|date_format:d-m-Y',
            'batch' => 'required',
            'nik' => 'required',
            'nama' => 'required',
            'weight' => 'required',
            'dibuat' => 'required',
        ]);

        if (empty($validatedData['kd_material'])) {
            Log::error("kd_material is empty for barcode: " . $validatedData['barcode']);
            flash()->error('kd_material tidak boleh kosong.');
            return Redirect::back()->withInput();
        }
        try {
            DB::beginTransaction();

            Log::info('Mulai simpan a');
            Log::info('Lah');
            $lastId = DB::table('form_timbangan')->max('id');
            $nextIncrement = $lastId ? ((int) substr($lastId, -5)) + 1 : 1;
            $nextIncrementFormatted = str_pad($nextIncrement, 5, '0', STR_PAD_LEFT);

            $newId = $this->batch . $nextIncrementFormatted;

            DB::table('form_timbangan')->insert([
                'id' => $newId,
                'barcode' => $this->barcode,
                'kd_material' => $this->kd_material,
                'po' => $this->po,
                'tanggal' => $this->tanggal,
                'batch' => $this->batch,
                'nik' => $this->nik,
                'weight' => $this->weight,
                'dibuat' => $this->dibuat,
            ]);

            DB::commit();

            flash()->success('Data berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollback();

            Log::error("Database error: " . $e->getMessage());
            flash()->error('Gagal menyimpan data. Silakan coba lagi.');
        }

        return Redirect::back()->withInput();
    }

    private function convertProductionDate($barcodeDate)
    {
        $day = substr($barcodeDate, 0, 2);
        $monthCode = substr($barcodeDate, 2, 1);
        $year = '20' . substr($barcodeDate, 3, 2);

        $months = [
            'A' => '01', 'B' => '02', 'C' => '03', 'D' => '04',
            'E' => '05', 'F' => '06', 'G' => '07', 'H' => '08',
            'I' => '09', 'J' => '10', 'K' => '11', 'L' => '12'
        ];

        $month = $months[strtoupper($monthCode)] ?? '00';

        return "{$day}-{$month}-{$year}";
    }

    private function convertDate($selectDate)
    {
        $date = DateTime::createFromFormat('d-m-Y', $selectDate);
        return $date->format('Y-m-d');
    }

    public function render()
    {
        return view('livewire.form-timbangan');
    }
}
