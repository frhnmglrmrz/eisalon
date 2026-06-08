@extends('layouts.app')

@section('title', 'Add Booking Slot')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Add Booking Slot</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.slots.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date" required min="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="time" class="form-label">Time</label>
                        <input type="time" class="form-control" id="time" name="time" required>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Save Slot</button>
                <a href="{{ route('admin.slots.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
