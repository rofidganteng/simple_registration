<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'mobile' => ['required', 'mobile_indonesia', 'unique:users'],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'date_birth' => ['date','date_format:Y-m-d'],
            'gender' => ['in:m,f'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:users'],
        ]);
    }

    public function create()
    {
        return view('users.create');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Authorization

        // Form Validation
        $data = $request->all();
        if(isset($data['year']) && isset($data['month']) && isset($data['date'])) {
            $data['birth_date'] = $data['year'].'-'.$data['month'].'-'.$data['date'];
        }

        $val = $this->validator($data);

        if ($val->fails())
        {
            return response()->json([
                'success' => false,
                'errors' => $val->errors()
            , 200]);

        } else {

            // Insert to Database
            $user = User::create($data);

            if ($user)
            {
                // Insert Success
                return response()->json([
                    'success' => true,
                    'message' => 'Registration Success',
                ], 200);
            } else {
                // Insert Fail
                return response()->json([
                    'success' => false,
                    'message' => 'Registration Failed',
                ], 200);
            }

        }

    }
}
