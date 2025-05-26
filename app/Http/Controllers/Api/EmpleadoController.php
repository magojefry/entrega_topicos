<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\EmpleadoService;
use Illuminate\Support\Facades\DB;

class EmpleadoController extends Controller
{    protected $empleadoService;

    public function __construct(EmpleadoService $empleadoService)
    {
        $this->empleadoService = $empleadoService;
    }

    // Listar empleados
    public function index()
    {
        $empleados = DB::select('SELECT * FROM EMPLEADO ORDER BY ID_EMPLEADO DESC');
        return response()->json($empleados);
    }

    // Crear nuevo empleado
    public function store(Request $request)
    {
        $request->validate([
            'nombre'    => 'required|string|max:100',
            'ubicacion' => 'required|string|max:100',
            'telefono'  => 'required|numeric|digits_between:7,15',
            'id_lote'   => 'required|integer|exists:LOTE,ID_LOTE',
        ]);

        $this->empleadoService->insertarEmpleado(
            $request->nombre,
            $request->ubicacion,
            $request->telefono,
            $request->id_lote
        );

        return response()->json(['message' => 'Empleado creado con éxito'], 201);
    }

    // Mostrar un empleado
    public function show($id_empleado)
    {
        $empleado = $this->empleadoService->obtenerEmpleado($id_empleado);

        if (empty($empleado)) {
            return response()->json(['message' => 'Empleado no encontrado'], 404);
        }

        return response()->json($empleado[0]);
    }

    // Actualizar empleado
    public function update(Request $request, $id_empleado)
    {
        $request->validate([
            'nombre'    => 'required|string|max:100',
            'ubicacion' => 'required|string|max:100',
            'telefono'  => 'required|numeric|digits_between:7,15',
            'id_lote'   => 'required|integer|exists:LOTE,ID_LOTE',
        ]);

        $this->empleadoService->actualizarEmpleado(
            $id_empleado,
            $request->nombre,
            $request->ubicacion,
            $request->telefono,
            $request->id_lote
        );

        return response()->json(['message' => 'Empleado actualizado']);
    }

    // Eliminar empleado
    public function destroy($id_empleado)
    {
        $this->empleadoService->eliminarEmpleado($id_empleado);

        return response()->json(['message' => 'Empleado eliminado']);
    }
    
}
