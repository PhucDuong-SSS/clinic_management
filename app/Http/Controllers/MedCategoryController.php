<?php

namespace App\Http\Controllers;

use App\Http\Services\MedCategoryService;
use Illuminate\Http\Request;

class MedCategoryController extends Controller
{
    protected $medCategoryService;

    public function __construct(MedCategoryService $medCategoryService)
    {
        $this->medCategoryService = $medCategoryService;
    }

    public function index()
    {
        $medCategories = $this->medCategoryService->getAll();
        return view('medicineCategory.medCategory',compact('medCategories'));
    }

    public function store(Request $request)
    {

        $medCategories = $this->medCategoryService->add($request);


        return response()->json(['medCategories'=>$medCategories]);
    }

    public function edit($id)
    {
        $medCategories = $this->medCategoryService->findById($id);
        return response()->json(['medCategories'=>$medCategories]);
    }

    public function update(Request $request,$id)
    {
        $medCategories = $this->medCategoryService->findById($id);
        $this->medCategoryService->update($request,$medCategories);

        return response()->json(['medCategories'=>$medCategories,'request'=>$request]);
    }

    public function destroy($id)
    {
        $medCategories = $this->medCategoryService->findById($id);
        $medCategories->delete();

        return response()->json(['medCategories'=>$medCategories]);
    }
}
