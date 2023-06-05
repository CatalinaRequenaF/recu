Route::apiResource('communities', CommunitiesController::class)->except('update, delete, put, patch');<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    //
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    /**
     * Obtener las direcciones del usuario autenticado.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = Auth::user();
        $addresses = $user->addresses;

        return response()->json([
            'addresses' => $addresses
        ]);
    }

    /**
     * Crear una nueva dirección para el usuario autenticado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'address_line_1' => 'required',
            'address_line_2' => 'nullable',
            'city' => 'required',
            'state' => 'required',
            'postal_code' => 'required',
            'country' => 'required',
        ]);

        $address = $user->addresses()->create($validatedData);

        return response()->json([
            'message' => 'La dirección se ha creado correctamente.',
            'address' => $address
        ], 201);
    }

    /**
     * Mostrar los detalles de una dirección específica del usuario autenticado.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Address $address)
    {
        // Verificar si la dirección pertenece al usuario autenticado
        if ($address->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'No tienes permiso para acceder a esta dirección.'
            ], 403);
        }

        return response()->json([
            'address' => $address
        ]);
    }

    /**
     * Actualizar una dirección existente del usuario autenticado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Address $address)
    {
        // Verificar si la dirección pertenece al usuario autenticado
        if ($address->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'No tienes permiso para actualizar esta dirección.'
            ], 403);
        }

        $validatedData = $request->validate([
            'address_line_1' => 'required',
            'address_line_2' => 'nullable',
            'city' => 'required',
            'state' => 'required',
            'postal_code' => 'required',
            'country' => 'required',
        ]);

        $address->update($validatedData);

        return response()->json([
            'message' => 'La dirección se ha actualizado correctamente.',
            'address' => $address
        ]);
    }

    /**
     * Eliminar una dirección del usuario autenticado.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Address $address)
    {
        // Verificar si la dirección pertenece al usuario autenticado
        if ($address->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'No tienes permiso para eliminar esta dirección.'
            ], 403);
        }

        $address->delete();

        return response()->json([
            'message' => 'La dirección se ha eliminado correctamente.'
        ]);
    }
}
user