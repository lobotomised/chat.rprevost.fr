<x-layout.guest>
    <div class="mx-auto w-full max-w-md px-4 py-8">
        <h1 class="text-2xl font-semibold">{{ __('Forgot password') }}</h1>

        <p class="mt-2 text-sm text-gray-700">
            {{ __('Enter your email. You will receive a password reset link.') }}
        </p>

        @if (session('status'))
            <div class="mt-4 rounded-xl border border-green-200 bg-green-50 p-3 text-sm text-green-800">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mt-4 rounded-xl border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-4">
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

            <x-auth.button>{{ __('Send link') }}</x-auth.button>

            <p class="text-center text-sm text-gray-700">
                <a href="{{ route('login') }}">
                    {{ __('Back to login') }}
                </a>
            </p>
        </form>
    </div>
</x-layout.guest>
