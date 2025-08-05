<div>
    {{-- App Header --}}
    <div class="relative mb-10">
        {{-- Breadcrumbs --}}
        <div class="flex items-center justify-between">
            <div>
                <div class="mt-2">
                    <flux:breadcrumbs>
                        <flux:breadcrumbs.item :href="route('admin_dashboard')" wire:navigate>Home
                        </flux:breadcrumbs.item>
                        <flux:breadcrumbs.item icon="ellipsis-horizontal" />
                        <flux:breadcrumbs.item :href="route('buffer_view')" :accent="true" wire:navigate>
                            <span class="text-[var(--color-accent)]">Buffer View<span>
                        </flux:breadcrumbs.item>
                    </flux:breadcrumbs>
                </div>
                <flux:heading size="xl" level="1">Buffer View</flux:heading>
            </div>
        </div>
    </div>

    <div class="min-h-screen bg-zinc-900 text-white px-4 py-6">
        <!-- Header -->
        <header class="mb-6">
            <h1 class="text-2xl font-bold tracking-tight">💭 Brainstorm Board</h1>
            <p class="text-sm text-zinc-400">A space to jot down random ideas—no saving, just thinking.</p>
        </header>

        <!-- Idea Input -->
        <form wire:submit.prevent="addIdea" class="space-y-4">
            <div>
                <label for="newIdea" class="block text-sm text-zinc-300">Your Idea</label>
                <textarea id="newIdea" wire:model.defer="newIdea" rows="3" placeholder="What's on your mind?"
                    class="mt-1 block w-full rounded-md bg-zinc-800 border border-zinc-700 text-white placeholder-zinc-500 focus:ring-2 focus:ring-blue-500 focus:outline-none p-3 text-sm resize-none transition"></textarea>
            </div>
            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition">
                + Add Idea
            </button>
        </form>

        <!-- Ideas List -->
        <section class="mt-8">
            <h2 class="text-lg font-semibold mb-4">🧠 Ideas</h2>
            <ul class="space-y-3">
                @foreach ($ideas as $idea)
                    <li
                        class="bg-zinc-800 border border-zinc-700 rounded-lg p-4 text-sm shadow-sm hover:shadow-md transition">
                        {{ $idea }}
                    </li>
                @endforeach
            </ul>
        </section>
    </div>







</div>