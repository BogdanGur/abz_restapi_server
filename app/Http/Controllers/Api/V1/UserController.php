<?php

namespace App\Http\Controllers\Api\V1;

use App\Bogur\Bogur;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Url;
use PHPUnit\Exception;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = \request('page');
        $count = \request('count');

        if(!$page) $page = 1;
        if(!$count) $count = 5;

        $validator = Validator::make(
            [
                'page' => $page,
                'count' => $count
            ],
            [
                'page' => "integer|min:1",
                'count' => "integer"
            ]
        );
        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'fails' => $validator->errors()
            ], 422);
        }

        $users = User::paginate($count)->withQueryString();

        if(count($users) < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Page not found'
            ], 404);
        }


        return response()->json([
            'success' => true,
            'page' => $users->currentPage(),
            'count' => $users->perPage(),
            'total_pages' => $users->lastPage(),
            'total_users' => $users->total(),
            'links' => [
                'next_url' => $users->nextPageUrl(),
                'prev_url' => $users->previousPageUrl()
            ],
            'users' => UserResource::collection($users)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'position_id' => $request->position_id,
                'photo' => $request->photo
            ],
            [
                'name' => 'required|min:2|max:60',
                'email' => 'required|email',
                'phone' => 'required|regex:/^\+380\d{3}\d{2}\d{2}\d{2}$/',
                'position_id' => 'integer',
                'photo' => 'mimes:jpeg,jpg|max:5048'
            ]
        );
        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'fails' => $validator->errors()
            ], 422);
        }

        $token = $request->header('Token');
        $valid = Cache::get('token');

        if($token && $valid) {

            try {
                $user = new User();

                $user->name = $request->name;
                $user->email = $request->email;
                $user->phone = $request->phone;
                $user->position_id = $request->position_id;
                $user->api_token = $token;
                $user->password = Hash::make(10);

                if($request->hasFile('photo')) {
                    $request->photo->store('user_photos', 'public');
                    Bogur::cropAndTinifyImage($request->photo->hashName());

                    $user->photo = $request->photo->hashName();
                }
                $user->save();

                return response()->json([
                    'success' => true,
                    'user_id' => $user->id,
                    'message' => 'New user successfully registered'
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'User with this phone or email already exist'
                ], 409);
            }

        } else {
            return response()->json([
                'success' => false,
                'message' => 'The token expired.'
            ], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $validator = Validator::make(['id' => $id,], ['id' => 'integer',]);
        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'fails' => $validator->errors()
            ], 400);
        }

        try {
            $user = User::findOrFail($id);

            return response()->json([
                'success' => true,
                'user' => new UserResource($user)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'The user with the requested identifier does not exist',
                'fails' =>  [
                    'user_id' => 'User not found'
                ]
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
