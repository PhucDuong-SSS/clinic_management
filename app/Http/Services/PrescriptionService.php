<?php

namespace App\Http\Services;

use App\Http\Repositories\PrescriptionRepository;

class PrescriptionService implements ServiceInterface
{
    protected $prescriptionRepo;

    public function __construct(PrescriptionRepository $prescriptionRepository)
    {
        $this->prescriptionRepo = $prescriptionRepository;
    }

    public function getAll()
    {
       return $this->prescriptionRepo->getAll();
    }

    public function findById($id)
    {
       return $this->prescriptionRepo->findById($id);
    }

    public function add($request, $obj = null)
    {
        $obj->fill($request->all());
        $this->prescriptionRepo->save($obj);
    }

    public function delete($obj)
    {
        $this->prescriptionRepo->delete($obj);
    }

    public function update($request, $obj = null)
    {
        // TODO: Implement update() method.
    }
}
