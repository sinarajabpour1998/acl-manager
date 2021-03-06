<?php

namespace Sinarajabpour1998\AclManager\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Sinarajabpour1998\AclManager\Facades\UserFacade;
use Sinarajabpour1998\AclManager\Http\Requests\UserRequest;
use App\Models\Province;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Sinarajabpour1998\LogManager\Facades\LogFacade;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function create()
    {
        //$provinces = Province::all();
        return view('vendor.AclManager.users.create');
    }

    public function store(UserRequest $request , User $user)
    {
        $user->fill($request->except('status'));
        if ($request->status == 'verified'){
            $user->email_verified_at = Carbon::now();
        }
        $user->save();
        session()->flash('success', 'مشخصات کاربر با موفقیت ثبت شد.');
        LogFacade::generateLog("create_user", "User id : " . $user->id);

        return redirect()->route('users.edit', $user);
    }

    public function edit(User $user)
    {
        //$provinces = Province::all();
        $status = 'verified';
        UserFacade::userFieldsDecryption($user);
        if (is_null($user->email_verified_at)){
            $status = 'not_verified';
        }
        return view('vendor.AclManager.users.edit', compact('user', 'status'));
    }

    public function update(UserRequest $request, User $user)
    {
        $user->fill($request->except('status'));
        if ($request->status == 'verified'){
            $user->email_verified_at = Carbon::now();
        }else{
            $user->email_verified_at = null;
        }
        $user->save();
        session()->flash('success', 'مشخصات کاربر با موفقیت ویرایش شد.');
        LogFacade::generateLog("update_user", "User id : " . $user->id);

        return redirect()->back();
    }

    public function destroy(User $user)
    {

    }

    public function userResetPasswordForm(User $user) {
        UserFacade::userFieldsDecryption($user);
        return view('vendor.AclManager.users.user_reset_password', compact('user'));
    }

    public function userResetPassword(\Illuminate\Http\Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $user->password = Hash::make($request->password);
        $user->save();

        session()->flash('success', 'کاربر گرامی رمز عبور با موفقیت بروزرسانی گردید.');
        LogFacade::generateLog("reset_user_password", "User id : " . $user->id);

        return redirect()->back();
    }
}
