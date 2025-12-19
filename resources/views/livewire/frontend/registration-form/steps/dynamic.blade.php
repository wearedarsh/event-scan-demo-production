<div class="space-y-4">
    <x-registration.form-step>
    <p>This is my dynamic content</p>

    @foreach($inputs as $input)
        <p>{{ $input->label }}</p>
    @endforeach
    </x-registration.form-step>
</div>
