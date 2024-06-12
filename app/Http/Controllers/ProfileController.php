<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use App\Models\Notification;
use App\Models\Transaction;
use App\Models\Task;
use App\Models\TaskCompleted;
use App\Models\Socialmedia;
use App\Models\Withdrawal;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        $details = DB::table('user_details')->join('users', 'user_details.userid', '=', 'users.id')->where('user_details.userid', Auth::id())->first();
        $social = DB::table('socialmedia')->where('socialmedia.userid', '=', Auth::id())->first();
        $referred_by = DB::table('users')->where('id', '=', $details->referred_by)->first();

        $url = url('storage/' . $details->profile_photo);
        return view('profile.setting', [
            'user' => $request->user(),
            'details' => $details,
            'referred' => $this->checkReferer($referred_by),
            'social' => $social,
            'base' => $url,
            'title' => 'Profile',
            'header' => $this->user_details()
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function imageUpload(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'image' => ['required','image']
        ]);

        if($request->has('image')){
            $imagePath = $request->file('image')->store('profile', 'public');
            $validated['image'] = $imagePath;
        }

        $user_detail = DB::table('user_details')->where('userid', '=', Auth::id())->first();
        if($user_detail->profile_photo !== 'profile/default.jpg'){
            Storage::disk('public')->delete($user_detail->profile_photo);
        }
        $updated = DB::table('user_details')->where('userid', '=', Auth::id())->update([
            'profile_photo' => $validated['image']
        ]);
        
        return Redirect::route('profile.edit')->with('status', 'image-updated');
    }

    // update investment structure
    public function updateStructure(Request $request): RedirectResponse
    {
        $request->validate([
            'structure' => ['required']
        ]);
        $structure = DB::table('user_details')->where('userid', '=', Auth::id())->update(['structure' => $request->structure]);
        $detail = DB::table('user_details')->where('userid', '=', Auth::id())->first();
        $referer = DB::table('user_details')->where('userid', '=', $detail->referred_by)->first();

        if(!empty($referer)){
            $balance = DB::table('balance')->where('userid', $referer->userid)->first();
            DB::table('balance')->updateOrInsert(['userid' => $referer->userid], ['affiliate_balance' => $balance->affiliate_balance + $this->amountEarned($request->structure)]);
            DB::table('balance')->where('userid', '=', $referer->userid)->update([
                'total_balance' => $balance->affiliate_balance + $balance->task_balance
            ]);
            $transaction = Transaction::create([
                'userid' => $referer->userid,
                'transaction_name' => 'Referral bonus earned',
                'amount_earned' => $this->amountEarned($request->structure)
            ]);
            $notifications = Notification::create([
                'userid' => $referer->userid,
                'subject' => 'Referral Bonus of ' . $this->amountEarned($request->structure) . ' earned',
                'link_to' => 'transaction'
            ]);
        }

        return Redirect::route('profile.edit')->with('status', 'structure-updated');
    }

    // reset profile image
    public function resetProfileImage(): RedirectResponse
    {
        $user_detail = DB::table('user_details')->where('userid', '=', Auth::id())->first();
        if($user_detail->profile_photo !== 'profile/default.jpg'){
            Storage::disk('public')->delete($user_detail->profile_photo);
        }
        $user_image = DB::table('user_details')->where('userid', '=', Auth::id())->update(['profile_photo' => 'profile/default.jpg']);

        return Redirect::route('profile.edit')->with('status', 'image-reset');

    }

    // Update the user bank details
    public function bank(Request $request): RedirectResponse
    {
        $request->validate([
            'acc_no' => ['required', 'string', 'max:10'],
            'bankname' => ['required', 'string', 'max:255'],
            'acc_name' => ['required', 'string', 'max:255']
        ]);

        $bank = DB::table('user_details')->where('userid', Auth::id())->update([
            'bank_name' => $request->bankname,
            'account_name' => $request->acc_name,
            'account_number' => $request->acc_no
        ]);

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    // Update the user social media
    public function updateSocials(Request $request): RedirectResponse
    {
        $request->validate([
            'facebook' => ['string'],
            'whatsapp' => ['string'],
            'x' => ['string'],
            'telegram' => ['string'],
        ]);

        $bank = DB::table('socialmedia')->updateOrInsert(['userid' => Auth::id()], [
            'facebook' => $request->facebook,
            'whatsapp' => $request->whatsapp,
            'x' => $request->x,
            'telegram' => $request->telegram,
        ]);

        return Redirect::route('profile.edit')->with('status', 'social-updated');
    }

    // Transaction view
    public function transaction(){
        $details = DB::table('user_details')->where('userid', Auth::id())->first();
        $transactions = DB::table('transactions')->where('userid', '=', Auth::id())->orderBy('created_at', 'desc')->paginate(15);
        $url = url('storage/' . $details->profile_photo);
        DB::table('transactions')->where(['userid' => Auth::id(), 'state' => 'new'])->update(['state' => 'seen']);

        return view('profile.transaction', [
            'transactions' => $transactions,
            'title' => 'Transactions',
            'base' => $url,
            'header' => $this->user_details()
        ]);
    }

    // withdrawal view
    public function withdraw(){
        $balance = DB::table('balance')->where('userid', Auth::id())->first();
        $details = DB::table('user_details')->where('userid', Auth::id())->first();
        $url = url('storage/' . $details->profile_photo);
        $history = DB::table('withdrawals')->where(['userid' => Auth::user()->id, 'state' => 'success'])->get();
        return view('profile.withdraw', [
            'balance' => $balance,
            'details' => $details,
            'base' => $url,
            'history' => $history,
            'title' => 'Withdrawal',
            'header' => $this->user_details()
        ]);
    }

    // request withdrawal
    public function requestwithdrawal(Request $request): RedirectResponse
    {

        $request->validate([
            'wallet' => ['string'],
            'affiliate' => ['string'],
            'task' => ['string'],
            'amount' => ['required','integer'],
        ]);
        $balance = DB::table('balance')->where('userid', '=', Auth::user()->id)->first();

        if($request->amount < 5000){
            return Redirect::route('withdraw')->with('status','minimun');
        }


        if($request->wallet == 'affiliate'){
            if($request->amount <= $balance->affiliate_balance){
                $withdrawal = Withdrawal::create([
                    'userid' => Auth::user()->id,
                    'amount' => $request->amount,
                    'wallet' => $request->wallet
                ]);

                $bal = $balance->affiliate_balance - $request->amount;
                DB::table('balance')->where('userid', '=', Auth::user()->id)->update([
                    'affiliate_balance' => $bal
                ]);
                return Redirect::route('withdraw.submit')->with('status','request-submitted');
            }
            else{
                return Redirect::route('withdraw')->with('status','insufficient-balance');
            }
        }

        if($request->wallet == 'task'){
            if($request->amount <= $balance->task_balance){
                $withdrawal = Withdrawal::create([
                    'userid' => Auth::user()->id,
                    'amount' => $request->amount,
                    'wallet' => $request->wallet
                ]);

                $bal = $balance->task_balance - $request->amount;
                DB::table('balance')->where('userid', '=', Auth::user()->id)->update([
                    'task_balance' => $bal
                ]);
                return Redirect::route('withdraw.submit')->with('status','request-submitted');
            }
            else{
                return Redirect::route('withdraw')->with('status','insufficient-balance');
            }
        }
    }

    // submitted withdrawal
    public function withdrawsubmitted(){
        $details = DB::table('user_details')->where('userid', Auth::id())->first();
        $url = url('storage/' . $details->profile_photo);
        return view('profile.submitwithdraw', [
            'title' => 'Withdraw Success',
            'base' => $url,
            'header' => $this->user_details()
        ]);
    }

    // referals view
    public function referal(){
        $details = DB::table('user_details')->where('userid', Auth::id())->first();
        $myref = DB::table('user_details')->join('users', 'users.id', '=', 'user_details.userid')->where('referred_by', '=', Auth::id())->orderBy('user_details.created_at', 'desc')->paginate(15);
        $refs = DB::table('user_details')->join('users', 'users.id', '=', 'user_details.userid')->select('users.username', 'user_details.*')->where('referees', '>', 0) ->orderBy('referees', 'desc')->limit(10)->get();
        $url = url('storage/' . $details->profile_photo);
        $link = url('storage/');
        return view('profile.referal', [
            'referees' => $myref,
            'refs' => $refs,
            'link' => $link,
            'title' => 'Referal',
            'base' => $url,
            'header' => $this->user_details()
        ]);
    }

    // Notification view
    public function notification(){
        $details = DB::table('user_details')->where('userid', Auth::id())->first();
        $new_notifications = DB::table('notifications')->where(['userid' => Auth::id(), 'state'=> 'new'])->get();
        $notification = DB::table('notifications')->where('userid', '=', Auth::id())->orderBy('created_at', 'desc')->paginate(15);
        $url = url('storage/' . $details->profile_photo);
        DB::table('notifications')->where(['userid' => Auth::id(), 'state'=> 'new'])->update(['state' => 'seen']);

        return view('profile.notification',[
            'notification' => $notification,
            'title' => 'Notifications',
            'base' => $url,
            'header' => $this->user_details()
        ]);

    }

    // Tasks views
    public function tasks(Request $request){
        $details = DB::table('user_details')->where('userid', Auth::id())->first();
        // $tasks = DB::table('tasks')->where('tasks.state', '=', 'active')->inRandomOrder()->paginate(20);
        $tasks = DB::table('tasks')->whereNotIn('id', function($query){
            $query->select('task_completed.taskid')->from('task_completed')->where('task_completed.userid', Auth::user()->id);
        })->where('state','active')->inRandomOrder()->paginate(20);
        $completed = DB::table('task_completed')->join('tasks', 'task_completed.taskid', '=', 'tasks.id')->select('task_completed.*', 'tasks.description', 'tasks.sm', 'tasks.amount', 'tasks.type')->where(['task_completed.userid' => Auth::user()->id, 'task_completed.state' => 'approved'])->get();
        $url = url('storage/' . $details->profile_photo);

        if($request->session()->has('task')){
            return redirect()->route('runtask', ['id' => session('task')]);
        }
        return view('profile.tasks',[
            'title' => 'Tasks',
            'base' => $url,
            'tasks' => $tasks,
            'completed' => $completed,
            'running' => $request->session()->has('task'),
            'header' => $this->user_details()
        ]);
    }

    // running tasks
    public function runtask(int $id){
        $details = DB::table('user_details')->where('userid', Auth::id())->first();
        $url = url('storage/' . $details->profile_photo);
        $task = DB::table('tasks')->where('id', '=', $id)->first();

        if(count(DB::table('task_completed')->where(['taskid' => $id, 'userid' => Auth::id()])->get()) > 0  ){
            return Redirect::route('tasks');
        }
        else{
            session(['task' => $id]);
            return view('profile.runningtask', [
                'title' => 'Running Task',
                'header' => $this->user_details(),
                'task' => $task,
                'base' => $url,
            ]);
        }
    }

    // submit task
    public function submittask(Request $request){

        $details = DB::table('user_details')->where('userid', Auth::id())->first();
        $url = url('storage/' . $details->profile_photo);

        if(!$request->session()->has('task')){
            return redirect()->route('tasks');
        }
        $submit_task = session('task');
        $task = DB::table('tasks')->where('id', '=', $submit_task)->first();
        $submitted = TaskCompleted::create([
            'userid' => Auth::user()->id,
            'taskid' => $task->id
        ]);

        $task_limit = DB::table('task_completed')->where('taskid', $task->id)->get();
        
        if($task_limit->count() == $task->limit){
            $closed = DB::table('tasks')->where('id', $task->id)->update([
                'state' => 'closed'
            ]);
        }
        $request->session()->pull('task', 'default');

        return view('profile.submitted', [
            'title' => 'Task submitted',
            'header' => $this->user_details(),
            'base' => $url,
        ]);
    }

    // cancel task
    public function canceltask(Request $request){
        $request->session()->pull('task', 'default');

        return redirect()->route('tasks');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        $userid = $user->id;
        $user_detail = DB::table('user_details')->where('userid', '=', $userid)->first();
        if($user_detail->profile_photo != 'profilepic url'){
            Storage::disk('public')->delete($user_detail->profile_photo);
        }

        Auth::logout();

        $user->delete();
        // $deleted = DB::table('users')->where('id', $userid)->cascadeDelete(['user_details', 'balance', 'notifications', 'socialmedia', 'transactions', 'withdrawals']);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    // check if user have referer
    public function checkReferer($referer){
        if(!empty($referer)){
            return $referer;
        }
        else{
            return 'empty';
        }
    }

    // return amount earned based on the user structure
    public function amountEarned($structure){
        if($structure == 1){
            return 2000;
        }
        elseif($structure == 2){
            return 4000;
        }
        elseif($structure == 3){
            return 8000;
        }
        elseif($structure == 4){
            return 20000;
        }
        elseif($structure == 5){
            return 40000;
        }
    }

    static function marknav(string $title, string $nav){
        if($title == $nav){
            return 'bg-blue-600 text-white rounded-r-[100px]';
        }
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
