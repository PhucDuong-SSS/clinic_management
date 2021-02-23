<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedEditRequest;
use App\Http\Requests\MedRequest;
use App\Models\medCategory;
use App\Models\Medicine;
use App\Models\Unit;
use Illuminate\Http\Request;
use SebastianBergmann\Environment\Console;

class MedController extends Controller
{
    function index()
    {
        $med_categories= medCategory::all();
        $medicines = Medicine::all();
        return view('medicine.listMedicine', compact('medicines','med_categories'));
    }

    function create()
    {
        $medCategories = medCategory::all();
        $units = Unit::all();
        return view('medicine.addMedicine', compact('medCategories', 'units'));
    }
    function store(MedRequest $request)
    {
        $medicines = new Medicine();
        $medicines->id_category = $request->category;
        $medicines->medicine_name = $request->medicine_name;
        $medicines->medicine_amount = 0;
        $medicines->sell_price = $request->sell_price;
        $medicines->id_unit = $request->unit;
        $medicines->image = $request->image->store('public/images');
        $medicines->save();

        return redirect()->route('med.index')->with('success', "Thêm thuốc thành công");
    }
    function edit($id)
    {
        $medCategories = medCategory::all();
        $medicine = Medicine::findOrFail($id);
        $units = Unit::all();


        return view('medicine.editMedicine', compact('medicine', 'medCategories', 'units'));
    }
    function update($id, MedEditRequest $request)
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->id_category = $request->category;
        $medicine->medicine_name = $request->medicine_name;
        $medicine->sell_price = $request->sell_price;
        $medicine->id_unit = $request->unit;
        $medicine->image = $this->UpdateUpload($id, $request);
        $medicine->save();

        return redirect()->route('med.index')->with('success', "Sửa thuốc thành công");
    }
    public function UpdateUpload($id, $request)
    {
        $medicine = Medicine::findOrFail($id);
        if ($request->hasFile('image')) {
            $img = $request->image;
            $path = $img->store('public/images');
            return $path;
        } else {
            return $medicine->image;
        }
    }
    function destroy($id)
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->delete();
        return response()->json(["success" => "Record has been delete"]);
    }

    function showMedByCategory($id_category)
    {
        $medicines = Medicine::where('id_category',$id_category)->get();

        $med_categories= medCategory::all();
        return view ('medicine.listMedicine',compact('med_categories','medicines','id_category'));
    }


}
