<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Actions\Ticket\GetUserTicketsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Ticket\ChangeStatusTicketRequest;
use App\Http\Requests\Api\V1\Ticket\CreateTicketRequest;
use App\Http\Resources\Api\V1\Ticket\TicketResource;
use App\Http\Resources\Api\V1\Ticket\TicketHistoryResource;
use App\Models\Ticket;
use App\Repositories\Ticket\TicketRepositoryContract;
use App\Services\Ticket\TicketServiceContract;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;

final class TicketController extends Controller
{
    public function __construct(
        private readonly TicketServiceContract    $tickets,
        private readonly TicketRepositoryContract $ticketRepo,
    )
    {
    }

    public function create(CreateTicketRequest $request): TicketHistoryResource
    {
        $data = $request->getDto();
        $ticket = $this->tickets->create($data);

        return new TicketHistoryResource($ticket);
    }

    public function getAll(Request $request, GetUserTicketsAction $getTickets): AnonymousResourceCollection
    {
        $tickets = $getTickets->handle($request->user());

        return TicketResource::collection($tickets);
    }

    public function getById(string $id): TicketHistoryResource
    {
        $ticket = $this->ticketRepo->getById($id);

        Gate::authorize('view', $ticket);

        return new TicketHistoryResource($ticket);
    }

    public function assign(Request $request, Ticket $ticket): TicketHistoryResource
    {
        $ticket = $this->tickets->assign($ticket, $request->user());

        return new TicketHistoryResource($ticket);
    }

    public function setStatus(ChangeStatusTicketRequest $request, Ticket $ticket): TicketHistoryResource
    {
        Gate::authorize('setStatus', $ticket);

        $data = $request->getDto();
        $ticket = $this->tickets->setStatus($ticket, $data);

        return new TicketHistoryResource($ticket);
    }

}
