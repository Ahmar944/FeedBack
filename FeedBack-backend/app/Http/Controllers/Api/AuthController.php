<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\ApiController;

class AuthController extends ApiController
{
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) { 
            $user = Auth::user(); 

            $response['token'] =  $user->createToken('')->plainTextToken; // Remove $request->device_name
            $response['name'] =  $user->name;

            return $this->successResponse('User successfully logged-in.', $response);
        } 
        else { 
            return $this->errorResponse('Unauthorized.', ['error'=>'Unauthorized'], 403);
        } 
    }

    
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role' => 'nullable|in:1,2', // Validate role if provided
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation error.', $validator->errors(), 400);
        }

        // Prepare user data
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ];

        // Assign role based on request or default to role 2
        $role = $request->input('role', 2);

        // Check if the role exists
        if (!Role::find($role)) {
            return $this->errorResponse('Invalid role.', [], 400);
        }

        // Assign the role ID to the user data
        $userData['role_id'] = $role;

        // Create the user
        $user = User::create($userData);

        // Prepare response
        $response = [
            'token' => $user->createToken('')->plainTextToken,
            'name' => $user->name,
        ];

        return $this->successResponse('User created successfully.', $response);
    }
    

    public function logout() 
    {
        auth()->user()->currentAccessToken()->delete();

        return $this->successResponse('Logout successfully.');
    }
   
}
