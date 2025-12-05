<x-admin.modal
    :show="$showLabelModal"
    model="showLabelModal"
    title="Download Avery label"
    subtitle="Choose the label format and sheet position."
>

        <!-- Label format -->
        <div>
            <x-admin.input-label>Label format</x-admin.input-label>

            <x-admin.select name="mode">
                <option value="80mm_80mm">80 × 80 mm Avery</option>
            </x-admin.select>
        </div>


        <!-- Sheet position -->
        <div>
            <x-admin.input-label>Sheet position</x-admin.input-label>
            <x-admin.input-help>Select the label position on your A4 sheet.</x-admin.input-help>

            <div class="grid grid-cols-2 gap-3 mt-3">

                @foreach ([1,2,3,4,5,6] as $num)
                    <button
                        type="button"
                        wire:click="updateSlot({{ $num }})"
                        class="cursor-pointer rounded-lg border p-4 flex items-center justify-center
                               text-sm font-semibold transition
                               hover:bg-[var(--color-surface-hover)]
                               {{ $slot == $num ? 'border-[var(--color-primary)] bg-[var(--color-primary)]/10'
                                                : 'border-[var(--color-border)]' }}"
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
                type="button"
                variant="outline"
                :disabled="!$slot"
                wire:click="downloadLabel"
                @class(['opacity-40 pointer-events-none' => !$slot])
                
            >
                <x-heroicon-o-document-arrow-down class="w-4 h-4 mr-1.5" />
                Download label
            </x-admin.button>
        </x-slot:footer>


</x-admin.modal>
