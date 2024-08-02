<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class form_timbangan extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $table = 'form_timbangan';
    protected $primaryKey = 'id_form';

    protected $fillable = [
        'id_form',
        'tanggal',
        'nik',
        'batch',
        'po',
        'kd_material',
        'weight',
        'dibuat',
        'barcode',
    ];

    public $incrementing = false;
}
