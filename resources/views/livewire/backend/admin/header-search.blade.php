<div class="relative" x-data="{ open: false }" @click.outside="open = false">

<x-admin.search-input
    wire:model.live="query"
    x-on:focusin="open = true"
    x-on:input="open = true"
    placeholder="Search…"
/>


    @if(strlen($query) > 1)
    <div
        x-show="open"
        x-transition
        class="absolute top-full left-0 right-0 mt-1 bg-white border border-[var(--color-border)] rounded-lg shadow-lg z-50">

        @if($results['events']->count())
        <div class="px-3 pt-2 pb-1 text-xs uppercase text-gray-400">Events</div>
        @foreach($results['events'] as $event)
        <a href="{{ $this->resultUrl('events', $event) }}"
            class="block px-3 py-2 text-sm hover:bg-gray-100 text-[var(--color-text)]">
            {{ $event->title }} 
        </a>
        @endforeach
        @endif

        @if($results['attendees']->count())
        <div class="px-3 pt-3 pb-1 text-xs uppercase text-gray-400">Attendees</div>
        @foreach($results['attendees'] as $person)
        <a href="{{ $this->resultUrl('attendees', $person) }}"
            class="block px-3 py-2 text-sm hover:bg-gray-100 text-[var(--color-text)]">
            {{ $person->first_name }} {{ $person->last_name }}
            <span class="text-gray-400 text-xs">{{ $person->booking_reference }}</span><br>
            <span class="text-gray-400 text-xs">{{ $person->email }}</span>
        </a>
        @endforeach
        @endif

        @if($results['registrations']->count())
        <div class="px-3 pt-3 pb-1 text-xs uppercase text-gray-400">Registrations</div>
        @foreach($results['registrations'] as $reg)
        <a href="{{ $this->resultUrl('registrations', $reg) }}"
            class="block px-3 py-2 text-sm hover:bg-gray-100 text-[var(--color-text)]">
            {{ $reg->first_name }} {{ $reg->last_name }}
            <span class="text-gray-400 text-xs">{{ $person->booking_reference }}</span><br>
            <span class="text-gray-400 text-xs">{{ $reg->email }}</span>
        </a>
        @endforeach
        @endif

        @if($results['users']->count())
        <div class="px-3 pt-3 pb-1 text-xs uppercase text-gray-400">Users</div>
        @foreach($results['users'] as $user)
        <a href="{{ $this->resultUrl('users', $user) }}"
            class="block px-3 py-2 text-sm hover:bg-gray-100 text-[var(--color-text)]">
            {{ $user->first_name }} {{ $user->last_name }}<br>
            <span class="text-gray-400 text-xs">{{ $user->email }}</span>
        </a>
        @endforeach
        @endif

        @if(
        !$results['events']->count() &&
        !$results['attendees']->count() &&
        !$results['registrations']->count() &&
        !$results['users']->count()
        )
        <div class="px-3 py-3 text-sm text-gray-400">
            No results found.
        </div>
        @endif

    </div>
    @endif

</div>