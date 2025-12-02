<x-admin.modal
    :show="$showLabelModal"
    model="showLabelModal"
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

            <x-admin.select name="mode" wire:model.live="selectedFormat">
                @foreach ($labelFormats as $format)
                    <option value="{{ $format->key_name }}">
                        {{ $format->name }}
                        ({{ $format->label_width_mm }}×{{ $format->label_height_mm }} mm)
                    </option>
                @endforeach
            </x-admin.select>
        </div>


        <!-- Sheet position -->
        <div>
            <x-admin.input-label>Sheet position</x-admin.input-label>
            <x-admin.input-help>Select the label position on your A4 sheet</x-admin.input-help>

            <!-- The slot Livewire prop is now bound properly -->
            <input type="hidden" name="slot" wire:model="slot">

            @php
                $currentFormat = $labelFormats->firstWhere('key_name', $selectedFormat);
            @endphp

            <div
                class="grid gap-3 mt-3"
                style="grid-template-columns: repeat({{ $currentFormat->columns }}, minmax(0, 1fr));"
            >
                @foreach ($positions as $num)
                    <button
                        type="button"
                        wire:click="updateSlot({{$num}})"
                        class="cursor-pointer border rounded-lg p-4 flex items-center justify-center
                               text-sm font-semibold transition
                               hover:bg-[var(--color-surface-hover)] 
                               {{ $slot == $num ? 'border-[var(--color-primary)]' : 'border-[var(--color-border)]' }}"
                        >
                        {{ $num }}
                    </button>
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

            <x-admin.button
                type="submit"
                variant="outline"
                :disabled="!$slot"
                wire:click="downloadLabel"
                @class(['opacity-40 pointer-events-none' => !$slot])
            >
                <x-heroicon-o-document-arrow-down class="w-4 h-4 mr-1.5" />
                Download label
            </x-admin.button>
        </x-slot:footer>

    </form>

</x-admin.modal>
