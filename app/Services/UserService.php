<?php

namespace App\Services;

use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getList(Request $request)
    {
        $whereLike = [];
        if ($request->search) {
            array_push($whereLike, [DB::raw('BINARY `name`'), 'like', '%' . $request->search . '%']);
        }
        if ($request->role_id && $request->role_id != config('constants.role_id_max') && $request->role_id != config('constants.role_id_min')) {
            array_push($whereLike, ['role_id', $request->role_id]);
        }
        if ($request->type == config('constants.non_short_type') || !$request->type) {
            $orderBy = ['id', config('constants.short_asc')];
        } else if ($request->type == config('constants.short_type_asc')) {
            $orderBy = [$request->key, config('constants.short_asc')];
        } else {
            $orderBy = [$request->key, config('constants.short_desc')];
        }
        return $this->userRepository->getListWithRole($whereLike,$orderBy);
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
        $selecteds = $request->input('selected');
        if(!$selecteds['allCheck']){
            foreach ($selecteds['selected'] as $selected) {
                if (!$this->userRepository->delete($selected['id'])) {
                    return response()->json([
                        'response' => 'fail',
                    ])->setStatusCode(500);
                }
            }
        } else {
            if (!$this->userRepository->deleteAllUser()) {
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
