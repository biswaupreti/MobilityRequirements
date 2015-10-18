<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class UserController extends BaseController
{
    public $rules = [
        'name' => 'required|min:5',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
        'password_confirmation' => 'required|min:6',
        'role' => 'required'
    ];

    public function index()
    {
        $users = User::latest()->get();

        return view('user.index', compact('users'));
    }


    public function show($id)
    {
        $user = User::find($id);

        return view('user.show', compact('user'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('user.create');
    }


    /**
     * @param $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $data = $request->all();
        $data['password'] = bcrypt($data['password']);

        User::create($data);

        Session::flash('flash_message', 'Congratulations, New user added successfully!');

        return redirect('users');
    }


    public function edit($id)
    {
        $user = User::find($id);

        return view('user.edit', compact('user'));
    }



    public function update($id, Request $request)
    {
        $data = $request->all();
        if(isset($data['change_password']) && $data['change_password'] == '1'):
            $data['password'] = bcrypt($data['password']);
        else:
            $this->rules['password'] = '';
            $this->rules['password_confirmation'] = '';
        endif;

        $this->rules['email'] = 'required|email';
        $this->validate($request, $this->rules);

        $user = User::find($id);
        $user->update($data);

        Session::flash('flash_message', 'User successfully updated!');

        return redirect('users');
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        Session::flash('flash_message', 'User successfully deleted!');

        return redirect('users');
    }

}