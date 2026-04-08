<div class="flex h-full flex-col bg-white">

    {{-- Header --}}
    <div class="border-b px-6 py-4">
        <h2 class="text-lg font-semibold">
            {{ __('Conversation') }}
        </h2>
    </div>

    {{-- Messages --}}
    <div class="flex-1 space-y-4 overflow-y-auto px-6 py-4">
        @foreach ($conversation->messages as $message)
            <div class="
                max-w-xl rounded-lg px-4 py-2
                {{ $message->sender_id === auth()->id() ? 'ml-auto bg-indigo-600 text-white' : 'bg-gray-100' }}
            ">
                <div class="text-sm">
                    {{ $message->body }}
                </div>
            </div>
        @endforeach
    </div>

    {{-- Composer (plus tard) --}}
    <div class="border-t px-6 py-4">
        <p class="text-sm text-gray-400">
            {{ __('Message composer will go here') }}
        </p>
    </div>

</div>
