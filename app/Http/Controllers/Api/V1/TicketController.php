<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Actions\Ticket\GetUserTicketsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Ticket\CreateTicketRequest;
use App\Http\Resources\Api\V1\Ticket\TicketResource;
use App\Http\Resources\Api\V1\Ticket\TicketHistoryResource;
use App\Services\Ticket\TicketServiceContract;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class TicketController extends Controller
{
    public function __construct(
        private readonly TicketServiceContract $tickets,
    )
    {
    }

    public function create(CreateTicketRequest $request): TicketHistoryResource
    {
        $data = $request->getDto();
        $ticket = $this->tickets->create($data, $request->user());

        return new TicketHistoryResource($ticket);
    }

    public function getAll(Request $request, GetUserTicketsAction $getTickets): AnonymousResourceCollection
    {
        $tickets = $getTickets->handle($request->user());

        return TicketResource::collection($tickets);
    }

}
