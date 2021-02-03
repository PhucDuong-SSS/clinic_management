<?php

namespace App\Http\Services;

use App\Http\Repositories\SymptonRepository;

class SymtonService implements ServiceInterface
{
    protected $symptonRepo;

    public function __construct(SymptonRepository $symptonRepository)
    {
        $this->symptonRepo = $symptonRepository;
    }

    public function getAll()
    {
        return $this->symptonRepo->getAll();
    }

    public function findById($id)
    {
        return $this->symptonRepo->findById($id);
    }

    public function add($request, $obj = null)
    {
        $obj->fill($request->all());
        $this->symptonRepo->save($obj);
    }

    public function delete($obj)
    {
        $this->symptonRepo->delete($obj);
    }

    public function update($request, $obj = null)
    {
        // TODO: Implement update() method.
    }
}
