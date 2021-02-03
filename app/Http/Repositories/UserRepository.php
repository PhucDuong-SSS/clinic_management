<?php


namespace App\Http\Repositories;


use App\Models\User;

class UserRepository extends BaseRepository implements RepositoryInterface
{
    protected $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    function getAll()
    {
        return $this->userModel->all();
    }

    function findById($id)
    {
        return $this->userModel->findOrFail($id);
    }
}
