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
                            <p>ID: {{ $application->id }}</p>
                            <p>Topic: {{ $application->topic }}</p>
                            <p>Message: {{ $application->message }}</p>
                            @if($user->isManager())
                                <p>Name: {{ $application->user->name }}</p>
                                <p>Email: {{ $application->user->email }}</p>
                            @endif
                            <p>Attachment: {{ $application->file }}</p>
                            <p>Created: {{ $application->created_at }}</p>
                            @if($user->isManager())
                                @if($application->responded_at !== null)
                                    <p>[responded]</p>
                                @else
                                    <p>[not responded]</p>
                                @endif
                                <a style="color: blue;text-decoration: underline;" href="/applications/{{ $application->id }}">VIEW</a>
                            @endif
                        </div>
                        <br>
                        <br>
                    @endforeach
                    @if($applications->count() === 0)
                        There are no applications yet.
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
