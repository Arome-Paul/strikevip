<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Balance;
use App\Models\TaskCompleted;
use App\Models\Transaction;
use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use App\Models\UserDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(Request $request)
    {

        if(Auth::user()->role === 'admin'){
            return redirect()->route('admin.dashboard');
        }
        
        $user = Auth::user();
        $balance = DB::table('balance')->where('userid', $user->id)->first();
        $details = DB::table('user_details')->where('userid', $user->id)->first();
        $tasks = DB::table('task_completed')->where(['userid' => $user->id, 'state' => 'approved'])->get();
        $transactions = DB::table('transactions')->where('userid', $user->id)->orderBy('created_at', 'desc')->limit(10)->get();
        $referees = DB::table('users')->join('user_details', 'users.id', '=', 'user_details.userid')->select('users.*', "user_details.referred_by", 'user_details.profile_photo')->where('user_details.referred_by', '=', $user->id)->orderBy('users.created_at', 'desc')->limit(10)->get();

        $url = url('storage/' . $details->profile_photo);
        $link = url('storage/');
        return View::make('home', [
            'balance' => $balance,
            'details' => $details,
            'tasks' => $tasks,
            'transactions' => $transactions,
            'referees' => $referees,
            'ref_no' => $referees->count(),
            'title' => 'Dashboard',
            'base' => $url,
            'link' => $link,
            'header' => $this->user_details()
        ]);
    }
    public function user_details(){
        
        $details = DB::table('user_details')->where('userid', '=', Auth::id())->first();
        $notification = DB::table('notifications')->where(['userid' => Auth::id(), 'state' => 'new'])->get();
        $transaction = DB::table('transactions')->where(['userid' => Auth::id(), 'state' => 'new'])->get();
        
        // pass all user necesarry data to the view
        $nav_header = [
            'details' => $details,
            'notification' => $notification,
            'transaction' => $transaction
        ];

        return $nav_header;
    }
}
