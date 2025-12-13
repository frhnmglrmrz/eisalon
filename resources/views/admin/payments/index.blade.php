@extends('layouts.app')

@section('title', 'Manage Payments - Admin')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="mb-8">
        <h1 class="text-4xl font-bold gradient-text mb-2">Manage Payments</h1>
        <p class="text-gray-600">View and manage all payments</p>
    </div>

    <div class="glass-effect rounded-2xl p-6 shadow-lg">
        <form method="GET" class="mb-6 flex gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="px-4 py-2 rounded-xl border-2 border-gray-200">
            <select name="status" class="px-4 py-2 rounded-xl border-2 border-gray-200">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
            </select>
            <button type="submit" class="btn-primary text-white px-6 py-2 rounded-full">Filter</button>
        </form>

        @if($payments->isEmpty())
            <div class="text-center py-12">
                <i class="fas fa-money-bill-wave text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-400 mb-2">No payments yet</h3>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Invoice ID</th>
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Customer</th>
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Service</th>
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Amount</th>
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Status</th>
                            <th class="text-left py-4 px-4 text-gray-700 font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="py-4 px-4">{{ $payment->xendit_invoice_id }}</td>
                                <td class="py-4 px-4">{{ $payment->booking->user->name }}</td>
                                <td class="py-4 px-4">{{ $payment->booking->service->name }}</td>
                                <td class="py-4 px-4">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                <td class="py-4 px-4">
                                    @php
                                        $colors = ['pending' => 'yellow', 'paid' => 'green', 'expired' => 'gray', 'failed' => 'red'];
                                        $color = $colors[$payment->status] ?? 'gray';
                                    @endphp
                                    <span class="px-3 py-1 bg-{{ $color }}-100 text-{{ $color }}-700 rounded-full text-sm">{{ ucfirst($payment->status) }}</span>
                                </td>
                                <td class="py-4 px-4">
                                    <a href="{{ route('admin.payments.show', $payment) }}" class="text-blue-600"><i class="fas fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-6">{{ $payments->links() }}</div>
        @endif
    </div>
</div>
@endsection

