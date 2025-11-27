<div>
    <div class="flex-row d-flex flex-1 rounded-2 p-3 align-items-center">
        <h2 class="fs-4 text-brand-dark p-0 m-0">Tickets for {{ $event->title }}</h2>
    </div>

    @if($errors->any())
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info" role="alert">
                    <span class="font-m">{{ $errors->first() }}</span>           
                </div>
            </div>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success" role="alert">
                    <span class="font-m">{{ session('success') }}</span>           
                </div>
            </div>
        </div>
    @endif

    <div class="flex-row d-flex flex-1 bg-white rounded-2 p-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb d-flex flex-row align-items-center">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.events.index') }}">Events</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.events.manage', $event->id) }}">{{$event->title}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tickets</li>
            </ol>
        </nav>
    </div>

    {{-- Ticket Groups Table --}}
    <div class="flex-column d-flex p-3 bg-white rounded-2 mt-3">
        <div class="row mb-3">
            <div class="col-sm-9">
                <h3>Ticket Groups</h3>
            </div>
            <div class="col-sm-3">
                <a class="btn bg-brand-secondary d-flex align-items-center justify-content-center width-auto" href="{{ route('admin.events.tickets.groups.create', ['event' => $event->id]) }}"><span class="cil-plus me-1"></span>Add Ticket Group</a>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-bordered align-middle font-m" style="margin-bottom:100px">
                <thead class="table-light">
                    <tr>
                        <th>Group name</th>
                        <th>Display order
                            <span class="badge bg-brand-secondary cursor-pointer font-s ms-2 px-2 py-1 rounded-5" data-coreui-toggle="tooltip" data-coreui-placement="top" title="This is the order in which the group will show on the registration form"><span class="text-brand-light">more info</span></span>
                        </th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($event->allTicketGroups as $group)
                        <tr>
                            <td>{{ $group->name }}</td>
                            <td>{{ $group->display_order }}</td>
                            <td>
                                @if($group->active)
                                    <span class="badge text-bg-success font-s fw-normal"><span class="text-brand-light">Active</span></span>
                                @else
                                    <span class="badge text-bg-danger font-s fw-normal"><span class="text-brand-light">Inactive</span></span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn bg-brand-secondary dropdown-toggle" type="button" data-coreui-toggle="dropdown" aria-expanded="false">
                                        Action
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item font-m" href="{{route('admin.events.tickets.groups.edit', ['event' => $event->id, 'ticket_group' => $group->id])}}">Edit</a></li>
                                        @if($group->tickets->flatMap->registrationTickets->count() === 0)
                                            <li><a class="dropdown-item font-m cursor-pointer" wire:confirm="Are you sure you want to delete this ticket group? This will delete all tickets belonging to this group too" wire:click="deleteTicketGroup({{ $group->id }})">Delete</a></li>
                                        @else
                                            <li class="p-3"><span class="font-s">This ticket group cannot be deleted as tickets that belong to it have been purchased</span></li>
                                        @endif  
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">No ticket groups found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    {{-- Tickets Table --}}
    <div class="flex-column d-flex p-3 bg-white rounded-2 mt-3">
        <div class="row mb-3">
            <div class="col-sm-9">
                <h3>Tickets</h3>
            </div>
            <div class="col-sm-3">
                <a class="btn bg-brand-secondary d-flex align-items-center justify-content-center width-auto" href="{{ route('admin.events.tickets.create', ['event' => $event->id]) }}"><span class="cil-plus me-1"></span>Add Ticket</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered align-middle font-m"  style="margin-bottom:100px;">
                <thead class="table-light">
                    <tr>
                        <th>Ticket title</th>
                        <th>Price</th>
                        <th>Group</th>
                        <th>Display order</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($event->allTickets as $ticket)
                        <tr>
                            <td>{{ $ticket->name }}</td>
                            <td>{{ $currency_symbol }}{{ $ticket->price }}</td>
                            <td>{{ $ticket->ticketGroup->name ?? '—' }}</td>
                            <td>{{ $ticket->display_order }}
                            <td>
                                @if($ticket->active)
                                    <span class="badge text-bg-success font-s fw-normal"><span class="text-brand-light">Active</span></span>
                                @else
                                    <span class="badge text-bg-danger font-s fw-normal"><span class="text-brand-light">Inactive</span></span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn bg-brand-secondary dropdown-toggle" type="button" data-coreui-toggle="dropdown" aria-expanded="false">
                                        Action
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item font-m" href="{{ route('admin.events.tickets.edit', ['event' => $event->id, 'ticket' => $ticket->id]) }}">Edit</a></li>
                                        @if(!$ticket->registrationTickets()->exists())
                                            <li><a class="dropdown-item font-m cursor-pointer" wire:confirm="Are you sure you want to delete this ticket?" wire:click.prevent="deleteTicket({{ $ticket->id }})">Delete</a></li>
                                        @else
                                            <li class="p-3"><span class="font-s">This ticket cannot be deleted as it has been purchased</span></li>
                                        @endif 
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No tickets found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            
        </div>
    </div>
</div>
    
