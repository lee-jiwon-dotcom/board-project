<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- 歓迎メッセージ --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-2">
                        こんにちは、{{ auth()->user()->name }}さん！ 👋
                    </h3>
                    <p class="text-gray-600">
                        今日も良い一日をお過ごしください！
                    </p>
                </div>
            </div>

            {{-- クイックリンクカード --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- ギャラリーカード --}}
                <a href="{{ route('posts.index') }}"
                   class="block bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="text-4xl mr-4">📝</div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">
                                    ギャラリー
                                </h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    写真を見て投稿してみましょう
                                </p>
                            </div>
                            <div class="ml-auto text-gray-400">
                                →
                            </div>
                        </div>
                    </div>
                </a>

                {{-- 投稿カード --}}
                <a href="{{ route('posts.create') }}"
                   class="block bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="text-4xl mr-4">✏️</div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">
                                    投稿する
                                </h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    新しい写真を投稿しましょう
                                </p>
                            </div>
                            <div class="ml-auto text-gray-400">
                                →
                            </div>
                        </div>
                    </div>
                </a>

            </div>

            {{-- 統計カード（任意） --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">📊 私のアクティビティ</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-indigo-50 rounded-lg p-4">
                            <p class="text-sm text-indigo-600 font-medium">投稿した写真</p>
                            <p class="text-3xl font-bold text-indigo-900 mt-2">
                                {{ auth()->user()->posts->count() }}件
                            </p>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4">
                            <p class="text-sm text-green-600 font-medium">書いたコメント</p>
                            <p class="text-3xl font-bold text-green-900 mt-2">
                                {{ auth()->user()->comments->count() }}件
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>