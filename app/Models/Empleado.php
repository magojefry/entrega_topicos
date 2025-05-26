<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'EMPLEADO';

    protected $primaryKey = 'ID_EMPLEADO';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'NOMBRE',
        'UBICACION',
        'TELEFONO',
        'ID_LOTE',
    ];
}
