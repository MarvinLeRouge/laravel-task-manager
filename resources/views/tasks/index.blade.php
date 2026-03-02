<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Tâches</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('tasks.create') }}" class="mb-4 inline-block bg-indigo-500 text-white px-4 py-2 rounded">
                Nouvelle tâche
            </a>

            <div class="bg-white shadow rounded p-6">
                @forelse($tasks as $task)
                    <div class="flex items-center justify-between py-2 border-b">
                        <div>
                            <span class="font-medium">{{ $task->title }}</span>
                            @if($task->category)
                                <span class="ml-2 text-xs px-2 py-1 rounded-full text-white"
                                    style="background-color: {{ $task->category->color }}">
                                    {{ $task->category->name }}
                                </span>
                            @endif
                            <span class="ml-2 text-xs text-gray-500">{{ $task->status }} · {{ $task->priority }}</span>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('tasks.show', $task) }}" class="text-gray-500">Voir</a>
                            <a href="{{ route('tasks.edit', $task) }}" class="text-indigo-500">Éditer</a>
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500">Supprimer</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">Aucune tâche pour l'instant.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>