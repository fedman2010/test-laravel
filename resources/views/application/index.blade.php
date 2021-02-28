<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Applications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @foreach($applications as $key => $application)
                        <div>
                            <h1>Application#{{ $key }}</h1>
                            <h3>Topic: {{ $application->topic }}</h3>
                            <p>Message: {{ $application->message }}</p>
                            <p>Attachment: {{ $application->file }}</p>
                            <p>Created: {{ $application->created_at }}</p>
                        </div>
                        <br>
                        <br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
