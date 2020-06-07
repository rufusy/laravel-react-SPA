<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\APIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\User;

class ResetPasswordController extends APIController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Reset the user's password
     *
     * @param  Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function reset(Request $request)
    {
        if($request->email){
            $user = User::where('email', $request->email)->first();
        }

        $validator = Validator::make(
            $request->all(),
            $this->rules(),
            $this->validationErrorMessages()
        );

        if($validator->fails()){
            return $this->responseUnprocessable($validator->errors());
        }
        
        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
            $this->credentials($request),
            function($user, $password){
                $this->resetPassword($user, $password);
            }
        );

        return $response == Password::PASSWORD_RESET 
                ? $this->responseSuccess('Password reset successful.') 
                : $this->responseServerError('Password reset failed.');
       
    }
}