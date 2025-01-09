<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCityRequest;
use App\Http\Requests\UpdateCityRequest;
use App\Interfaces\CityRepositoryInterface;
use App\Models\City;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search term for cities",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="Луцьк"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="current_page", type="number", example="1"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="number", example="1"),
     *                     @OA\Property(property="name", type="string", example="Луцьк"),
     *                     @OA\Property(property="region", type="string", example="Волинська")
     *                 )
     *             ),
     *             @OA\Property(property="first_page_url", type="string", example="http://localhost:8080/api/cities?search=%D0%9B%D1%83%D1%86%D1%8C%D0%BA&page=1"),
     *             @OA\Property(property="from", type="number", example="1"),
     *             @OA\Property(property="last_page", type="number", example="1"),
     *             @OA\Property(property="last_page_url", type="string", example="http://localhost:8080/api/cities?search=%D0%9B%D1%83%D1%86%D1%8C%D0%BA&page=1"),
     *             @OA\Property(property="next_page_url", type="string", example="null"),
     *             @OA\Property(property="path", type="string", example="http://localhost:8080/api/cities"),
     *             @OA\Property(property="per_page", type="number", example="10"),
     *             @OA\Property(property="prev_page_url", type="string", example="null"),
     *             @OA\Property(property="to", type="number", example="1"),
     *             @OA\Property(property="total", type="number", example="1"),
     *             @OA\Property(property="links", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="url", type="string", example="null"),
     *                     @OA\Property(property="label", type="string", example="&laquo; Previous"),
     *                     @OA\Property(property="active", type="string", example="false")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json(
            $request->query('search') != ''
                ? $this->cityRepository->search($request)
                : $this->cityRepository->getAllCities()
        );
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
     *                 @OA\Property(property="name", type="array",
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
     *                 @OA\Property(property="name", type="array",
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
