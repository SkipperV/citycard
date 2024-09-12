<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\TransportRoute;
use App\Repositories\Interfaces\TransportRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransportRouteController extends Controller
{
    private TransportRepositoryInterface $transportRepository;

    public function __construct(TransportRepositoryInterface $transportRepository)
    {
        $this->transportRepository = $transportRepository;
    }

    /**
     * Get all city's transport by cityId
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
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="number", example="1"),
     *                 @OA\Property(property="city_id", type="number", example="1"),
     *                 @OA\Property(property="route_number", type="number", example="1"),
     *                 @OA\Property(property="transport_type", type="string", example="Автобус"),
     *                 @OA\Property(property="route_endpoint_1", type="string", example="Північна"),
     *                 @OA\Property(property="route_endpoint_2", type="string", example="Південна")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(response=404, description="Resource not found")
     * )
     */
    public function index(City $city): JsonResponse
    {
        $transport = $this->transportRepository->getTransportByCity($city);

        return response()->json(['data' => $transport]);
    }

    /**
     * Create a new city's transport route by cityId
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
    public function store(Request $request, City $city): JsonResponse
    {
        $fields = $request->validate([
            'route_number' => 'numeric',
            'transport_type' => 'in:Автобус,Тролейбус',
            'route_endpoint_1' => 'max:255',
            'route_endpoint_2' => 'max:255',
        ]);

        return response()->json(
            $this->transportRepository->createTransport($city, array_merge(['city_id' => $city->id], $fields)),
            Response::HTTP_CREATED
        );
    }

    /**
     * Find city's transport by cityId and transportId
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
    public function show(City $city, TransportRoute $transport): JsonResponse
    {
        if ($transport->city_id != $city->id) {
            return response()->json(['message' => 'Resource not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($transport);
    }

    /**
     * Update an existing city's transport by cityId and transportId
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
    public function update(Request $request, City $city, TransportRoute $transport): JsonResponse
    {
        $fields = $request->validate([
            'route_number' => 'numeric',
            'transport_type' => 'in:Автобус,Тролейбус',
            'route_endpoint_1' => 'max:255',
            'route_endpoint_2' => 'max:255',
        ]);

        if ($transport->city_id != $city->id) {
            return response()->json(['message' => 'Resource not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($this->transportRepository->updateTransport($transport, $fields));
    }

    /**
     * Remove transport by cityId and transportId
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
    public function destroy(City $city, TransportRoute $transport): JsonResponse
    {
        if ($transport->city_id != $city->id) {
            return response()->json(['error' => 'Resource not found'], Response::HTTP_NOT_FOUND);
        }
        $this->transportRepository->deleteTransport($transport);

        return response()->json(['message' => 'Successful operation']);
    }
}
