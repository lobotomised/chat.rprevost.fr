<x-layout.guest>
    <div class="mx-auto w-full max-w-md px-4 py-8">
        <h1 class="text-2xl font-semibold">{{ __('Login') }}</h1>

        @if ($errors->any())
            <div class="mt-4 rounded-xl border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @env('local')
            <div class="flex justify-between mt-8">
                <x-login-link key="1" label="Connexion en admin" guard="web"/>
            </div>
        @endenv

        <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
            @csrf

            <div>
                <x-auth.label for="email" :value="__('Email')" />
                <x-auth.input
                    id="email"
                    name="email"
                    type="email"
                    autocomplete="email"
                    required
                    autofocus
                    :value="old('email')"
                />
            </div>

            <div>
                <x-auth.label for="password" :value="__('Password')" />
                <x-auth.input
                    id="password"
                    name="password"
                    type="password"
                    autocomplete="current-password"
                    required
                />
            </div>

            <div class="flex items-center justify-between">
                <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    {{ __('Remember me') }}
                </label>

                <a href="{{ route('password.request') }}" class="text-sm text-indigo-700 hover:underline">
                    {{ __('Forgot password?') }}
                </a>
            </div>

            <x-auth.button>{{ __('Sign in') }}</x-auth.button>

            <p class="text-center text-sm text-gray-700">
                {{ __('No account?') }}
                <a href="{{ route('register') }}" class="text-indigo-700 hover:underline">
                    {{ __('Create an account') }}
                </a>
            </p>
        </form>
    </div>
</x-layout.guest>
