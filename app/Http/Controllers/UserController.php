<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Event;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Subscriber;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Events\UserCreated;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()) {
            return view('profile');
        } else {
            return redirect('/login');
        }
    }

    public function subscribe(Request $request) {
        $email = $request->get('fba');
        $validator = Validator::make(
            [
                'email' => $email
            ],
            [
                'email' => 'required|email|unique:subscribers'
            ]
        );
        if ($validator->fails()) {
            return json_encode(['status' => 'failed']);
        }
        $sub = Subscriber::create(['email' => $email]);
        $sub->save();
        return json_encode(['status' => 'success']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Event::fire(new UserCreated($this));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

    public function apiUser(Request $request) {
        return $request->user();
    }
}
