<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CityController extends Controller
{
    /**
     * Get all city instances
     *
     * @OA\Get (
     *     path="/api/cities",
     *     tags={"City"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(type="object",
     *                 @OA\Property(property="id", type="number", example="1"),
     *                 @OA\Property(property="name", type="string", example="Луцьк"),
     *                 @OA\Property(property="region", type="string", example="Волинська")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=204, description="No Content"),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     */
    public function index(): Collection|Response
    {
        $cities = City::all();
        return $cities->isNotEmpty() ? $cities : response([], 204);
    }

    /**
     * Perform search in a listing of the resource.
     */
    public function search(string $searchString): Collection
    {
        return City::where('name', 'LIKE', '%' . $searchString . '%')
            ->orWhere('region', 'LIKE', '%' . $searchString . '%')
            ->get();
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
     *                 @OA\Property(
     *                      type="object",
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
    public function store(Request $request): Response
    {
        $fields = $request->validate([
            'region' => 'required|alpha|max:30',
            'name' => 'required|alpha|max:30'
        ]);

        $city = City::create($fields);

        return response($city, 201);
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
    public function show(City $city): City|Response
    {
        return $city;
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
    public function update(Request $request, City $city): Response|City
    {
        $fields = $request->validate([
            'region' => 'alpha|max:30',
            'name' => 'alpha|max:30'
        ]);
        $city->update($fields);

        return $city;
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
    public function destroy(City $city): Response
    {
        $city->delete();
        return response(['message' => 'Successful operation']);
    }
}
