<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Android\AndroidUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AndroidRegistrationController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:user_accounts,username',
            'password' => 'required|string',
            'age' => 'required|integer|min:1',
            'birthday' => 'required|date',
            'adrHouseNo' => 'required|string|max:255',
            'adrZone' => 'required|string|max:255',
            'adrStreet' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'valid_id' => 'required|image|mimes:jpg,png,jpeg|max:10240',
            'valid_id_back' => 'required|image|mimes:jpg,png,jpeg|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false, 
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Handle file uploads
            $validIdPath = null;
            $validIdBackPath = null;
            
            if ($request->hasFile('valid_id')) {
                $validIdPath = $request->file('valid_id')->store('uploads/valid_ids', 'public');
            }
            
            if ($request->hasFile('valid_id_back')) {
                $validIdBackPath = $request->file('valid_id_back')->store('uploads/valid_ids', 'public');
            }
        
            // Validate that both files were uploaded
            if (!$validIdPath || !$validIdBackPath) {
                return response()->json([
                    'success' => false,
                    'message' => 'Both valid ID images are required'
                ], 422);
            }
        
            $user = AndroidUser::create([
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'username' => $request->username,
                'password' => $request->password,
                'age' => $request->age,
                'birthday' => $request->birthday,
                'adrHouseNo' => $request->adrHouseNo,
                'adrZone' => $request->adrZone,
                'adrStreet' => $request->adrStreet,
                'gender' => $request->gender,
                'user_valid_id' => $validIdPath,
                'user_valid_id_back' => $validIdBackPath,
            ]);
        
            return response()->json([
                'success' => true, 
                'message' => 'User registered successfully',
                'id' => $user->id
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}