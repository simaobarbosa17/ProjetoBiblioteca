<form wire:submit.prevent="updateProfileInformation" class="card bg-base-100 shadow p-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
        <div class="md:col-span-1">
            <h2 class="text-xl font-semibold">{{ __('Informação do Perfil') }}</h2>
            <p class="mt-1 text-sm">
                {{ __('Atualize as informações do perfil e o endereço de e-mail da sua conta.') }}
            </p>
        </div>

        <div class="md:col-span-2">
            <div class="grid grid-cols-6 gap-4">
                <div class="col-span-6 sm:col-span-4">
                    <label for="name" class="label">
                        <span class="label-text">{{ __('Name') }}</span>
                    </label>
                    <input id="name" type="text" class="input input-bordered w-full" wire:model="state.name" required autocomplete="name" />
                    @error('name')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <label for="email" class="label">
                        <span class="label-text">{{ __('Email') }}</span>
                    </label>
                    <input id="email" type="email" class="input input-bordered w-full" wire:model="state.email" required autocomplete="username" />
                    @error('email')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror

                    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                        <p class="text-sm mt-2">
                            {{ __('Your email address is unverified.') }}
                            <button type="button" class="link link-primary ml-1" wire:click.prevent="sendEmailVerification">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if ($this->verificationLinkSent)
                            <p class="mt-2 text-sm text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    @endif
                </div>
            </div>

           
            <div class="mt-6 flex justify-end items-center gap-3">
                <div wire:loading wire:target="photo" class="loading loading-spinner loading-sm"></div>
                <span class="text-green-600 text-sm" wire:loading.remove wire:target="photo" wire:poll.visible>
                    <x-action-message on="saved">{{ __('Atualizado.') }}</x-action-message>
                </span>

                <button class="btn btn-primary" wire:loading.attr="disabled" wire:target="photo">
                    {{ __('Salvar') }}
                </button>
            </div>
        </div>
    </div>
</form>