<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function login(Request $request)
    {
        return view('auth/login');
    }

    public function loginAction(Request $request)
    {
        Validator::make(
            $request->all(),
            [
                'NPK'      => 'required',
                'password' => 'required'
            ]
        )->validate();

        if (!Auth::attempt($request->only('NPK', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed')
            ]);
        }

        $time = Carbon::now();
        $timeLog = $time->format('H:i');

        // Ambil user saat ini
        $user = Auth::user();
        $idMch = $request->input('id_mch') ?? $user->id_mch;
        $request->session()->put('id_mch', $idMch);

        DB::table('logactuser')->insert([
            'user_id' => $user->id,
            'login' => $timeLog
        ]);

        DB::table('users')->where('id', $user->id)->update([
            'last_login_at' => $time
        ]);

        if ($user->level === 1) {
            return redirect()->route('admin.ljkh');
        } elseif ($user->level === 2) {
            $idMch = $request->input('id_mch');
            if ($idMch) {
                return redirect()->route('member.index');
            } else {
                return redirect()->route('admin.DashboardAdmin');
            }
        } elseif ($user->level === 3) {
            return redirect()->route('member.index');
        }
    }

    public function logout(Request $r)
    {
        $user = Auth::user();
        $latestLoginRecord = DB::table('logactuser')
            ->where('user_id', $user->id)
            ->orderByDesc('login')
            ->first();

        if ($latestLoginRecord) {
            $logoutTime = Carbon::now();
            $timeDifferenceInMinutes = $logoutTime->diffInMinutes($latestLoginRecord->login);
            $formattedTime = ($timeDifferenceInMinutes >= 60) ? floor($timeDifferenceInMinutes / 60) . ' jam' : $timeDifferenceInMinutes . ' menit';
            DB::table('logactuser')
                ->where('id', $latestLoginRecord->id)
                ->update([
                    'logout' => $logoutTime->format('H:i'),
                    'total' => $formattedTime,
                ]);
        }

        // Auth::logout();
        Auth::guard('web')->logout();
        Session::forget('id_mch');
        return redirect('/');
    }
}
