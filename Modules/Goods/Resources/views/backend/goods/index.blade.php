@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

{{-- @section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item route='{{route("backend.$module_name.index")}}' icon='{{ $module_icon }}' >
        {{ __($module_title) }}
    </x-backend-breadcrumb-item>
    <x-backend-breadcrumb-item type="active">{{ __($module_action) }}</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection --}}

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
            @can('add_'.$module_name)
            <div class="col-4">
                <div class="float-end">
                    <x-buttons.create route='{{ route("backend.$module_name.create") }}' title="{{__('Create')}} {{ ucwords(Str::singular($module_name)) }}"/>
                </div>
            </div>
            @endcan
        </div>

        <div class="row mt-4">
            <div class="col">
                <table class="table table-hover table-responsive-sm">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>SKU</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Cost Price</th>
                            <th>Min Stock</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($$module_name as $item)
                        <tr>
                            <td>
                                <strong>{{ $item->name }}</strong>
                            </td>
                            <td>{{ $item->sku }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price, 2) }}</td>
                            <td>{{ number_format($item->cost_price, 2) }}</td>
                            <td>{{ $item->min_stock }}</td>
                            <td class="text-end">
                                @can('edit_'.$module_name)
                                <a href='{{ route("backend.$module_name.edit", $item) }}' class="btn btn-sm btn-primary mt-1" data-toggle="tooltip" title="Edit {{ Str::singular($module_name) }}"><i class="fas fa-wrench"></i></a>
                                @endcan
                                @can('view_'.$module_name)
                                <a href='{{ route("backend.$module_name.show", $item) }}' class="btn btn-sm btn-success mt-1" data-toggle="tooltip" title="Show {{ Str::singular($module_name) }}"><i class="fas fa-tv"></i></a>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-7">
                <div class="float-left">
                    Total {{ $$module_name->total() }} {{ __($module_name) }}
                </div>
            </div>
            <div class="col-5">
                <div class="float-end">
                    {!! $$module_name->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
