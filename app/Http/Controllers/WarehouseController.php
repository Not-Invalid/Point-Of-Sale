<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        $warehouses = Warehouse::orderBy('warehouse_id', 'DESC');

        if ($request->has('search')) {
            $search = $request->query('search');
            $warehouses->where('warehouse_id', 'like', '%' . $search . '%') ->orWhere('warehouse_name', 'like', '%' . $search . '%');
        }

        $warehouses = $warehouses->paginate(10);
        return view('admin.warehouse.index', compact('warehouses'));
    }

    public function show(Request $request, $warehouse_id)
    {
        $warehouses = Warehouse::all()->find($warehouse_id);
        if (!$warehouses) {
            return redirect()->route('admin.warehouse.index')->with('error', 'Warehouse not found.');
        }

        return view('admin.warehouse.show', compact('warehouses'));
    }

    public function add()
    {
        $warehouses = Warehouse::all();
        return view('admin.warehouse.create', compact('warehouses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'warehouse_name' => 'required',
            'location' => 'required',
        ]);

        $lastwarehouse = Warehouse::orderBy('warehouse_id', 'DESC')->first();
        if ($lastwarehouse) {
            $lastId = intval(substr($lastwarehouse->warehouse_id, 4));
            $newId = 'WRH-' . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newId = 'WRH-001';
        }

        $warehouse = new Warehouse();
        $warehouse->warehouse_id = $newId;
        $warehouse->warehouse_name = $request->warehouse_name;
        $warehouse->location = $request->location;
        $warehouse->save();

        return redirect()->route('admin.warehouse.index')->with('success', 'Warehouse added successfully');
    }

    public function edit($warehouse_id)
    {
        $warehouse = Warehouse::findOrFail($warehouse_id);
        $warehouses = Warehouse::orderBy('warehouse_id', 'DESC')->get();
        return view('admin.warehouse.index', compact('warehouses', 'warehouse'));
    }

    public function update(Request $request, $warehouse_id)
    {
        $request->validate([
            'warehouse_name' => 'required',
            'location' => 'required',
        ]);

        $warehouse = Warehouse::findOrFail($warehouse_id);
        $warehouse->warehouse_name = $request->warehouse_name;
        $warehouse->location = $request->location;
        $warehouse->save();

        return redirect()->route('admin.warehouse.index')->with('success', 'Warehouse updated successfully');
    }

    public function destroy($warehouse_id)
    {
        $warehouse = Warehouse::findOrFail($warehouse_id);
        $warehouse->delete();

        return redirect()->route('admin.warehouse.index')->with('success', 'Warehouse deleted successfully');
    }

}
