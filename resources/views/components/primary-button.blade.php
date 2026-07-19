<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest shadow-md hover:shadow-lg hover:from-blue-500 hover:to-indigo-500 hover:-translate-y-0.5 active:translate-y-0 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transform transition-all duration-200 ease-in-out']) }}>
    {{ $slot }}
</button>
