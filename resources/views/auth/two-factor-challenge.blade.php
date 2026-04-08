<x-layout.guest>
    <div class="mx-auto w-full max-w-md px-4 py-8">
        <h1 class="text-2xl font-semibold">{{ __('Two-factor authentication') }}</h1>

        <p class="mt-2 text-sm text-gray-700">
            {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
        </p>

        @if ($errors->any())
            <div class="mt-4 rounded-xl border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mt-6 rounded-xl border border-gray-200 bg-white p-4">
            <div class="flex gap-2">
                <button type="button" id="btn-code"
                        class="flex-1 rounded-lg bg-indigo-600 px-3 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                    {{ __('Use authentication code') }}
                </button>

                <button type="button" id="btn-recovery"
                        class="flex-1 rounded-lg bg-gray-100 px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-200">
                    {{ __('Use recovery code') }}
                </button>
            </div>

            <form method="POST" action="{{ url('/two-factor-challenge') }}" class="mt-4 space-y-4">
                @csrf

                <div id="wrap-code">
                    <x-auth.label for="code" :value="__('Authentication code')" />
                    <x-auth.input
                        id="code"
                        name="code"
                        type="text"
                        inputmode="numeric"
                        autocomplete="one-time-code"
                        placeholder="123456"
                        required
                    />
                    <p class="mt-1 text-xs text-gray-600">
                        {{ __('Enter the 6-digit code from your authenticator app.') }}
                    </p>
                </div>

                <div id="wrap-recovery" class="hidden">
                    <x-auth.label for="recovery_code" :value="__('Recovery code')" />
                    <x-auth.input
                        id="recovery_code"
                        name="recovery_code"
                        type="text"
                        autocomplete="one-time-code"
                        placeholder="xxxx-xxxx"
                    />
                    <p class="mt-1 text-xs text-gray-600">
                        {{ __('Use one of your recovery codes if you cannot access your authenticator app.') }}
                    </p>
                </div>

                <x-auth.button>{{ __('Confirm') }}</x-auth.button>
            </form>
        </div>

        <p class="mt-6 text-center text-sm text-gray-700">
            <a href="{{ route('login') }}" class="text-indigo-700 hover:underline">
                {{ __('Back to login') }}
            </a>
        </p>
    </div>

    <script>
        (function () {
            const btnCode = document.getElementById('btn-code');
            const btnRecovery = document.getElementById('btn-recovery');

            const wrapCode = document.getElementById('wrap-code');
            const wrapRecovery = document.getElementById('wrap-recovery');

            const inputCode = document.getElementById('code');
            const inputRecovery = document.getElementById('recovery_code');

            function setMode(mode) {
                const useCode = mode === 'code';

                wrapCode.classList.toggle('hidden', !useCode);
                wrapRecovery.classList.toggle('hidden', useCode);

                btnCode.classList.toggle('bg-indigo-600', useCode);
                btnCode.classList.toggle('text-white', useCode);
                btnCode.classList.toggle('bg-gray-100', !useCode);
                btnCode.classList.toggle('text-gray-900', !useCode);

                btnRecovery.classList.toggle('bg-indigo-600', !useCode);
                btnRecovery.classList.toggle('text-white', !useCode);
                btnRecovery.classList.toggle('bg-gray-100', useCode);
                btnRecovery.classList.toggle('text-gray-900', useCode);

                inputCode.required = useCode;
                if (useCode) {
                    inputRecovery.value = '';
                    inputCode.focus();
                } else {
                    inputCode.value = '';
                    inputRecovery.focus();
                }
            }

            btnCode.addEventListener('click', () => setMode('code'));
            btnRecovery.addEventListener('click', () => setMode('recovery'));

            setMode('code');
        })();
    </script>
</x-layout.guest>
