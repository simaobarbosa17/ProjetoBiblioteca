<form wire:submit.prevent="updatePassword" class="card bg-base-100 shadow p-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
        <div class="md:col-span-1">
            <h2 class="text-xl font-semibold">{{ __('Atualizar Palavra-passe') }}</h2>
            <p class="mt-1 text-sm">
                {{ __('Certifique-se de que a sua conta utiliza uma palavra-passe longa e aleatória para se manter segura.') }}
            </p>
        </div>

        <div class="md:col-span-2">
            <div class="grid grid-cols-6 gap-4">
                <div class="col-span-6 sm:col-span-4">
                    <label for="current_password" class="label">
                        <span class="label-text">{{ __('Palavra-passe Atual') }}</span>
                    </label>
                    <input id="current_password" type="password" class="input input-bordered w-full" wire:model="state.current_password" autocomplete="current-password" />
                    @error('current_password')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>


                <div class="col-span-6 sm:col-span-4">
                    <label for="password" class="label">
                        <span class="label-text">{{ __('Nova Palavra-passe') }}</span>
                    </label>
                    <input id="password" type="password" class="input input-bordered w-full" wire:model="state.password" autocomplete="new-password" />
                    @error('password')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <label for="password_confirmation" class="label">
                        <span class="label-text">{{ __('Confirmar Palavra-passe') }}</span>
                    </label>
                    <input id="password_confirmation" type="password" class="input input-bordered w-full" wire:model="state.password_confirmation" autocomplete="new-password" />
                    @error('password_confirmation')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end items-center gap-3">
                <span class="text-green-600 text-sm">
                    <x-action-message on="saved">{{ __('Atualizado.') }}</x-action-message>
                </span>

                <button class="btn btn-primary" wire:loading.attr="disabled">
                    {{ __('Salvar') }}
                </button>
            </div>
        </div>
    </div>
</form>
