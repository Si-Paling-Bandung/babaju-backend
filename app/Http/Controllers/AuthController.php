<?php

namespace App\Http\Controllers;

use App\Models\LocalOfficial;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rule;
use App\Models\Log;
use App\Models\Instance;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|min:11|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors(),
            ], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        // Logging
        // $log = new Log();
        // $log->content = $user . ' registered';
        // $log->save();

        event(new Registered($user));

        return response()
            ->json([
                'status' => 'success',
                'message' => 'You have successfully registered !',
                'data' => $user,
            ], 201);
    }

    public function login(Request $request)
    {
        if (is_numeric($request->get('email'))) {
            if (!Auth::attempt($request->only('p', 'password'))) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Invalid credentials',
                ], 401);
            }
        } else {
            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Invalid credentials',
                ], 401);
            }
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        // Logging
        // $log = new Log();
        // $log->content = $user . ' logged in';
        // $log->save();

        return response()->json([
            'status' => 'success',
            'message' => 'You have successfully logged in !',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        // Logging
        // $log = new Log();
        // $log->content = $request->user() . ' logged out';
        // $log->save();

        return response()->json([
            'status' => 'success',
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ], 200);
    }

    public function profile(Request $request)
    {
        $user = $request->user();

        if ($user->role == "perangkat_daerah") {
            $asal_instansi = LocalOfficial::find($request->id_regional_device);
        } elseif ($request->role == "kader" || $request->role == "tenaga_kesehatan" || $request->role == "trainer") {
            $asal_instansi = Instance::find($request->id_instance);
        } else {
            $asal_instansi = "Lainnya";
        }

        // Logging
        // $log = new Log();
        // $log->content = $request->user() . ' check profile';
        // $log->save();

        return response()->json([
            'status' => 'success',
            'message' => 'You have successfully request profile information',
            'name' => $user->name,
            'username' => $user->username,
            'role' => $user->role,
            // Pendidikan Terakhir
            // Alamat Lengkap
            'asal_instansi' => $asal_instansi,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ], 200);
    }

    public function update_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            // 'username' => ['required', Rule::unique('users', 'username')->ignore($request->user())],
            // 'old_password' => 'string|min:8',
            // 'new_password' => 'string|min:8|different:old_password',
            // 'confirm_password' => 'require   d_with:new_password|same:new_password|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors(),
            ], 400);
        }

        $user = $request->user();

        $user->name = $request->name;
        $user->no_telp = $request->no_telp;
        // $user->username = $request->username;

        // if (isset($request->new_password)) {
        //     if (!Hash::check($request->old_password, $request->user()->password)) {
        //         return response()->json([
        //             'status' => 'failed',
        //             'message' => 'You have input wrong password !'
        //         ], 400);
        //     }
        //     $user->password = Hash::make($request->new_password);
        // }

        $user->save();

        // Logging
        // $log = new Log();
        // $log->content = $user . ' update profile';
        // $log->save();

        return response()->json([
            'status' => 'success',
            'message' => 'You have successfully update your profile !',
            'name' => $user->name,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ], 200);
    }

    public function delete_profile(Request $request)
    {
        // Logging
        // $log = new Log();
        // $log->content = $request->user() . ' delete profile';
        // $log->save();

        // $user = $request->user();
        // $user->delete();

        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'You account have successfully deleted'
        // ], 200);
    }

    public function checkPassword(Request $request)
    {
        // if (!Hash::check($request->password, $request->user()->password)) {
        //     return response()->json([
        //         'status' => 'failed',
        //         'message' => 'You have input wrong password !',
        //     ], 400);
        // }

        // // Logging
        // $log = new Log();
        // $log->content = $request->user() . ' check password';
        // $log->save();

        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'You have input right password !'
        // ], 200);
    }

    public function test(Request $request)
    {
        // $answer = $request->content;
        // $answer_array = [];
        // foreach ($answer as $as) {
        //     array_push($answer_array,$as["answerUser"]);
        // }
        // return $answer_array;
    }
}
