<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class EmpleadoService
{
    // Insertar empleado (sin salario, con ubicacion, telefono y id_lote)
    public function insertarEmpleado($nombre, $ubicacion, $telefono, $id_lote)
    {
        DB::statement('BEGIN pkg_empleado.insertar_empleado(:nombre, :ubicacion, :telefono, :id_lote); END;', [
            'nombre' => $nombre,
            'ubicacion' => $ubicacion,
            'telefono' => $telefono,
            'id_lote' => $id_lote,
        ]);
    }

    // Obtener empleado
    public function obtenerEmpleado($id_empleado)
    {
        $conn = DB::getPdo();

        $cursor = oci_new_cursor($conn);
        $stmt = oci_parse($conn, 'BEGIN :cursor := pkg_empleado.obtener_empleado(:id_empleado); END;');
        oci_bind_by_name($stmt, ':id_empleado', $id_empleado);
        oci_bind_by_name($stmt, ':cursor', $cursor, -1, OCI_B_CURSOR);

        oci_execute($stmt);
        oci_execute($cursor);

        $data = [];
        while (($row = oci_fetch_assoc($cursor)) != false) {
            $data[] = $row;
        }

        oci_free_statement($stmt);
        oci_free_statement($cursor);

        return $data;
    }

    // Actualizar empleado
    public function actualizarEmpleado($id_empleado, $nombre, $ubicacion, $telefono, $id_lote)
    {
        DB::statement('BEGIN pkg_empleado.actualizar_empleado(:id_empleado, :nombre, :ubicacion, :telefono, :id_lote); END;', [
            'id_empleado' => $id_empleado,
            'nombre' => $nombre,
            'ubicacion' => $ubicacion,
            'telefono' => $telefono,
            'id_lote' => $id_lote,
        ]);
    }

    // Eliminar empleado
    public function eliminarEmpleado($id_empleado)
    {
        DB::statement('BEGIN pkg_empleado.eliminar_empleado(:id_empleado); END;', [
            'id_empleado' => $id_empleado,
        ]);
    }
}
