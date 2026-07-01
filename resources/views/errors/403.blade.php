<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            アクセス拒否
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-12 text-center text-gray-900">

                    <div class="text-9xl mb-4">🚫</div>

                    <h1 class="text-4xl font-bold text-gray-900 mb-4">
                        403
                    </h1>

                    <p class="text-xl text-gray-700 mb-2">
                        アクセス権限がありません
                    </p>

                    <p class="text-sm text-gray-500 mb-8">
                        {{ $exception->getMessage() ?: 'このページにアクセスする権限がありません。' }}
                    </p>

                    <a href="{{ url('/') }}"
                       class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none transition">
                        ← ホームに戻る
                    </a>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>