<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function signup(Request $request){
        $validator = Validator::make($request->all(), [
            'last_name' => 'required',
            'first_name' => 'required',
            'username' => 'required',
            'password' => 'required|string|confirmed'
        ]);

        if ($validator->fails()) {
            return customResponse()
                ->data(null)
                ->message($validator->errors()->all()[0])
                ->failed()
                ->generate();
        }

        $userData = new User([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'username' => $request->username,
            'password' => bcrypt($request->password)
        ]);

        $userData->save();

        return customResponse()
            ->message('Successfully created user!')
            ->data($userData)
            ->success()
            ->generate();
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return customResponse()
                ->data(null)
                ->message($validator->errors()->all()[0])
                ->failed()
                ->generate();
        }

        $credentials = request(['username', 'password']);
        if (!Auth::attempt($credentials)) {
            return customResponse()
                ->message('Unauthorized')
                ->data(null)
                ->failed(404)
                ->generate();
        }

        $userData = $request->user();

        $tokenResult = $userData->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
            
        $token->save();

        return customResponse()
            ->message('Successfully logged in!')
            ->data([
                'user' => $userData,
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ])
            ->success()
            ->generate();
    }

    public function logout(Request $request){
        $request->user()->token()->revoke();
        return customResponse()
            ->message('Successfully logged out!')
            ->data(null)
            ->success()
            ->generate();
    }

    public function user(Request $request){
        $userData = $request->user();
        return customResponse()
            ->message('Success in Getting User.')
            ->data($userData)
            ->success()
            ->generate();
    }
}
