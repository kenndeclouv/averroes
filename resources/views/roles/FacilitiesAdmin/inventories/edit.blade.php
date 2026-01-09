@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Inventory Item</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('facilitiesadmin.inventories.update', $inventory) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label" for="item_code">Item Code</label>
                                <input type="text" class="form-control" id="item_code" name="item_code"
                                    value="{{ old('item_code', $inventory->item_code) }}" required />
                                @errorFeedback('item_code')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="name">Item Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $inventory->name) }}" required />
                                @errorFeedback('name')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="condition">Condition</label>
                                <select class="form-select" id="condition" name="condition" required>
                                    <option value="Good"
                                        {{ old('condition', $inventory->condition) == 'Good' ? 'selected' : '' }}>Good
                                    </option>
                                    <option value="Damaged"
                                        {{ old('condition', $inventory->condition) == 'Damaged' ? 'selected' : '' }}>Damaged
                                    </option>
                                    <option value="Lost"
                                        {{ old('condition', $inventory->condition) == 'Lost' ? 'selected' : '' }}>Lost
                                    </option>
                                </select>
                                @errorFeedback('condition')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="quantity">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity"
                                    value="{{ old('quantity', $inventory->quantity) }}" min="1" required />
                                @errorFeedback('quantity')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="room_id">Ruangan</label>
                                <select class="form-select select2" id="room_id" name="room_id" required>
                                    <option value="">Pilih Ruangan</option>
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}"
                                            {{ (old('room_id') ?? $inventory->room_id) == $room->id ? 'selected' : '' }}>
                                            {{ $room->name }} ({{ $room->code }})</option>
                                    @endforeach
                                </select>
                                @errorFeedback('room_id')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="location">Detail Lokasi (Opsional)</label>
                                <input type="text" class="form-control" id="location" name="location"
                                    value="{{ old('location', $inventory->location) }}" />
                                @errorFeedback('location')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="purchase_date">Purchase Date</label>
                                <input type="date" class="form-control" id="purchase_date" name="purchase_date"
                                    value="{{ old('purchase_date', $inventory->purchase_date->format('Y-m-d')) }}"
                                    required />
                                @errorFeedback('purchase_date')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $inventory->description) }}</textarea>
                                @errorFeedback('description')
                            </div>
                            <button type="submit" class="btn btn-primary">Update Item</button>
                            <a href="{{ route('facilitiesadmin.inventories.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
