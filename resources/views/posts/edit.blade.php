<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            写真を編集
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- タイトル --}}
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                タイトル <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="title"
                                   id="title"
                                   value="{{ old('title', $post->title) }}"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 内容 --}}
                        <div class="mb-6">
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                                内容 <span class="text-red-500">*</span>
                            </label>
                            <textarea name="content"
                                      id="content"
                                      rows="12"
                                      class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('content', $post->content) }}</textarea>
                            @error('content')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 現在の写真 --}}
                        @if($post->attachments->count() > 0)
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    現在の写真
                                </label>
                                <div class="flex flex-wrap gap-3">
                                    @foreach($post->attachments as $attachment)
                                        <img src="{{ asset('storage/' . $attachment->path) }}"
                                             alt="{{ $attachment->original_name }}"
                                             class="h-24 w-24 object-cover rounded-md border border-gray-200">
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- 写真を追加 --}}
                        <div class="mb-6">
                            <label for="images" class="block text-sm font-medium text-gray-700 mb-2">
                                写真を追加
                            </label>
                            <input type="file" name="images[]" id="images" multiple accept="image/*"
                                   class="block w-full text-sm text-gray-700">
                            @error('images.*')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- ボタン --}}
                        <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                            <a href="{{ route('posts.show', $post) }}"
                               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none transition">
                                キャンセル
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none transition">
                                更新する
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>