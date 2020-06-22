<div>
    <form wire:submit.prevent="save">
        <x-form-bs name="number" label="Phone Number" required livewire/>

        <x-form-bs name="message" type="textarea" label="Message" livewire :options="['maxlength' => 100, 'rows' => 3]" helper="A link to this service is appended automatically. Leave blank to send the default message."/>

        <button type="submit" class="btn btn-primary">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" wire:loading wire:target="save"></span>
            <span wire:loading.class="d-none" wire:target="save">Send Request</span>
        </button>
    </form>
</div>
