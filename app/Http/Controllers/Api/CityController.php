<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCityRequest;
use App\Http\Requests\UpdateCityRequest;
use App\Models\City;
use App\Repositories\Interfaces\CityRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CityController extends Controller
{
    private CityRepositoryInterface $cityRepository;

    public function __construct(CityRepositoryInterface $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    /**
     * Get all cities instances
     *
     * @OA\Get (
     *     path="/api/cities",
     *     tags={"City"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="number", example="1"),
     *                 @OA\Property(property="name", type="string", example="Луцьк"),
     *                 @OA\Property(property="region", type="string", example="Волинська")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json($this->cityRepository->getAllCities());
    }

    /**
     * Perform search in a listing of the resource.
     */
    public function search(string $searchString): JsonResponse
    {
        return response()->json($this->cityRepository->searchInCities($searchString));
    }

    /**
     * Create a new city instance
     *
     * @OA\Post (
     *     path="/api/cities",
     *     tags={"City"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(type="object",
     *                      @OA\Property(property="name", type="string"),
     *                      @OA\Property(property="region", type="string")
     *                 ),
     *                 example={
     *                     "name": "Луцьк",
     *                     "region": "Волинська"
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *         @OA\JsonContent(
     *             @OA\Property(property="region", type="string", example="Волинська"),
     *             @OA\Property(property="name", type="string", example="Луцьк"),
     *             @OA\Property(property="id", type="number", example="1")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The name field format is invalid."),
     *             @OA\Property(property="error", type="object",
     *                 @OA\Property(property="name", type="array", collectionFormat="multi",
     *                     @OA\Items(
     *                         type="string",
     *                         example="The name field format is invalid."
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function store(StoreCityRequest $request): JsonResponse
    {
        $fields = $request->validated();

        return response()->json($this->cityRepository->createCity($fields), Response::HTTP_CREATED);
    }

    /**
     * Find city by ID
     *
     * @OA\Get (
     *     path="/api/cities/{cityId}",
     *     tags={"City"},
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
     *             @OA\Property(property="id", type="number", example="1"),
     *             @OA\Property(property="name", type="string", example="Луцьк"),
     *             @OA\Property(property="region", type="string", example="Волинська")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(response=404, description="Resource not found")
     * )
     */
    public function show(City $city): JsonResponse
    {
        return response()->json($city);
    }

    /**
     * Update an existing city by ID
     *
     * @OA\Put (
     *     path="/api/cities/{cityId}",
     *     tags={"City"},
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
     *                     @OA\Property(property="name", type="string"),
     *                     @OA\Property(property="region", type="string")
     *                 ),
     *                 example={
     *                     "name": "Луцьк",
     *                     "region": "Волинська"
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="number", example="1"),
     *             @OA\Property(property="name", type="string", example="Луцьк"),
     *             @OA\Property(property="region", type="string", example="Волинська")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(response=404, description="Resource not found"),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The name field format is invalid."),
     *             @OA\Property(property="error", type="object",
     *                 @OA\Property(property="name", type="array", collectionFormat="multi",
     *                     @OA\Items(
     *                         type="string",
     *                         example="The name field format is invalid."
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function update(UpdateCityRequest $request, City $city): JsonResponse
    {
        $fields = $request->validated();

        return response()->json($this->cityRepository->updateCity($city, $fields));
    }

    /**
     * Remove city by ID
     *
     * @OA\Delete (
     *     path="/api/cities/{cityId}",
     *     tags={"City"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter (
     *         required=true,
     *         name="cityId",
     *         in="path",
     *         description="ID of city",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(response=404, description="Resource not found")
     * )
     */
    public function destroy(City $city): JsonResponse
    {
        $this->cityRepository->deleteCity($city);

        return response()->json([
            'message' => 'Successful operation'
        ]);
    }
}
