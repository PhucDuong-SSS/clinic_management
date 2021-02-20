<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitRequest;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    function index()
    {
        $units = Unit::all();
        return view('unit.listUnit', compact('units'));
    }
    function store(UnitRequest $request)
    {
        $unit = new Unit();
        $unit->unit_name = $request->unit_name;
        $unit->save();
        $message = 'Thêm thành công!';

        $units = Unit::all();

        return response()->json(['units' => $units]);
    }
    function edit($id)
    {
        $units = Unit::findOrFail($id);

        return response()->json(['units' => $units]);
    }
    function update($id, UnitRequest $request)
    {
        $unit = Unit::findOrFail($id);
        $unit->unit_name = $request->unit_name;
        $unit->save();
        $units = Unit::all();

        return response()->json(['units' => $units, 'resquest' => $request]);
    }
    function destroy($id)
    {
        $unit = Unit::findOrFail($id);
        $unit->delete();
        $message = 'Xóa thành công';
        $units = Unit::all();
        return response()->json(['units' => $units, 'success' => $message]);
    }
}
