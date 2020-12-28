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
     * @group User Resource
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
     *
     * @param  \App\Http\Requests\IndexUserRequest  $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(IndexUserRequest $request)
    {
        return UserResource::collection(User::all());
    }

    /**
     * @group User Resource
     * Create a new resource.
     *
     * @apiResourceCollection App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
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
     * @group User Resource
     * Display the resource.
     *
     * @apiResourceCollection App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
     * @param  \App\Http\Requests\ShowUserRequest  $request
     * @param $user
     * @bodyParams user int required The id of the user. Example: 12345
     * @return \App\Http\Resources\UserResource
     */
    public function show(ShowUserRequest $request, User $user)
    {
        return UserResource::make($user);
    }

    /**
     * @group User Resource
     * Update specified resource.
     *
     * @apiResourceCollection App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param $user
     * @bodyParams user int required The id of the user. Example: 12345
     * @return void
     */
    public function update(UpdateUserRequest $request, $user)
    {
        abort_unless($user->update($request->validated()), 'User update failed.');

        return response()->noContent();
    }

    /**
     * @group User Resource
     * Remove specified resource from db.
     *
     * @apiResourceCollection App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
     * @param  \App\Http\Requests\DestroyUserRequest  $request
     * @param $user
     * @bodyParams user int required The id of the user. Example: 12345
     * @return void
     */
    public function destroy(DestroyUserRequest $request, $user)
    {
        abort_unless($user->delete(), 'User deletion failed.');

        return response()->noContent();
    }
}
