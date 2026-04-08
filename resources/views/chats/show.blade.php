<x-layout.app>
    <x-slot name="sidebar">
        @include('chats.partials.sidebar', [
            'conversations' => $conversations,
            'activeConversation' => $activeConversation,
        ])
    </x-slot>

    @include('chats.partials.conversation', [
        'conversation' => $activeConversation,
    ])
</x-layout.app>
