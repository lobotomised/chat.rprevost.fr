<x-layout.guest>
    <div class="mx-auto w-full max-w-md px-4 py-8">
        <h1 class="text-2xl font-semibold">{{ __('Reset password') }}</h1>

        @if ($errors->any())
            <div class="mt-4 rounded-xl border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="mt-6 space-y-4">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <x-auth.label for="email" :value="__('Email')" />
                <x-auth.input
                    id="email"
                    name="email"
                    type="email"
                    autocomplete="email"
                    required
                    :value="old('email', $email ?? '')"
                />
            </div>

            <div>
                <x-auth.label for="password" :value="__('New password')" />
                <x-auth.input
                    id="password"
                    name="password"
                    type="password"
                    autocomplete="new-password"
                    required
                />
            </div>

            <div>
                <x-auth.label for="password_confirmation" :value="__('Confirm password')" />
                <x-auth.input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    autocomplete="new-password"
                    required
                />
            </div>

            <x-auth.button>{{ __('Update') }}</x-auth.button>>
        </form>
    </div>
</x-layout.guest>
