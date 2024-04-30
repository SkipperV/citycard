<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TicketController extends Controller
{
    /**
     * Get all city's tickets
     *
     * @OA\Get (
     *     path="/api/cities/{cityId}/tickets",
     *     tags={"Ticket"},
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
     *                 @OA\Property(property="transport_type", type="string", example="Автобус"),
     *                 @OA\Property(property="ticket_type", type="string", example="Стандартний"),
     *                 @OA\Property(property="price", type="number", example="14")
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
        $tickets = $city->tickets()->get();
        return $tickets->isNotEmpty() ? $tickets : response([], 204);
    }

    /**
     * Create a new city's ticket
     *
     * @OA\Post (
     *     path="/api/cities/{cityId}/tickets",
     *     tags={"Ticket"},
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
     *                      type="object",
     *                      @OA\Property(property="transport_type", type="string"),
     *                      @OA\Property(property="ticket_type", type="string"),
     *                      @OA\Property(property="price", type="number")
     *                 ),
     *                 example={
     *                     "transport_type": "Автобус",
     *                     "ticket_type": "Стандартний",
     *                     "price": "14"
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
     *             @OA\Property(property="transport_type", type="string", example="Автобус"),
     *             @OA\Property(property="ticket_type", type="string", example="Стандартний"),
     *             @OA\Property(property="price", type="number", example="14")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The transport_type field format is invalid."),
     *             @OA\Property(property="error", type="object",
     *                 @OA\Property(property="transport_type", type="array", collectionFormat="multi",
     *                     @OA\Items(
     *                         type="string",
     *                         example="The transport_type field format is invalid."
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
            'transport_type' => 'required|in:Автобус,Тролейбус',
            'ticket_type' => 'required|in:Стандартний,Дитячий,Студентський,Пільговий,Спеціальний',
            'price' => 'required|numeric'
        ]);

        $ticket = Ticket::make($fields);
        $ticket->city_id = $city->id;
        $ticket->save();

        return response($ticket, 201);
    }

    /**
     * Find city's ticket by ID
     *
     * @OA\Get (
     *     path="/api/cities/{cityId}/tickets/{ticketId}",
     *     tags={"Ticket"},
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
     *         name="ticketId",
     *         in="path",
     *         description="ID of Ticket",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="number", example="1"),
     *             @OA\Property(property="city_id", type="number", example="1"),
     *             @OA\Property(property="transport_type", type="string", example="Автобус"),
     *             @OA\Property(property="ticket_type", type="string", example="Стандартний"),
     *             @OA\Property(property="price", type="number", example="14")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(response=404, description="Resource not found")
     * )
     */
    public function show(City $city, Ticket $ticket): Ticket|Response
    {
        if ($ticket->city_id != $city->id) {
            return response(['error' => 'Resource not found'], 404);
        }

        return $ticket;
    }

    /**
     * Update an existing city's ticket by ID
     *
     * @OA\Put (
     *     path="/api/cities/{cityId}/tickets/{ticketId}",
     *     tags={"Ticket"},
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
     *         name="ticketId",
     *         in="path",
     *         description="ID of ticket",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(property="transport_type", type="string"),
     *                      @OA\Property(property="ticket_type", type="string"),
     *                      @OA\Property(property="price", type="number"),
     *                 ),
     *                 example={
     *                     "transport_type": "Автобус",
     *                     "ticket_type": "Стандартний",
     *                     "price": "14"
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
     *             @OA\Property(property="transport_type", type="string", example="Автобус"),
     *             @OA\Property(property="ticket_type", type="string", example="Стандартний"),
     *             @OA\Property(property="price", type="number", example="14")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(response=404, description="Resource not found"),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The transport_type field format is invalid."),
     *             @OA\Property(property="error", type="object",
     *                 @OA\Property(property="transport_type", type="array", collectionFormat="multi",
     *                     @OA\Items(
     *                         type="string",
     *                         example="The transport_type field format is invalid."
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function update(Request $request, City $city, Ticket $ticket): Response|Ticket
    {
        $fields = $request->validate([
            'transport_type' => 'in:Автобус,Тролейбус',
            'ticket_type' => 'in:Стандартний,Дитячий,Студентський,Пільговий,Спеціальний',
            'price' => 'numeric'
        ]);

        if ($ticket->city_id != $city->id) {
            return response(['error' => 'Resource not found'], 404);
        }
        $ticket->update($fields);

        return $ticket;
    }

    /**
     * Remove ticket by ID
     *
     * @OA\Delete (
     *     path="/api/cities/{cityId}/tickets/{ticketId}",
     *     tags={"Ticket"},
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
     *         name="ticketId",
     *         in="path",
     *         description="ID of ticket",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(response=404, description="Resource not found")
     * )
     */
    public function destroy(City $city, Ticket $ticket): Response
    {
        if ($ticket->city_id != $city->id) {
            return response(['error' => 'Resource not found'], 404);
        }

        $ticket->delete();
        return response(['message' => 'Successful operation']);
    }
}
