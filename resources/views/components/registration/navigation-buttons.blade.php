<div class="flex flex-row gap-4 pt-6">
    <div class="flex-1">
        <x-registration.navigate-button action="prevStep">
            Previous
        </x-registration.navigate-button>
    </div>
    <div class="flex-1">
        <x-registration.navigate-button action="nextStep">
            Next
        </x-registration.navigate-button>
    </div>
</div>

<x-registration.navigate-cancel-link action="clearLocalStorageAndRedirect" />