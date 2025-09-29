<x-layout>

    <div class="space-y-10">
        <section class="text-center pt-6">
            <h1 class="font-bold text-4xl">Your Notifications</h1>
            <p class="text-gray-600 mt-2">Stay updated with new job posts and alerts</p>
        </section>

        <section class="pt-10 max-w-2xl mx-auto">
            <x-section-heading>Recent Notifications</x-section-heading>

            <div class="mt-6 space-y-4">
                @forelse($notifications as $notification)
                    <div class="p-4 rounded-2xl shadow-sm border
                        {{ is_null($notification->read_at) ? 'bg-yellow-50' : 'bg-white' }}">
                        
                        <h2 class="text-lg font-semibold">
                            {{ $notification->data['title'] }}
                        </h2>
                        
                        <p class="text-gray-700 mt-1">
                            {{ $notification->data['message'] }}
                        </p>

                        <div class="flex items-center gap-4 mt-3">
                            <a href="#" 
                               class="text-blue-600 hover:underline">
                                View Job
                            </a>

                            @if (is_null($notification->read_at))
                                <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">
                                        Mark as read
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500">No notifications yet.</p>
                @endforelse
            </div>

            @if (auth()->user()->unreadNotifications->count())
                <form action="{{ route('notifications.readAll') }}" method="POST" class="text-center mt-6">
                    @csrf
                    @method('PATCH')
                    <button class="px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700">
                        Mark All as Read
                    </button>
                </form>
            @endif
        </section>
    </div>
</x-layout>
