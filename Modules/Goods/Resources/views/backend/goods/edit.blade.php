@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item route='{{route("backend.$module_name.index")}}' icon='{{ $module_icon }}' >
        {{ __($module_title) }}
    </x-backend-breadcrumb-item>
    <x-backend-breadcrumb-item type="active">{{ __($module_action) }}</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title mb-0">
                    <i class="{{ $module_icon }}"></i> {{ __($module_title) }} <small class="text-muted">{{ __($module_action) }}</small>
                </h4>
                <div class="small text-muted">
                    @lang(":module_name Management Dashboard", ['module_name'=>Str::title($module_name)])
                </div>
            </div>
        </div>

        <hr>

        <div class="row mt-4">
            <div class="col">
                <form method="POST" action="{{ route("backend.$module_name.update", $$module_name_singular) }}" class="form-horizontal">
                    @csrf
                    @method('PATCH')

                    <div class="row mb-3">
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Name *</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') ?? $$module_name_singular->name }}" required>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="sku" class="form-label">SKU *</label>
                                <input type="text" class="form-control" name="sku" id="sku" value="{{ old('sku') ?? $$module_name_singular->sku }}" required>
                                @error('sku')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-sm-4">
                            <div class="form-group">
                                <label for="quantity" class="form-label">Quantity *</label>
                                <input type="number" min="0" class="form-control" name="quantity" id="quantity" value="{{ old('quantity') ?? $$module_name_singular->quantity }}" required>
                                @error('quantity')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="form-group">
                                <label for="price" class="form-label">Price *</label>
                                <input type="number" min="0" step="0.01" class="form-control" name="price" id="price" value="{{ old('price') ?? $$module_name_singular->price }}" required>
                                @error('price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="form-group">
                                <label for="cost_price" class="form-label">Cost Price *</label>
                                <input type="number" min="0" step="0.01" class="form-control" name="cost_price" id="cost_price" value="{{ old('cost_price') ?? $$module_name_singular->cost_price }}" required>
                                @error('cost_price')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="min_stock" class="form-label">Minimum Stock *</label>
                                <input type="number" min="0" class="form-control" name="min_stock" id="min_stock" value="{{ old('min_stock') ?? $$module_name_singular->min_stock }}" required>
                                @error('min_stock')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-group">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="description" rows="3">{{ old('description') ?? $$module_name_singular->description }}</textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <x-buttons.cancel />
                            </div>
                        </div>
                        <div class="col-6 text-end">
                            <div class="form-group">
                                <x-buttons.save title="{{__('Update')}} {{ ucwords(Str::singular(value: $module_name)) }}"/>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
