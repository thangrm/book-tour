<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, User $user)
    {
        $request->validate($user->rules());

        try {
            $user->saveUser($request);

            return response()->json(['message' => 'Successfully created user!'], 201);
        } catch (Exception $e) {
            return response()->json([
                'error' => [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode()
                ]
            ], 500);
        }
    }

    /**
     * Get the authenticated User
     *
     * @param Request $request
     * @return UserResource
     */
    public function show(Request $request)
    {
        return new UserResource($request->user());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $userId
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($userId, Request $request, User $user)
    {
        $request->validate($user->rules($userId));

        try {
            $user->saveUser($request, $userId);

            return response()->json(['message' => 'Successfully updated user!']);
        } catch (Exception $e) {
            return response()->json(
                [
                    'error' => [
                        'message' => $e->getMessage(),
                        'code' => $e->getCode()
                    ]
                ], 500);
        }
    }
}
