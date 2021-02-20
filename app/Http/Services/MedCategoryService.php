<?php

namespace App\Http\Services;

use App\Http\Repositories\MedCategoryRepository;
use App\Models\medCategory;


class MedCategoryService implements ServiceInterface
{
    protected $medCategoryRepo;
    public function __construct(MedCategoryRepository  $medCategoryRepo)
    {
        $this->medCategoryRepo = $medCategoryRepo;
    }

    public function getAll()
    {
        return $this->medCategoryRepo->getAll();
    }

    function findById($id)
    {
        return $this->medCategoryRepo->findById($id);
    }

    function add($request, $obj = null)
    {
        $obj = new medCategory();
        $obj->id = $request->id;
        $obj->med_category_name = $request->med_category_name;
        $obj->description = $request->description;
        $this->medCategoryRepo->save($obj);
    }

    function delete($obj)
    {
        $this->medCategoryRepo->delete($obj);
    }

    function update($request, $obj = null)
    {
        $obj->fill($request->all());
        $this->medCategoryRepo->save($obj);
    }
}
