<x-admin.modal
    :show="$showMarkPaidModal"
    wire:click="$set('showMarkPaidModal', false)"
    title="Confirm payment"
    subtitle="Enter the date payment was received."
>

    @if($errors->any())
        <x-admin.alert type="danger" :message="$errors->first()" />
    @endif

    <form wire:submit.prevent="confirmMarkAsPaid" class="space-y-4">

        <div>
            <x-admin.input-label>Payment date</x-admin.input-label>
            <x-admin.input-text
                model="payment_date"
                placeholder="dd-mm-yyyy"
                maxlength="10"
            />
            <x-admin.input-help>
                Enter the date in dd-mm-yyyy format
            </x-admin.input-help>
        </div>

        <x-slot:footer>
            <x-admin.button
                type="button"
                variant="secondary"
                wire:click="$set('showMarkPaidModal', false)"
            >
                Cancel
            </x-admin.button>

            <x-admin.button type="submit" variant="outline">
                <x-heroicon-o-check-circle class="w-4 h-4 mr-1.5" />
                Confirm & mark as paid
            </x-admin.button>

        </x-slot:footer>

    </form>

</x-admin.modal>
