<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Nouvelle tâche</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded p-6">
                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Titre</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                            class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                        @error('title') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" rows="3"
                            class="mt-1 block w-full rounded border-gray-300 shadow-sm">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Catégorie</label>
                        <select name="category_id" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                            <option value="">-- Aucune --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Statut</label>
                        <select name="status" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                            <option value="todo" {{ old('status') == 'todo' ? 'selected' : '' }}>À faire</option>
                            <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>En cours</option>
                            <option value="done" {{ old('status') == 'done' ? 'selected' : '' }}>Terminé</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Priorité</label>
                        <select name="priority" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Basse</option>
                            <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>Moyenne</option>
                            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Haute</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Date d'échéance</label>
                        <input type="date" name="due_date" value="{{ old('due_date') }}"
                            class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded">Créer</button>
                        <a href="{{ route('tasks.index') }}" class="text-gray-500 px-4 py-2">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>