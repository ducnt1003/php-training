<?php

namespace App\Services;

use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getList()
    {
        return $this->userRepository->getListWithRole();
    }

    public function create(Request $request)
    {
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role_id' => $request->input('role_id'),
            'password' => Hash::make('123123'),
        ];
        $user = $this->userRepository->create($data);
        return $this->userRepository->getUserWithRole($user->id);
    }

    public function edit($id, Request $request)
    {
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role_id' => $request->input('role_id'),
        ];
        $user = $this->userRepository->update($id, $data);
        return $this->userRepository->getUserWithRole($user->id);
    }

    public function find($id)
    {
        return $this->userRepository->getUserWithRole($id);
    }

    public function delete($id)
    {
        if ($this->userRepository->delete($id))
            return response()->json([
                'response' => 'success',
            ])->setStatusCode(200);
        else return response()->json([
            'response' => 'fail',
        ])->setStatusCode(500);
    }

    public function deleteMulti(Request $request)
    {
        $ids = $request->input('selected');
        foreach ($ids as $id) {
            if (!$this->userRepository->delete($id)) {
                return response()->json([
                    'response' => 'fail',
                ])->setStatusCode(500);
            }
        }
        return response()->json([
            'response' => 'success',
        ])->setStatusCode(200);
    }
}
