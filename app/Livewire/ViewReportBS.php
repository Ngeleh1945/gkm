<?php

namespace App\Livewire;

use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class ViewReportBS extends Component
{
    use WithPagination;

    public $selectedYear;
    public $calendar1 = [];
    public $calendar2 = [];
    public $years;
    public $search;
    public $pages = 10;
    public $startWeek;
    public $finishWeek;
    public $selectedDate;
    public $startDate;
    public $endDate;

    protected $updatesQueryString = ['search', 'startDate', 'endDate'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedStartDate()
    {
        $this->resetPage();
    }

    public function updatedEndDate()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->years = DB::table('form_timbangan')
            ->select(DB::raw('YEAR(tanggal) as year'))
            ->distinct()
            ->orderBy('year', 'asc')
            ->get();
    }

    public function updatedSelectedYear()
    {
        $this->fetchCalendars();
    }

    public function updatedStartWeek()
    {
        $this->updateFinishCalendar();
    }

    public function updatedFinishWeek()
    {
        $this->updateStartCalendar();
    }

    public function fetchCalendars()
    {
        if ($this->selectedYear) {
            $this->calendar1 = DB::connection('sqlsrv2')->table('Calendar')
                ->where('Tahun', $this->selectedYear)
                ->get();

            $this->calendar2 = $this->calendar1;
        }
    }

    public function updateStartCalendar()
    {
        if ($this->startWeek && $this->selectedYear) {
            $this->calendar1 = DB::connection('sqlsrv2')->table('Calendar')
                ->where('Tahun', $this->selectedYear)
                ->where('Week', '<=', $this->finishWeek)
                ->get();
        }
    }

    public function updateFinishCalendar()
    {
        if ($this->finishWeek && $this->selectedYear) {
            $this->calendar2 = DB::connection('sqlsrv2')->table('Calendar')
                ->where('Tahun', $this->selectedYear)
                ->where('Week', '>=', $this->startWeek)
                ->get();
        }
    }


    function convertDateFormat($dateFormatDdMmYyyy)
    {
        $date = DateTime::createFromFormat('d-m-Y', $dateFormatDdMmYyyy);

        if (!$date) {
            return "Format tanggal tidak valid";
        }

        return $date->format('Y-m-d');
    }


    public function render()
    {
        $perPage = max((int) $this->pages, 1);

        $latestDate = DB::table('form_timbangan')
            ->select(DB::raw('MAX(created_at) as latest_date'))
            ->value('latest_date');

        // Modify the query based on the selected year, start week, finish week, startDate, and endDate
        $datasGKQuery = DB::table('form_timbangan')
            ->select(
                'form_timbangan.*',
                'produk.kd_produk as kd_produk',
                'karyawan.nama as operator',
                DB::raw('CONVERT(date, form_timbangan.created_at) as updated')
            )
            ->leftJoin(DB::connection('sqlsrv2')->getDatabaseName() . '.dbo.produk', 'form_timbangan.kd_material', '=', 'produk.kd_material')
            ->leftJoin(DB::connection('sqlsrv2')->getDatabaseName() . '.dbo.karyawan', 'form_timbangan.nik', '=', 'karyawan.nik');

        Log::info($this->startDate . ' and ' . $this->endDate);
        if ($this->startDate && $this->endDate) {
            $startDate = $this->convertDateFormat($this->startDate);
            $endDate = $this->convertDateFormat($this->endDate);
            Log::info('startDate conversi: ' . $startDate . ' endDate conversi: ' . $endDate);
            $datasGKQuery->whereBetween('form_timbangan.created_at', [$startDate, $endDate]);
            Log::info('startDate : ' . $this->startDate . ' endDate : ' . $this->endDate);
        } elseif ($this->selectedYear && $this->startWeek && $this->finishWeek) {
            $calendarStart = DB::connection('sqlsrv2')->table('Calendar')
                ->where('Tahun', $this->selectedYear)
                ->where('Week', $this->startWeek)
                ->value('Tgl_Mulai');

            $calendarEnd = DB::connection('sqlsrv2')->table('Calendar')
                ->where('Tahun', $this->selectedYear)
                ->where('Week', $this->finishWeek)
                ->value('Tgl_Selesai');

            $datasGKQuery->whereBetween('form_timbangan.created_at', [$calendarStart, $calendarEnd]);
        } else {
            $datasGKQuery->whereDate('form_timbangan.created_at', '=', $latestDate);
        }

        $datasGK = $datasGKQuery
            ->where(function ($query) {
                $query->where('form_timbangan.tanggal', 'like', '%' . $this->search . '%')
                    ->orWhere('form_timbangan.nik', 'like', '%' . $this->search . '%')
                    ->orWhere('form_timbangan.batch', 'like', '%' . $this->search . '%')
                    ->orWhere('form_timbangan.po', 'like', '%' . $this->search . '%')
                    ->orWhere('karyawan.nama', 'like', '%' . $this->search . '%');
            })
            ->orderBy('form_timbangan.created_at', 'asc')
            ->orderBy('produk.kd_produk', 'asc')
            ->paginate($perPage);

        return view('livewire.view-report-b-s', [
            'datasGK' => $datasGK,
        ]);
    }
}
