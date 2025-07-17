<?php

namespace Modules\Goods\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Modules\Goods\Models\Good;
use App\Http\Controllers\Controller;

class GoodsController extends Controller
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Goods';

        // module name
        $this->module_name = 'goods';

        // directory path of the module
        $this->module_path = 'goods::goods.backend';

        // module icon
        $this->module_icon = 'fa-solid fa-boxes-stacked';

        // module model name, path
        $this->module_model = Good::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        // Try to get from Redis cache first
        $cache_key = 'goods:list:' . request('page', 1);
        $cached_goods = Redis::get($cache_key);
        
        if ($cached_goods) {
            $$module_name = unserialize($cached_goods);
        } else {
            // If not in cache, get from database and cache it
            $$module_name = $module_model::paginate();
            Redis::setex($cache_key, 3600, serialize($$module_name)); // Cache for 1 hour
        }

        logUserAccess($module_title.' '.$module_action);

        return view(
            "goods::goods.index",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', "{$module_name}")
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Create';

        logUserAccess($module_title.' '.$module_action);

        return view(
            "goods::goods.create",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular')
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Edit';

        // Try to get from Redis cache first
        $cache_key = "goods:{$id}";
        $cached_good = Redis::get($cache_key);
        
        if ($cached_good) {
            $$module_name_singular = unserialize($cached_good);
        } else {
            // If not in cache, get from database and cache it
            $$module_name_singular = $module_model::findOrFail($id);
            Redis::setex($cache_key, 3600, serialize($$module_name_singular)); // Cache for 1 hour
        }

        logUserAccess($module_title.' '.$module_action.' | Id: '.$$module_name_singular->id);

        return view(
            "goods::goods.edit",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', "{$module_name_singular}")
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Store';

        $validated_request = $request->validate([
            'name' => 'required|max:191',
            'sku' => 'required|max:191|unique:goods,sku',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'required|numeric|min:0',
            'min_stock' => 'required|integer|min:0',
            'description' => 'nullable'
        ]);

        $$module_name_singular = $module_model::create($request->all());

        // Store in Redis and invalidate list cache
        Redis::setex("goods:{$$module_name_singular->id}", 3600, serialize($$module_name_singular));
        
        // Clear list cache to ensure fresh data on next request
        $pattern = 'goods:list:*';
        $keys = Redis::keys($pattern);
        if (!empty($keys)) {
            Redis::del($keys);
        }

        flash("New '".Str::singular($module_title)."' Added")->success()->important();

        logUserAccess($module_title.' '.$module_action.' | Id: '.$$module_name_singular->id);

        return redirect("admin/{$module_name}");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Update';

        $validated_request = $request->validate([
            'name' => 'required|max:191',
            'sku' => 'required|max:191|unique:goods,sku,'.$id,
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'required|numeric|min:0',
            'min_stock' => 'required|integer|min:0',
            'description' => 'nullable'
        ]);

        $$module_name_singular = $module_model::findOrFail($id);

        $$module_name_singular->update($request->all());

        // Update in Redis and invalidate list cache
        Redis::setex("goods:{$id}", 3600, serialize($$module_name_singular));
        
        // Clear list cache to ensure fresh data on next request
        $pattern = 'goods:list:*';
        $keys = Redis::keys($pattern);
        if (!empty($keys)) {
            Redis::del($keys);
        }

        flash(Str::singular($module_title)."' Updated Successfully")->success()->important();

        logUserAccess($module_title.' '.$module_action.' | Id: '.$$module_name_singular->id);

        return redirect()->route("backend.{$module_name}.show", $$module_name_singular->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Show';

        // Try to get from Redis cache first
        $cache_key = "goods:{$id}";
        $cached_good = Redis::get($cache_key);
        
        if ($cached_good) {
            $$module_name_singular = unserialize($cached_good);
        } else {
            // If not in cache, get from database and cache it
            $$module_name_singular = $module_model::findOrFail($id);
            Redis::setex($cache_key, 3600, serialize($$module_name_singular)); // Cache for 1 hour
        }

        $inventory_moves = $$module_name_singular->inventoryMoves()->latest()->paginate();
        $adjustments = $$module_name_singular->adjustments()->latest()->paginate();

        logUserAccess($module_title.' '.$module_action.' | Id: '.$$module_name_singular->id);

        return view(
            "goods::goods.show",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_name_singular', 'module_action', "{$module_name_singular}", 'inventory_moves', 'adjustments')
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Destroy';

        $$module_name_singular = $module_model::findOrFail($id);

        $$module_name_singular->delete();

        // Remove from Redis and invalidate list cache
        Redis::del("goods:{$id}");
        
        // Clear list cache to ensure fresh data on next request
        $pattern = 'goods:list:*';
        $keys = Redis::keys($pattern);
        if (!empty($keys)) {
            Redis::del($keys);
        }

        flash(Str::singular($module_title)."' Deleted Successfully")->success()->important();

        logUserAccess($module_title.' '.$module_action.' | Id: '.$$module_name_singular->id);

        return redirect("admin/{$module_name}");
    }

    /**
     * Show the form for creating a new inventory move.
     *
     * @param  int  $good_id
     * @return Response
     */
    public function createInventoryMove($good_id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Create Inventory Move';

        $$module_name_singular = $module_model::findOrFail($good_id);

        logUserAccess($module_title.' '.$module_action.' | Good ID: '.$good_id);

        return view(
            "goods::inventory_moves.create",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', "{$module_name_singular}")
        );
    }

    /**
     * Store a newly created inventory move in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $good_id
     * @return \Illuminate\Http\Response
     */
    public function storeInventoryMove(Request $request, $good_id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Store Inventory Move';

        $validated_request = $request->validate([
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
            'date' => 'required|date'
        ]);

        $validated_request['good_id'] = $good_id;
        $validated_request['user_id'] = auth()->id();

        $inventory_move = \Modules\Goods\Models\InventoryMove::create($validated_request);

        // Update good quantity
        $good = $module_model::findOrFail($good_id);
        if ($request->type == 'in') {
            $good->increment('quantity', $request->quantity);
        } else {
            $good->decrement('quantity', $request->quantity);
        }

        flash('Inventory Move Created Successfully')->success()->important();

        logUserAccess($module_title.' '.$module_action.' | Good ID: '.$good_id);

        return redirect()->route("backend.$module_name.show", $good_id);
    }

    /**
     * Show the form for creating a new adjustment.
     *
     * @param  int  $good_id
     * @return Response
     */
    public function createAdjustment($good_id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Create Adjustment';

        $$module_name_singular = $module_model::findOrFail($good_id);

        logUserAccess($module_title.' '.$module_action.' | Good ID: '.$good_id);

        return view(
            "goods::adjustments.create",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', "{$module_name_singular}")
        );
    }

    /**
     * Store a newly created adjustment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $good_id
     * @return \Illuminate\Http\Response
     */
    public function storeAdjustment(Request $request, $good_id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Store Adjustment';

        $validated_request = $request->validate([
            'quantity' => 'required|integer',
            'reason' => 'required|string',
            'date' => 'required|date'
        ]);

        $validated_request['good_id'] = $good_id;
        $validated_request['user_id'] = auth()->id();

        $adjustment = \Modules\Goods\Models\Adjustment::create($validated_request);

        // Update good quantity to match adjustment
        $good = $module_model::findOrFail($good_id);
        $good->update(['quantity' => $request->quantity]);

        flash('Adjustment Created Successfully')->success()->important();

        logUserAccess($module_title.' '.$module_action.' | Good ID: '.$good_id);

        return redirect()->route("backend.$module_name.show", $good_id);
    }
}
