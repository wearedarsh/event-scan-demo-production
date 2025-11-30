<x-admin.modal
    :show="$showLabelModal"
    wire:click="$set('showLabelModal', false)"
    title="Download Avery label"
    subtitle="Choose the label format and sheet position."
>

    <form
        method="GET"
        action="{{ route('admin.events.attendees.label.export', [$event->id, $attendee->id]) }}"
        target="_blank"
        class="space-y-6"
    >

        <!-- Label format -->
        <div>
            <x-admin.input-label>Label format</x-admin.input-label>
            <x-admin.select name="mode">
                <option value="overlay_core">No Header – Avery (75×110 mm)</option>
                <option value="a6_full">Full – Avery A6 (105×148 mm)</option>
            </x-admin.select>
        </div>

        <!-- Sheet position -->
        <div>
            <x-admin.input-label>Sheet position</x-admin.input-label>

            <div class="flex flex-wrap gap-2 mt-2">
                @foreach([1 => 'Top left', 2 => 'Top right', 3 => 'Bottom left', 4 => 'Bottom right'] as $num => $label)

                    <x-admin.filter-pill
                        :active="(string) request('slot', '1') === (string) $num"
                        onclick="document.getElementById('slot_{{ $num }}').checked = true"
                    >
                        {{ $num }} — {{ $label }}
                    </x-admin.filter-pill>

                    <input type="radio" id="slot_{{ $num }}" name="slot" value="{{ $num }}" class="hidden" {{ $num === 1 ? 'checked' : '' }}>
                @endforeach
            </div>
        </div>

        <!-- Footer -->
        <x-slot:footer>
            <x-admin.button
                type="button"
                variant="secondary"
                wire:click="$set('showLabelModal', false)"
            >
                Cancel
            </x-admin.button>

            <x-admin.button type="submit" variant="outline">
                <x-heroicon-o-document-arrow-down class="w-4 h-4 mr-1.5" />
                Download label
            </x-admin.button>
        </x-slot:footer>

    </form>

</x-admin.modal>
