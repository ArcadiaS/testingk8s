<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyUserRequest;
use App\Http\Requests\IndexUserRequest;
use App\Http\Requests\ShowUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\IndexUserRequest  $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(IndexUserRequest $request)
    {
        return UserResource::collection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $user = User::create($request->validated());

            if (! $user) {
                abort(404, 'Something went wrong');
            }

            return response()->json([
                'message' => 'User created successfully.',
            ], 201);
        } catch (\Exception $e) {
            abort(404, $e->getMessage());
        }

        return abort(404, 'Something went wrong.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Http\Requests\ShowUserRequest  $request
     * @param $user
     * @return \App\Http\Resources\UserResource
     */
    public function show(ShowUserRequest $request, User $user)
    {
        return UserResource::make($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param $user
     * @return void
     */
    public function update(UpdateUserRequest $request, $user)
    {
        abort_unless($user->update($request->validated()), 'User update failed.');

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\DestroyUserRequest  $request
     * @param $user
     * @return void
     */
    public function destroy(DestroyUserRequest $request, $user)
    {
        abort_unless($user->delete(), 'User deletion failed.');

        return response()->noContent();
    }
}
