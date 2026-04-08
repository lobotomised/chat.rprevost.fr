<div class="h-full overflow-y-auto bg-white">

    {{-- Header --}}
    <div class="border-b border-gray-200 px-4 py-3">
        <h2 class="text-lg font-semibold text-gray-900">
            {{ __('Chats') }}
        </h2>
    </div>

    {{-- Conversations list --}}
    <ul class="divide-y divide-gray-200">
        @forelse ($conversations as $conversation)
            @php
                $isActive = $activeConversation && $activeConversation->id === $conversation->id;
                $otherUser = $conversation->direct
                    ? $conversation->direct->otherUser(auth()->id())
                    : null;
            @endphp

            <li>
                <a
                    href="{{ route('chats.show', $conversation) }}"
                    class="block px-4 py-3 transition
                           {{ $isActive ? 'bg-indigo-100' : 'hover:bg-gray-50' }}"
                >
                    {{-- name --}}
                    <div class="text-sm font-medium text-gray-900 truncate">
                        {{ $otherUser?->name ?? __('Chat') }}
                    </div>

                    {{-- Last message --}}
                    <div class="mt-1 text-sm text-gray-500 truncate">
                        @if($conversation->lastMessage === null)
                            {{ __('No messages yet') }}
                        @elseif($conversation->lastMessage->type !== 'text')
                            {{ __('Sent a media') }}
                        @else
                            {{ $conversation->lastMessage->body }}
                        @endif
                    </div>
                </a>
            </li>
        @empty
            <li>
                <div class="px-4 py-6 text-sm text-gray-500">
                    {{ __('No conversations yet') }}
                </div>
            </li>
        @endforelse
    </ul>

</div>
