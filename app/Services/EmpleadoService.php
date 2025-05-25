<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class EmpleadoService
{
    // Insertar empleado
    public function insertarEmpleado($nombre, $salario)
    {
        DB::statement('BEGIN pkg_empleados.insertar_empleado(:nombre, :salario); END;', [
            'nombre' => $nombre,
            'salario' => $salario,
        ]);
    }

    // Obtener empleado (usando cursor REF CURSOR)
    public function obtenerEmpleado($id)
    {
        // Aquí debemos usar un cursor para obtener el resultado
        // Laravel DB no maneja REF CURSOR directo, por eso usamos PDO puro
        $conn = DB::getPdo(); // Este es un recurso OCI8 si usas yajra

        // Preparar cursor
        $cursor = oci_new_cursor($conn);

        // Preparar statement con bind del cursor
        $stmt = oci_parse($conn, 'BEGIN :cursor := pkg_empleados.obtener_empleado(:id); END;');
        oci_bind_by_name($stmt, ':id', $id);
        oci_bind_by_name($stmt, ':cursor', $cursor, -1, OCI_B_CURSOR);

        // Ejecutar procedimiento y cursor
        oci_execute($stmt);
        oci_execute($cursor);

        $data = [];
        while (($row = oci_fetch_assoc($cursor)) != false) {
            $data[] = $row;
        }

        // Cerrar recursos
        oci_free_statement($stmt);
        oci_free_statement($cursor);

        return $data;

    }

    // Actualizar empleado
    public function actualizarEmpleado($id, $nombre, $salario)
    {
        DB::statement('BEGIN pkg_empleados.actualizar_empleado(:id, :nombre, :salario); END;', [
            'id' => $id,
            'nombre' => $nombre,
            'salario' => $salario,
        ]);
    }

    // Eliminar empleado
    public function eliminarEmpleado($id)
    {
        DB::statement('BEGIN pkg_empleados.eliminar_empleado(:id); END;', [
            'id' => $id,
        ]);
    }
}
