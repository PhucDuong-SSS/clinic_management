<?php

namespace App\Http\Repositories;

use App\Models\medCategory;

class MedCategoryRepository extends BaseRepository implements RepositoryInterface
{
    protected $medCategoryModel;
    public function __construct(medCategory $medCategoryModel)
    {
        $this->medCategoryModel = $medCategoryModel;
    }

    public function getAll()
    {
        return $this->medCategoryModel->all();
    }

    public function findById($id)
    {
        return $this->medCategoryModel->findOrFail($id);
    }

    public function save($obj)
    {
        $obj->save();
    }

    public function delete($obj)
    {
        parent::delete($obj);
    }
}
