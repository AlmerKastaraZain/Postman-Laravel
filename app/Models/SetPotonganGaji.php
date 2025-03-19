<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SetPotonganGaji extends Model
{
    protected $table = 'set_potongan_gaji';
            
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'status_kehadiran',
        'jumlah_potongan',
        'id_admin'
    ];
}
