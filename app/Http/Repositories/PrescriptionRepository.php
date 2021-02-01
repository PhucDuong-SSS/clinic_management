<?php

namespace App\Http\Repositories;

use App\Models\Prescription;

class PrescriptionRepository extends BaseRepository implements RepositoryInterface
{
    protected $prescriptionModel;

    public function __construct(Prescription $prescription)
    {
        $this->prescriptionModel  = $prescription;
    }

    public function getAll()
    {
        return $this->prescriptionModel->all();
    }

   public function findById($id)
   {
       return $this->prescriptionModel->findOrFail($id);
   }

   public function save($obj)
   {
       parent::save($obj); // TODO: Change the autogenerated stub
   }

   public function delete($obj)
   {
       parent::delete($obj); // TODO: Change the autogenerated stub
   }
}