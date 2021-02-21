<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriesRequest;
use App\Http\Services\MedCategoryService;
use App\Models\medCategory;
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
        return view('medicineCategory.medCategory', compact('medCategories'));
    }

    public function store(CategoriesRequest $request)
    {

        $medCategories = $this->medCategoryService->add($request);
        $medCategories = medCategory::all();

        return response()->json(['medCategories' => $medCategories]);
    }

    public function edit($id)
    {
        $medCategories = $this->medCategoryService->findById($id);
        return response()->json(['medCategories' => $medCategories]);
    }

    public function update(CategoriesRequest $request, $id)
    {
        $medCategories = medCategory::findOrFail($id);
        $medCategories->med_category_name = $request->med_category_name;
        $medCategories->description = $request->description;
        $medCategories->save();
        $medCategories = medCategory::all();

        return response()->json(['medCategories' => $medCategories, 'resquest' => $request]);
    }

    public function destroy($id)
    {
        $medCategories = $this->medCategoryService->findById($id);
        $medCategories->delete();
        $medCategories = medCategory::all();

        return response()->json(['medCategories' => $medCategories]);
    }
}
