<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'EMPLEADOS';      // Usa el nombre real exacto (mayúsculas si aplica)
    protected $primaryKey = 'ID';        // Campo clave

    public $incrementing = false;        // Importante: desactiva autoincremento al estilo MySQL
    protected $keyType = 'int';          // Indica que la clave es numérica

    public $timestamps = false;          // Si no tienes created_at y updated_at

    protected $fillable = [
        'NOMBRE',
        'SALARIO',
        'FECHA_INGRESO',
    ];
}
