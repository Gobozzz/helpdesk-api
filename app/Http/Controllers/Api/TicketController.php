<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Ticket\GetUserTicketsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Ticket\ChangeStatusTicketRequest;
use App\Http\Requests\Api\Ticket\CreateCommentTicketRequest;
use App\Http\Requests\Api\Ticket\CreateTicketRequest;
use App\Http\Resources\Api\Ticket\TicketHistoryResource;
use App\Http\Resources\Api\Ticket\TicketResource;
use App\Models\Ticket;
use App\Repositories\Ticket\TicketRepositoryContract;
use App\Services\Ticket\TicketServiceContract;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class TicketController extends Controller
{
    public function __construct(
        private readonly TicketServiceContract $tickets,
        private readonly TicketRepositoryContract $ticketRepo,
    ) {}

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

        $this->authorize('view', $ticket);

        return new TicketHistoryResource($ticket);
    }

    public function assign(Request $request, Ticket $ticket): TicketHistoryResource
    {
        $ticket = $this->tickets->assign($ticket, $request->user());

        return new TicketHistoryResource($ticket);
    }

    public function setStatus(ChangeStatusTicketRequest $request, Ticket $ticket): TicketHistoryResource
    {
        $this->authorize('setStatus', $ticket);

        $data = $request->getDto();
        $ticket = $this->tickets->setStatus($ticket, $data);

        return new TicketHistoryResource($ticket);
    }

    public function comment(CreateCommentTicketRequest $request, Ticket $ticket): TicketHistoryResource
    {
        $this->authorize('comment', $ticket);

        $data = $request->getDto();
        $ticket = $this->tickets->comment($ticket, $data);

        return new TicketHistoryResource($ticket);
    }
}
