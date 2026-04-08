<button {{ $attributes->merge([
    'type' => 'button',
    'class' => "w-full rounded-xl bg-indigo-600 px-4 py-2 font-medium text-black shadow-sm hover:bg-indigo-700"
]) }}>{{ $slot }}</button>
