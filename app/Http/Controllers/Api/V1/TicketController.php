<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Ticket\CreateTicketRequest;
use App\Http\Resources\Api\V1\Ticket\TicketResource;
use App\Services\Ticket\TicketServiceContract;

final class TicketController extends Controller
{
    public function __construct(
        private readonly TicketServiceContract $tickets,
    )
    {
    }

    public function create(CreateTicketRequest $request)
    {
        $data = $request->getDto();
        $ticket = $this->tickets->create($data, $request->user());
        return new TicketResource($ticket);
    }

}
