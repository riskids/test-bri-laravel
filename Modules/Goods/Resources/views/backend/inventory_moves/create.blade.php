@extends('backend.layouts.app')

@section('title') Create Inventory Move @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item route='{{route("backend.goods.index")}}' icon='fa-solid fa-boxes-stacked'>
        Goods
    </x-backend-breadcrumb-item>
    <x-backend-breadcrumb-item route='{{route("backend.goods.show", $good->id)}}' icon='fa-solid fa-box'>
        {{ $good->name }}
    </x-backend-breadcrumb-item>
    <x-backend-breadcrumb-item type="active">Create Inventory Move</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title mb-0">
                    <i class="fa-solid fa-boxes-stacked"></i> Goods <small class="text-muted">Create Inventory Move</small>
                </h4>
                <div class="small text-muted">
                    Inventory Move Management
                </div>
            </div>
        </div>

        <hr>

        <div class="row mt-4">
            <div class="col">
                <form action="{{ route('backend.goods.storeInventoryMove', $good->id) }}" method="POST">
                    @csrf

                    <div class="form-group row">
                        <label for="type" class="col-md-2 col-form-label">Type</label>
                        <div class="col-md-10">
                            <select name="type" id="type" class="form-control" required>
                                <option value="in">In</option>
                                <option value="out">Out</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="quantity" class="col-md-2 col-form-label">Quantity</label>
                        <div class="col-md-10">
                            <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="date" class="col-md-2 col-form-label">Date</label>
                        <div class="col-md-10">
                            <input type="datetime-local" name="date" id="date" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="notes" class="col-md-2 col-form-label">Notes</label>
                        <div class="col-md-10">
                            <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-2"></div>
                        <div class="col-md-10">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save
                            </button>
                            <a href="{{ route('backend.goods.show', $good->id) }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
