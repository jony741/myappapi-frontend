<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ResetMyPass;

class ResetPasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reset_password');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ResetMyPass $request)
    {
        // form data
        // $data = $request->all();
        // $user->update($data);
        // return redirect(route('profile.edit', ['user' => $user]))
        //     ->with('info', 'Your profile has been updated successfully.');
        // $token = $request->session()->get('token');
        $token = $request->get('token');
        $email = $request->get('email');
        $pass = $request->get('password');
        echo "pass:".$pass."  email:".$email."  token:".$token;

        $myrequest = new Request([
            'token'   => $token,
            'email'  => $email,
            'password' => $pass,
        ]);

        // , with($token)
        return redirect()->route('coco');
    }
}
