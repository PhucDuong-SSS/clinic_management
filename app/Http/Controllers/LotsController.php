<?php

namespace App\Http\Controllers;

use App\Http\Requests\LotsRequest;
use App\Models\Lot;
use App\Models\Medicine;
use Illuminate\Http\Request;

class LotsController extends Controller
{
    function index()
    {
        $lots = Lot::all();
        return view('warehouse.listWahouse', compact('lots'));
    }

    function create()
    {
        $medicines = Medicine::all();
        return view('warehouse.addWahouse', compact('medicines'));
    }
    function store(LotsRequest $request)
    {
        $lots = new Lot();
        $lots->code = $request->code;
        $lots->id_med = $request->medicine;
        $lots->medicine_amount = $request->medicine_amount;
        $lots->expired_date = $request->expired_date;
        $lots->receipt_date = $request->receipt_date;
        $lots->total_price = $request->total_price;
        $lots->unit_price = round(($request->total_price / $request->medicine_amount), 2);
        $lots->save();

        $medicine = Medicine::findOrFail($request->medicine);
        $medicine->medicine_amount += $request->medicine_amount;
        $medicine->save();

        return redirect()->route('lots.index')->with('success', "Thêm thuốc thành công");
    }
    function edit($id)
    {
        $medicines = Medicine::all();
        $lot = Lot::findOrFail($id);
        return view('warehouse.editWahouse', compact('medicines', 'lot'));
    }
    function update($id, LotsRequest $request)
    {
        $lot = Lot::findOrFail($id);
        $lot->code = $request->code;
        $lot->id_med = $request->medicine;
        $lot->medicine_amount = $request->medicine_amount;
        $lot->expired_date = $request->expired_date;
        $lot->receipt_date = $request->receipt_date;
        $lot->total_price = $request->total_price;
        $lot->unit_price = round(($request->total_price / $request->medicine_amount), 2);
        $lot->save();

        return redirect()->route('lots.index')->with('success', "Sửa thuốc thành công");
    }
    function destroy($id)
    {
        $lots = Lot::findOrFail($id);
        $lots->delete();
        return response()->json(["success" => "Record has been delete"]);
    }
}
