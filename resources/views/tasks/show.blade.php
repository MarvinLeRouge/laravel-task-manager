<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">{{ $task->title }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded p-6">
                <div class="mb-4">
                    @if($task->category)
                        <span class="text-xs px-2 py-1 rounded-full text-white"
                            style="background-color: {{ $task->category->color }}">
                            {{ $task->category->name }}
                        </span>
                    @endif
                    <span class="ml-2 text-xs text-gray-500">{{ $task->status }} · {{ $task->priority }}</span>
                </div>

                @if($task->description)
                    <p class="text-gray-700 mb-4">{{ $task->description }}</p>
                @endif

                @if($task->due_date)
                    <p class="text-sm text-gray-500 mb-4">Échéance : {{ $task->due_date }}</p>
                @endif

                <div class="flex gap-2 mt-4">
                    <a href="{{ route('tasks.edit', $task) }}" class="bg-indigo-500 text-white px-4 py-2 rounded">Éditer</a>
                    <a href="{{ route('tasks.index') }}" class="text-gray-500 px-4 py-2">Retour</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>