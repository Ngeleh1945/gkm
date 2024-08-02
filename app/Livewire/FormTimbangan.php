<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use DateTime;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\QueryException;
use App\Models\form_timbangan;
use App\Models\produkModel;

class FormTimbangan extends Component
{

    public $barcode;
    public $kd_material;
    public $flavour;
    public $po;
    public $tanggal;
    public $batch;
    public $nik;
    public $name;
    public $mesin;
    public $weight;
    public $dibuat;

    protected $listeners = ['weightUpdated' => 'updateWeight', 'fetchWeightData'];

    protected $rules = [
        'barcode' => 'required',
        'kd_material' => 'required',
        'flavour' => 'required',
        'po' => 'required|integer',
        'tanggal' => 'required|date_format:d-m-Y',
        'batch' => 'required',
        'nik' => 'required',
        'name' => 'required',
        'weight' => 'required',
        'dibuat' => 'required|numeric',
        'barcode' => 'required',
    ];

    public function mount()
    {
        $this->dibuat = Auth::user()->nik;
    }

    public function lastUpdate()
    {
        $lastUpdate = DB::table('form_timbangan')
            ->orderBy('updated_at', 'desc')
            ->take(3)
            ->get();

        return $lastUpdate;
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
                $this->name = $jadwal->nama;
            } else {
                $this->nik = 0;
                $this->name = 'Data tidak ditemukan';
            }
        } catch (\Exception $e) {
            Log::error("Error: " . $e->getMessage());
            $this->nik = 'Error: Tabel tidak ditemukan';
        }
        Log::info($this->tanggal);
    }

    public function fetchWeightData()
    {
        try {
            $response = Http::get('http://10.126.25.119:5000/get-weight');
            $data = $response->json();

            if (isset($data['weight'])) {
                $this->weight = $data['weight'];
            } else {
                $this->weight = null;
            }
        } catch (\Exception $e) {
            Log::error("Error fetching weight data: " . $e->getMessage());
            $this->weight = null;
        }
    }

    public function startPolling()
    {
        $this->emit('fetchWeightData');
    }

    public function submit()
    {
        $this->validate();

        $currentDateTime = Carbon::now();
        $dateNow = $currentDateTime->format('d-m-Y');
        try {
            // Check if the record already exists
            $existingRecord = DB::table('form_timbangan')
                ->where('barcode', $this->barcode)
                ->where('batch', $this->batch)
                ->exists();

            if ($existingRecord) {
                throw ValidationException::withMessages([
                    'barcode' => ['Barcode sudah ada dalam database.'],
                ]);
            }

            // Calculate the next ID based on kd_material and tanggal
            $lastId = DB::table('form_timbangan')
                ->where('kd_material', $this->kd_material)
                ->where('tanggal', $this->convertDate($this->tanggal))
                ->max(DB::raw("CAST(SUBSTRING(id_form, CHARINDEX('-', id_form) + 1, LEN(id_form)) AS INT)"));

            // Logging untuk melihat nilai lastId
            Log::info('Last ID: ' . $lastId);

            $nextId = $lastId ? $lastId + 1 : 1;
            $id_form = $this->kd_material . $this->batch . '-' . sprintf('%03d', $nextId);

            Log::info('ID Form: ' . $id_form);

            DB::beginTransaction();

            DB::table('form_timbangan')->insert([
                'id_form' => $id_form,
                'kd_material' => $this->kd_material,
                'po' => $this->po,
                'tanggal' => $this->convertDate($this->tanggal),
                'batch' => $this->batch,
                'nik' => $this->nik,
                'weight' => $this->weight,
                'dibuat' => $this->dibuat,
                'barcode' => $this->barcode,
                'created_at' => $currentDateTime,
                'updated_at' => $currentDateTime,
            ]);

            // Call the Flask server to print the barcode
            Log::info('Sending POST request to Flask endpoint...');
            $response = Http::post('http://10.126.25.119:5000/print-barcode', [
                'id_form' => $id_form,
                'kd_material' => $this->kd_material,
                'batch' => $this->batch,
                'flavour' => $this->flavour,
                'tanggal' => $this->tanggal,
                'dateNow' => $dateNow,
                'weight' => $this->weight,
            ]);

            Log::info('Response from Flask endpoint:', ['response' => $response->body()]);

            // Commit the transaction
            DB::commit();
            flash()->success('Weighing Form saved successfully and barcode printed!');
            return Redirect::back();
        } catch (ValidationException $e) {
            DB::rollback();

            $errorMessage = $e->errors()['barcode'][0];
            Log::error("Validation Error: " . $errorMessage);

            flash()->error('Failed to save data: ' . $errorMessage);
            return Redirect::back()->withInput();
        } catch (\Exception $e) {
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error("Error saving data: " . $errorMessage);

            flash()->error('Failed to save data: ' . $errorMessage);
            return Redirect::back()->withInput();
        }
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
        return view('livewire.form-timbangan', [
            'lastUpdates' => $this->lastUpdate(),
        ]);
    }
}
