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
            <div class="col-4">
                <div class="float-end">
                    @can('edit_'.$module_name)
                    <a href="{{ route("backend.$module_name.edit", $$module_name_singular) }}" class="btn btn-primary mt-1">
                        <i class="fas fa-wrench"></i> Edit
                    </a>
                    @endcan
                </div>
            </div>
        </div>

        <hr>

        <div class="row mt-4">
            <div class="col">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <h5>Basic Information</h5>
                                <div class="mb-3">
                                    <strong>Name:</strong> {{ $$module_name_singular->name }}
                                </div>
                                <div class="mb-3">
                                    <strong>SKU:</strong> {{ $$module_name_singular->sku }}
                                </div>
                                <div class="mb-3">
                                    <strong>Description:</strong> {{ $$module_name_singular->description ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <h5>Inventory Details</h5>
                                <div class="mb-3">
                                    <strong>Quantity:</strong> {{ $$module_name_singular->quantity }}
                                </div>
                                <div class="mb-3">
                                    <strong>Price:</strong> {{ number_format($$module_name_singular->price, 2) }}
                                </div>
                                <div class="mb-3">
                                    <strong>Cost Price:</strong> {{ number_format($$module_name_singular->cost_price, 2) }}
                                </div>
                                <div class="mb-3">
                                    <strong>Minimum Stock:</strong> {{ $$module_name_singular->min_stock }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="inventory-tab" data-bs-toggle="tab" data-bs-target="#inventory" type="button" role="tab" aria-controls="inventory" aria-selected="true">
                            Inventory Moves
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="adjustments-tab" data-bs-toggle="tab" data-bs-target="#adjustments" type="button" role="tab" aria-controls="adjustments" aria-selected="false">
                            Adjustments
                        </button>
                    </li>
                </ul>

                @can("edit_goods")
                    <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="inventory" role="tabpanel" aria-labelledby="inventory-tab">
                        <div class="mb-3">
                            <a href="{{ route('backend.goods.createInventoryMove', $$module_name_singular->id) }}" class="btn btn-success">
                                <i class="fas fa-plus"></i> Add Inventory Move
                            </a>
                        </div>
                        <div class="table-responsive mt-3">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Quantity</th>
                                        <th>User</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inventory_moves as $move)
                                    <tr>
                                        <td>{{ $move->date->format('Y-m-d H:i') }}</td>
                                        <td>{{ ucfirst($move->type) }}</td>
                                        <td>{{ $move->quantity }}</td>
                                        <td>{{ $move->user->name }}</td>
                                        <td>{{ $move->notes ?? 'N/A' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $inventory_moves->render() !!}
                        </div>
                    </div>

                    <div class="tab-pane fade" id="adjustments" role="tabpanel" aria-labelledby="adjustments-tab">
                        <div class="mb-3">
                            <a href="{{ route('backend.goods.createAdjustment', $$module_name_singular->id) }}" class="btn btn-success">
                                <i class="fas fa-plus"></i> Add Adjustment
                            </a>
                        </div>
                        <div class="table-responsive mt-3">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Quantity</th>
                                        <th>User</th>
                                        <th>Reason</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($adjustments as $adjustment)
                                    <tr>
                                        <td>{{ $adjustment->date->format('Y-m-d H:i') }}</td>
                                        <td>{{ $adjustment->quantity }}</td>
                                        <td>{{ $adjustment->user->name }}</td>
                                        <td>{{ $adjustment->reason }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $adjustments->render() !!}
                        </div>
                    </div>
                </div>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
