<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Application') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="/applications" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="topic">Topic</label>
                            <input id="topic" type="text" class="@error('topic') is-invalid @enderror" name="topic">
                            @error('topic')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="message">Message</label>
                            <textarea id="message" class="@error('message') is-invalid @enderror" name="message"></textarea>
                            @error('message')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="file">Attachment</label>
                            <input id="file" type="file" class="@error('file') is-invalid @enderror" name="file">
                            @error('file')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @error('created_at')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <x-button type="submit">
                            Submit
                        </x-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
