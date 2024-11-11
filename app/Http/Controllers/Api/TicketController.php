<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\City;
use App\Models\Ticket;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TicketController extends Controller
{
    private TicketRepositoryInterface $ticketRepository;

    public function __construct(TicketRepositoryInterface $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    /**
     * Get all tickets of city by cityId
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
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="number", example="1"),
     *                 @OA\Property(property="city_id", type="number", example="1"),
     *                 @OA\Property(property="transport_type", type="string", example="Автобус"),
     *                 @OA\Property(property="ticket_type", type="string", example="Стандартний"),
     *                 @OA\Property(property="price", type="number", example="14")
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
        $tickets = $this->ticketRepository->getTicketsByCity($city);

        return response()->json(['data' => $tickets]);
    }

    /**
     * Create a new ticket for city by cityId
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
    public function store(StoreTicketRequest $request, City $city): JsonResponse
    {
        $fields = $request->validated();

        return response()->json(
            $this->ticketRepository->createTicket($city, array_merge(['city_id' => $city->id], $fields)),
            Response::HTTP_CREATED
        );
    }

    /**
     * Get city's ticket by cityId and ticketId
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
    public function show(City $city, Ticket $ticket): JsonResponse
    {
        if ($ticket->city_id != $city->id) {
            return response()->json(['error' => 'Resource not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($ticket);
    }

    /**
     * Update an existing city's ticket by cityId and ticketId
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
    public function update(UpdateTicketRequest $request, City $city, Ticket $ticket): JsonResponse
    {
        $fields = $request->validated();

        if ($ticket->city_id != $city->id) {
            return response()->json(['error' => 'Resource not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($this->ticketRepository->updateTicket($ticket, $fields));
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
    public function destroy(City $city, Ticket $ticket): JsonResponse
    {
        if ($ticket->city_id != $city->id) {
            return response()->json(['error' => 'Resource not found'], Response::HTTP_NOT_FOUND);
        }
        $this->ticketRepository->deleteTicket($ticket);

        return response()->json(['message' => 'Successful operation']);
    }
}
