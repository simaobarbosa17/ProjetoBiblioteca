<div class="card bg-base-100 shadow p-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
        <div class="md:col-span-1">
            <h2 class="text-xl font-semibold">{{ __('Eliminar Conta') }}</h2>
            <p class="mt-1 text-sm ">
                {{ __('Eliminar permanentemente a sua conta.') }}
            </p>
        </div>

        <div class="md:col-span-2">
            <p class="text-sm  mb-4">
                {{ __('Depois de eliminar a sua conta, todos os recursos e dados serão apagados de forma permanente. Por favor, descarregue quaisquer dados que deseje manter antes de prosseguir.') }}
            </p>

            <div class="flex justify-end">
                <button class="btn btn-error text-white" wire:click="confirmUserDeletion" wire:loading.attr="disabled">
                    {{ __('Eliminar Conta') }}
                </button>
            </div>
        </div>
    </div>

    <x-dialog-modal wire:model.live="confirmingUserDeletion">
        <x-slot name="title">
            {{ __('Eliminar Conta') }}
        </x-slot>

        <x-slot name="content">
            <p class="text-sm">
                {{ __('Tem a certeza de que deseja eliminar a sua conta? Esta ação é irreversível. Todos os dados serão permanentemente apagados. Por favor, introduza a sua palavra-passe para confirmar.') }}
            </p>

            <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                <input type="password"
                       class="input input-bordered w-full"
                       autocomplete="current-password"
                       placeholder="{{ __('Palavra-passe') }}"
                       x-ref="password"
                       wire:model="password"
                       wire:keydown.enter="deleteUser" />

                <x-input-error for="password" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <button class="btn btn-primary " wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </button>

            <button class="btn btn-error ms-3 text-white" wire:click="deleteUser" wire:loading.attr="disabled">
                {{ __('Eliminar Conta') }}
            </button>
        </x-slot>
    </x-dialog-modal>
</div>