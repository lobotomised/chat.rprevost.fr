<x-layout.guest>
    <div class="mx-auto w-full max-w-md px-4 py-8">
        <h1 class="text-2xl font-semibold">{{ __('Create an account') }}</h1>

        @if ($errors->any())
            <div class="mt-4 rounded-xl border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/register') }}" class="mt-6 space-y-4">
            @csrf

            <div>
                <x-auth.label for="username" :value="__('Username')" />
                <x-auth.input
                    id="username"
                    name="username"
                    type="text"
                    autocomplete="username"
                    required
                    autofocus
                    :value="old('username')"
                />
            </div>

            <div>
                <x-auth.label for="email" :value="__('Email')" />
                <x-auth.input
                    id="email"
                    name="email"
                    type="email"
                    autocomplete="email"
                    required
                    :value="old('email')"
                />
            </div>

            <div>
                <x-auth.label for="password" :value="__('Password')" />
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

            <x-auth.button>{{ __('Create account') }}</x-auth.button>

            <p class="text-center text-sm text-gray-700">
                {{ __('Already have an account?') }}
                <a href="{{ route('login') }}" class="font-medium text-indigo-700 hover:text-indigo-900">
                    {{ __('Connexion') }}
                </a>
            </p>
        </form>
    </div>
</x-layout.guest>
