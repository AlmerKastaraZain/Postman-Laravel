<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataGajiKaryawan extends Model
{
        
    protected $table = 'data_gaji_karyawan';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id_data_karyawan',
        'id_pot_gaji',
        'total_gaji',
        'id_admin',
    ];
}
