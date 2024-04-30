<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\TransportRoute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransportRouteController extends Controller
{
    /**
     * Get all city's transport
     *
     * @OA\Get (
     *     path="/api/cities/{cityId}/transport",
     *     tags={"Transport"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter (
     *         required=true,
     *         name="cityId",
     *         in="path",
     *         description="ID of city",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(type="object",
     *                 @OA\Property(property="id", type="number", example="1"),
     *                 @OA\Property(property="city_id", type="number", example="1"),
     *                 @OA\Property(property="route_number", type="number", example="1"),
     *                 @OA\Property(property="transport_type", type="string", example="Автобус"),
     *                 @OA\Property(property="route_endpoint_1", type="string", example="Північна"),
     *                 @OA\Property(property="route_endpoint_2", type="string", example="Південна")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=204, description="No Content"),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(response=404, description="Resource not found")
     * )
     */
    public function index(City $city): Response|Collection
    {
        $transport = $city->transportRoutes()->get();
        return $transport->isNotEmpty() ? $transport : response([], 204);
    }

    /**
     * Create a new city's transport route
     *
     * @OA\Post (
     *     path="/api/cities/{cityId}/transport",
     *     tags={"Transport"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter (
     *         required=true,
     *         name="cityId",
     *         in="path",
     *         description="ID of city",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     type="object",
     *                     @OA\Property(property="route_number", type="number"),
     *                     @OA\Property(property="transport_type", type="string"),
     *                     @OA\Property(property="route_endpoint_1", type="string"),
     *                     @OA\Property(property="route_endpoint_2", type="string")
     *                 ),
     *                 example={
     *                     "route_number": "1",
     *                     "transport_type": "Автобус",
     *                     "route_endpoint_1": "Північна",
     *                     "route_endpoint_1": "Південна"
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="number", example="1"),
     *             @OA\Property(property="city_id", type="number", example="1"),
     *             @OA\Property(property="route_number", type="number", example="1"),
     *             @OA\Property(property="transport_type", type="string", example="Автобус"),
     *             @OA\Property(property="route_endpoint_1", type="string", example="Північна"),
     *             @OA\Property(property="route_endpoint_2", type="string", example="Південна")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The route_number field format is invalid."),
     *             @OA\Property(property="error", type="object",
     *                 @OA\Property(property="route_number", type="array", collectionFormat="multi",
     *                     @OA\Items(
     *                         type="string",
     *                         example="The route_number field format is invalid."
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function store(Request $request, City $city): Response
    {
        $fields = $request->validate([
            'route_number' => 'numeric',
            'transport_type' => 'in:Автобус,Тролейбус',
            'route_endpoint_1' => 'max:255',
            'route_endpoint_2' => 'max:255',
        ]);

        $transport = TransportRoute::make($fields);
        $transport->city_id = $city->id;
        $transport->save();

        return response($transport, 201);
    }

    /**
     * Find city's transport by ID
     *
     * @OA\Get (
     *     path="/api/cities/{cityId}/transport/{transportId}",
     *     tags={"Transport"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter (
     *         required=true,
     *         name="cityId",
     *         in="path",
     *         description="ID of city",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter (
     *         required=true,
     *         name="transportId",
     *         in="path",
     *         description="ID of transport",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="number", example="1"),
     *             @OA\Property(property="city_id", type="number", example="1"),
     *             @OA\Property(property="route_number", type="number", example="1"),
     *             @OA\Property(property="transport_type", type="string", example="Автобус"),
     *             @OA\Property(property="route_endpoint_1", type="string", example="Північна"),
     *             @OA\Property(property="route_endpoint_2", type="string", example="Південна")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(response=404, description="Resource not found")
     * )
     */
    public function show(City $city, TransportRoute $transport): TransportRoute|Response
    {
        if ($transport->city_id != $city->id) {
            return response(['message' => 'Resource not found'], 404);
        }

        return $transport;
    }

    /**
     * Update an existing city's transport by ID
     *
     * @OA\Put (
     *     path="/api/cities/{cityId}/transport/{transportId}",
     *     tags={"Transport"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter (
     *         required=true,
     *         name="cityId",
     *         in="path",
     *         description="ID of city",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter (
     *         required=true,
     *         name="transportId",
     *         in="path",
     *         description="ID of transport",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     type="object",
     *                     @OA\Property(property="route_number", type="number"),
     *                     @OA\Property(property="transport_type", type="string"),
     *                     @OA\Property(property="route_endpoint_1", type="string"),
     *                     @OA\Property(property="route_endpoint_2", type="string")
     *                 ),
     *                 example={
     *                     "route_number": "1",
     *                     "transport_type": "Автобус",
     *                     "route_endpoint_1": "Північна",
     *                     "route_endpoint_1": "Південна"
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="number", example="1"),
     *             @OA\Property(property="city_id", type="number", example="1"),
     *             @OA\Property(property="route_number", type="number", example="1"),
     *             @OA\Property(property="transport_type", type="string", example="Автобус"),
     *             @OA\Property(property="route_endpoint_1", type="string", example="Північна"),
     *             @OA\Property(property="route_endpoint_2", type="string", example="Південна")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(response=404, description="Resource not found"),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The route_number field format is invalid."),
     *             @OA\Property(property="error", type="object",
     *                 @OA\Property(property="route_number", type="array", collectionFormat="multi",
     *                     @OA\Items(
     *                         type="string",
     *                         example="The route_number field format is invalid."
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function update(Request $request, City $city, TransportRoute $transport): Response|TransportRoute
    {
        $fields = $request->validate([
            'route_number' => 'numeric',
            'transport_type' => 'in:Автобус,Тролейбус',
            'route_endpoint_1' => 'max:255',
            'route_endpoint_2' => 'max:255',
        ]);

        if ($transport->city_id != $city->id) {
            return response(['message' => 'Resource not found'], 404);
        }
        $transport->update($fields);

        return $transport;
    }

    /**
     * Remove transport by ID
     *
     * @OA\Delete (
     *     path="/api/cities/{cityId}/transport/{transportId}",
     *     tags={"Transport"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter (
     *         required=true,
     *         name="cityId",
     *         in="path",
     *         description="ID of city",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter (
     *         required=true,
     *         name="transportId",
     *         in="path",
     *         description="ID of transport",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(response=404, description="Resource not found")
     * )
     */
    public function destroy(City $city, TransportRoute $transport): Response
    {
        if ($transport->city_id != $city->id) {
            return response(['error' => 'Resource not found'], 404);
        }

        $transport->delete();
        return response(['message' => 'Successful operation']);
    }
}
