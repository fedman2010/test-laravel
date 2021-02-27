<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3>Topic:</h3>
                    <p>{{ $application->topic }}</p>
                    <h3>Message:</h3>
                    <p>{{ $application->message }}</p>
                    <h3>File:</h3>
                    <p>{{ $application->file }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


