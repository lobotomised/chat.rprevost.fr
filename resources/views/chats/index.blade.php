<x-layout.app>
    <x-slot name="sidebar">
        @include('chats.partials.sidebar', [
            'conversations' => $conversations,
            'activeConversation' => null,
        ])
    </x-slot>

    <div class="flex h-full items-center justify-center text-gray-500">
        <p>{{ __('Select a conversation to start chatting.') }}</p>
    </div>
</x-layout.app>
