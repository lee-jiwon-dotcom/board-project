<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- 환영 메시지 --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-2">
                        안녕하세요, {{ auth()->user()->name }}님! 👋
                    </h3>
                    <p class="text-gray-600">
                        오늘도 좋은 하루 보내세요!
                    </p>
                </div>
            </div>

            {{-- 빠른 링크 카드 --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- 게시판 카드 --}}
                <a href="{{ route('posts.index') }}" 
                   class="block bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="text-4xl mr-4">📝</div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">
                                    게시판
                                </h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    게시글을 보고 작성해보세요
                                </p>
                            </div>
                            <div class="ml-auto text-gray-400">
                                →
                            </div>
                        </div>
                    </div>
                </a>

                {{-- 글쓰기 카드 --}}
                <a href="{{ route('posts.create') }}" 
                   class="block bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="text-4xl mr-4">✏️</div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">
                                    글쓰기
                                </h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    새로운 게시글을 작성하세요
                                </p>
                            </div>
                            <div class="ml-auto text-gray-400">
                                →
                            </div>
                        </div>
                    </div>
                </a>

            </div>

            {{-- 통계 카드 (선택) --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">📊 나의 활동</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-indigo-50 rounded-lg p-4">
                            <p class="text-sm text-indigo-600 font-medium">내가 쓴 게시글</p>
                            <p class="text-3xl font-bold text-indigo-900 mt-2">
                                {{ auth()->user()->posts->count() }}개
                            </p>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4">
                            <p class="text-sm text-green-600 font-medium">내가 쓴 댓글</p>
                            <p class="text-3xl font-bold text-green-900 mt-2">
                                {{ auth()->user()->comments->count() }}개
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>