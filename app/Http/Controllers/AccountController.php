<?php

namespace App\Http\Controllers;

use App\Bogur\Bogur;
use App\Http\Requests\UserRequest;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AccountController extends Controller
{
    public function index(Request $request) {

        $request->session()->regenerateToken();
        $token = csrf_token();
        $xsrf = base64_encode(Cookie::get('XSRF-TOKEN'));

        return ['token' => $token, 'XSRF' => $xsrf];

        return view('account', ["user" => User::findOrFail(Auth::id()), "positions" => Position::all()]);
    }

    public function edit(UserRequest $request) {
        $user = User::findOrFail(Auth::id());

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->position_id = $request->position_id;

        if($request->hasFile('photo')) {
            $request->photo->store('user_photos', 'public');
            Bogur::cropAndTinifyImage($request->photo->hashName());

            $user->photo = $request->photo->hashName();
        }
        $user->save();

        return back()->with(['success' => 'Данные обновлены успешно']);
    }
}
