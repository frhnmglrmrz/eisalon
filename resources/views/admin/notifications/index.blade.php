@extends('layouts.app')

@section('title', 'Notifications - Admin')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="mb-8">
        <h1 class="text-4xl font-bold gradient-text mb-2">System Notifications</h1>
        <p class="text-gray-600">View all system notifications</p>
    </div>

    <div class="glass-effect rounded-2xl p-6 shadow-lg">
        <form method="GET" class="mb-6 flex gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="px-4 py-2 rounded-xl border-2 border-gray-200">
            <select name="type" class="px-4 py-2 rounded-xl border-2 border-gray-200">
                <option value="">All Types</option>
                <option value="App\Notifications\PaymentConfirmed" {{ request('type') == 'App\Notifications\PaymentConfirmed' ? 'selected' : '' }}>Payment Confirmed</option>
            </select>
            <select name="read" class="px-4 py-2 rounded-xl border-2 border-gray-200">
                <option value="">All</option>
                <option value="read" {{ request('read') == 'read' ? 'selected' : '' }}>Read</option>
                <option value="unread" {{ request('read') == 'unread' ? 'selected' : '' }}>Unread</option>
            </select>
            <button type="submit" class="btn-primary text-white px-6 py-2 rounded-full">Filter</button>
        </form>

        @if($notifications->isEmpty())
            <div class="text-center py-12">
                <i class="fas fa-bell-slash text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-400 mb-2">No notifications yet</h3>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Type</th>
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Data</th>
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Read At</th>
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notifications as $notification)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="py-4 px-4">{{ class_basename($notification->type) }}</td>
                                <td class="py-4 px-4">
                                    @if(isset($notification->data['message']))
                                        {{ $notification->data['message'] }}
                                    @else
                                        {{ json_encode($notification->data) }}
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    @if($notification->read_at)
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">{{ \Carbon\Carbon::parse($notification->read_at)->format('d M Y H:i') }}</span>
                                    @else
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm">Unread</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4">{{ \Carbon\Carbon::parse($notification->created_at)->format('d M Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-6">{{ $notifications->links() }}</div>
        @endif
    </div>
</div>
@endsection

