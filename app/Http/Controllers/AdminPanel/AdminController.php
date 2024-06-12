<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Task;
use App\Models\Notification;
use App\Models\Transaction;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(){
        $users = DB::table('users')->where('role', '=', 'user')->get();
        $tasks = DB::table('task_completed')->where('state', '=', 'approved')->get();
        $withdrawal = DB::table('withdrawals')->get();
        $today = DB::table('users')->join('user_details', 'users.id', '=', 'user_details.userid')->whereDate('users.created_at', '=', date('Y-m-d'))->where('role', '=', 'user')->limit(15)->get();
        $blogs = DB::table('blogs')->get();
        $pending_tasks = DB::table('task_completed')->join('tasks', 'task_completed.taskid', '=', 'tasks.id')->join('users', 'task_completed.userid', '=', 'users.id')->join('user_details', 'users.id', '=', 'user_details.userid')->join('socialmedia', 'users.id', '=', 'socialmedia.userid')->select('task_completed.*', 'users.fullname', 'socialmedia.facebook', 'socialmedia.whatsapp', 'socialmedia.x', 'socialmedia.telegram', 'tasks.type', 'tasks.amount', 'tasks.description', 'tasks.link', 'tasks.sm')->where('task_completed.state', '=', 'pending')->limit(10)->get();
        $pending_withdrawals = DB::table('withdrawals')->where('state', '=', 'pending')->get();


        return view('admin.dashboard',[
            'title' => 'Admin Dashboard',
            'users' => $users,
            'tasks' => $tasks,
            'withdrawals' => $withdrawal,
            'blogs' => $blogs,
            'pending_tasks' => $pending_tasks,
            'today' => $today,
            'pending_withdrawals' => $pending_withdrawals
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        $details = DB::table('user_details')->join('users', 'user_details.userid', '=', 'users.id')->where('user_details.userid', Auth::id())->first();
        
        return view('admin.setting', [
            'user' => $request->user(),
            'details' => $details,
            'title' => 'Profile',
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

        return Redirect::route('admin.profile')->with('status', 'profile-updated');
    }

    // the admins view
    public function admins(){
        $admins = DB::table('users')->where('role', '=', 'admin')->paginate(15);

        if(Auth::user()->id == 1 || Auth::user()->id == 2 || Auth::user()->id == 3){
            return view('admin.admins', [
                'title' => 'View Admins',
                'users' => $admins,
            ]);
        }
        else{
            return Redirect::route('admin.dashboard');
        }
    }

    // add admin view
    public function addadmin(){

        if(Auth::user()->id == 1 || Auth::user()->id == 2 || Auth::user()->id == 3){
            return view('admin.addadmin', [

                'title' => 'Add Admins',
            ]);
        }
        else{
            return Redirect::route('admin.dashboard');
        }

    }

    // register new admin
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'username' => ['required', 'string', 'max:255'],
            'tel' => ['required', 'integer'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        
        $user = User::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'username' => $request->username,
            'tel' => $request->tel,
            'role' => 'admin',
            'password' => Hash::make($request->password),
        ]);

        return Redirect::route('admin.admins');
    }

    // remove admin
    public function removeadmin(int $id): RedirectResponse
    {
        $removed = DB::table('users')->where(['id' => $id, 'role' => 'admin'])->delete();
        return Redirect::route('admin.admins');
    }

    // users view
    public function users(){
        // $user = Auth::user();
        $details = DB::table('user_details')->where('userid', Auth::user()->id)->first();
        $url = url('storage/');
        $users = DB::table('users')->join('user_details', 'users.id', '=', 'user_details.userid')->where('role', '=', 'user')->paginate(30);

        return view('admin.users', [
            'users' => $users,
            'base' => $url,
            'details' => $details,
            'title' => 'Users'
        ]);
    }

    //search users
    public function search(Request $request){
        $request->validate([
            'search' => ['string', 'max:255']
        ]);

        $details = DB::table('user_details')->where('userid', Auth::user()->id)->first();
        
        $url = url('storage/');
        if($request->search != " "){
            $users = DB::table('users')->join('user_details', 'users.id', '=', 'user_details.userid')->where('users.fullname', '=', $request->search)->paginate(25);
            return view('admin.search', [
                'users' => $users,
                'base' => $url,
                'title' => 'Users Search',
                'keyword' => $request->search
            ]);
        }

        else{
            $users = DB::table('users')->join('user_details', 'users.id', '=', 'user_details.userid')->orderBy('fullname', 'desc')->paginate(25);
            return view('admin.search', [
                'users' => $users,
                'base' => $url,
                'title' => 'Users Search',
                'keyword' => $request->search
            ]);
        }
    }

    // pending withdrawal view
    public function pendingwithdraw(){

        $withdrawal = DB::table('withdrawals')->join('users', 'withdrawals.userid', '=', 'users.id')->join('user_details','users.id', '=', 'user_details.userid')->where('withdrawals.state', '=', 'pending')->select('withdrawals.*', 'users.fullname', 'user_details.bank_name', 'user_details.profile_photo', 'user_details.account_name', 'user_details.account_number')->paginate(15);

        return view('admin.withdrawal', [
            'withdrawals' => $withdrawal,
            'title' => 'Pending Withdrawals'
        ]);
    }

    // approve withdrawal
    public function approvewithdraw(int $id){
        $withdrawal = DB::table('withdrawals')->where(['state' => 'pending', 'id' => $id])->first();
        if($withdrawal != null){
            $success = DB::table('withdrawals')->where(['state' => 'pending', 'id' => $id])->update(['state' => 'success']);
            $notification = Notification::create([
                'userid' => $withdrawal->userid,
                'subject' => $withdrawal->amount . ' Withdrawal Successful',
                'link_to' => 'transaction'
            ]);
            $transaction = Transaction::create([
                'userid' => $withdrawal->userid,
                'transaction_name' => 'Withdrwal Approed',
                'amount_earned' => $withdrawal->amount
            ]);
        }
        return Redirect::route('pending.withdrawal');
    }

    // decline withdrawal
    public function declinewithdraw(int $id){
        $withdrawal = DB::table('withdrawals')->where(['state' => 'pending', 'id' => $id])->first();
        $balance = DB::table('balance')->where('userid', $withdrawal->userid)->first();
        if($withdrawal != null){
            if($withdrawal->wallet == 'task'){
                $refund = DB::table('balance')->where(['userid' => $withdrawal->userid])->update(['task_balance' => $balance->task_balance + $withdrawal->amount]);
            }
            if($withdrawal->wallet == 'affiliate'){
                $refund = DB::table('balance')->where(['userid' => $withdrawal->userid])->update(['affiliate_balance' => $balance->affiliate_balance + $withdrawal->amount]);
            }
            $notification = Notification::create([
                'userid' => $withdrawal->userid,
                'subject' => $withdrawal->amount . ' Withdrawal Declined',
                'link_to' => 'transaction'
            ]);
            $transaction = Transaction::create([
                'userid' => $withdrawal->userid,
                'transaction_name' => 'Refund on Declined Withdrawal',
                'amount_earned' => $withdrawal->amount
            ]);
            $declined = DB::table('withdrawals')->where(['state' => 'pending', 'id' => $id])->delete();
            return Redirect::route('pending.withdrawal');
        }
    }

    //tasks views
    public function tasks(){
        $tasks = DB::table('tasks')->where('state', '=', 'active')->inRandomOrder()->paginate(20);
        $pending = DB::table('task_completed')->where('state', '=', 'pending')->get();

        return view('admin.tasks', [
            'title' => 'Tasks',
            'tasks' => $tasks,
            'pending' => $pending
        ]);
    }

    //create tasks view
    public function create_tasks(){
        
        return view('admin.create_task', [
            'title' => 'Create Task'
        ]);
    }

    // edit task view
    public function edit_task(int $id){
        $tasks = DB::table('tasks')->where('id', '=', $id)->first();

        return view('admin.edit_task', [
            'tasks' => $tasks,
            'title' => 'Edit Task'
        ]);
    }

    // create task
    public function newtask(Request $request): RedirectResponse
    {

        $request->validate([
            'description' => ['required', 'string'],
            'url' => ['required', 'string'],
            'social' => ['required', 'string'],
            'type' => ['required', 'string'],
            'limit' => ['required', 'integer'],
            'amount' => ['required', 'integer'],
        ]);

        $task = Task::create([
            'userid' => Auth::user()->id,
            'description' => $request->description,
            'link' => $request->url,
            'sm' => $request->social,
            'type' => $request->type,
            'limit' => $request->limit,
            'amount' => $request->amount,
        ]);
        return Redirect::route('admin.tasks')->with(['status' => 'Task_successful']);
    }

    // update task
    public function updatetask(Request $request): RedirectResponse
    {
        $request->validate([
            'id' => ['integer'],
            'description' => ['required', 'string'],
            'url' => ['required', 'string'],
            'social' => ['required', 'string'],
            'type' => ['required', 'string'],
            'limit' => ['required', 'integer'],
            'amount' => ['required', 'integer'],
        ]);

        $tasks = DB::table('tasks')->where('id', '=', $request->id)->update([
            'userid' => Auth::user()->id,
            'description' => $request->description,
            'link' => $request->url,
            'sm' => $request->social,
            'type' => $request->type,
            'limit' => $request->limit,
            'amount' => $request->amount,
        ]);
        return Redirect::route('admin.tasks')->with(['status' => 'Task_updated']);
    }

    // pending tasks view
    public function pending_tasks(){
        $pending_tasks = DB::table('task_completed')->join('tasks', 'task_completed.taskid', '=', 'tasks.id')->join('users', 'task_completed.userid', '=', 'users.id')->join('user_details', 'users.id', '=', 'user_details.userid')->join('socialmedia', 'users.id', '=', 'socialmedia.userid')->select('task_completed.*', 'users.fullname', 'socialmedia.facebook', 'socialmedia.whatsapp', 'socialmedia.x', 'socialmedia.telegram', 'tasks.type', 'tasks.amount', 'tasks.description', 'tasks.link', 'tasks.sm')->where('task_completed.state', '=', 'pending')->paginate(10);
        $pending_task = DB::table('task_completed')->where('state', 'pending')->get();

        return view('admin.pendingtasks', [
            'title' => 'Pending Tasks',
            'tasks' => $pending_tasks,
            'pending' => $pending_task
        ]);
    }

    // approve task 
    public function approve_task(int $id): RedirectResponse
    {
        $task = DB::table('task_completed')->join('tasks', 'task_completed.taskid', '=', 'tasks.id' )->join('users', 'task_completed.userid', '=', 'users.id' )->join('balance', 'users.id', '=', 'balance.userid' )->where(['task_completed.id' => $id, 'task_completed.state' => 'pending'])->first();
        //update balance, notification, task_completed tables
        if($task != null){
            $approved = DB::table('task_completed')->where(['id' => $id])->update(['state' => 'approved']);
            $balance = DB::table('balance')->where(['userid' => $task->userid])->update(['task_balance' => $task->task_balance + $task->amount]);
            $notification = Notification::create([
                'userid' => $task->userid,
                'subject' => $task->amount . ' earned from task',
                'link_to' => 'task'
            ]);
            $transaction = Transaction::create([
                'userid' => $task->userid,
                'transaction_name' => 'Earning From Task',
                'amount_earned' => $task->amount
            ]);
        }
        return Redirect::route('admin.pending');

    }

    // decline task 
    public function decline_task(int $id){
        $task = DB::table('task_completed')->where(['id'=> $id, 'state' => 'pending'])->delete();
        return Redirect::route('admin.pending');
    }

    // delete task
    public function delete_task(int $id): RedirectResponse
    {
        $remove = DB::table('tasks')->where('id', '=', $id)->update([
            'state' => 'closed'
        ]);

        return Redirect::route('admin.tasks')->with(['status' => 'Task_removed']);
    }

    // blog posts controller
    public function blogs(){
        // $details = DB::table('user_details')->where('userid', Auth::id())->first();
        $blogs = DB::table('blogs')->join('users', 'users.id', '=', 'blogs.author')->select('users.username', "blogs.*")->where('author_role', 'admin')->inRandomOrder()->paginate(20);
        $recent = DB::table('blogs')->join('users', 'users.id', '=', 'blogs.author')->select('users.username', "blogs.*")->where('author_role', 'admin')->orderBy('created_at', 'desc')->limit(15)->get();

        // $url = url('storage/' . $details->profile_photo);
        return view('admin.index', [
            'blogs' => $blogs,
            'recent' => $recent,
            'title' => 'Blogs',
            'url' => url('storage/'),
            // 'base' => $url,
            // 'header' => $this->user_details()
        ]);
    }

    // read blog post
    public function read(int $id, string $title){
        // $details = DB::table('user_details')->where('userid', Auth::id())->first();
        $single = DB::table('blogs')->join('users', 'users.id', '=', 'blogs.author')->select('users.username', "blogs.*")->where(['blogs.id' => $id, 'blogs.title' => $title])->first();
        $blogs = DB::table('blogs')->join('users', 'users.id', '=', 'blogs.author')->select('users.username', "blogs.*")->where('author_role', 'admin')->inRandomOrder()->get();
        $recent = DB::table('blogs')->join('users', 'users.id', '=', 'blogs.author')->select('users.username', "blogs.*")->where('author_role', 'admin')->orderBy('created_at', 'desc')->limit(15)->get();

        // $url = url('storage/' . $details->profile_photo);
        return view('admin.post', [
            'single' => $single,
            'blogs' => $blogs,
            'recent' => $recent,
            'title' => $title,
            'url' => url('storage/'),
            // 'base' => $url,
            // 'header' => $this->user_details()
        ]);
    }
    static function details(){
        
        // $pending_tasks = DB::table('task_completed')->join('tasks', 'task_completed.taskid', '=', 'tasks.id')->join('users', 'task_completed.userid', '=', 'users.id')->join('user_details', 'users.id', '=', 'user_details.userid')->join('socialmedia', 'users.id', '=', 'socialmedia.userid')->select('task_completed.*', 'users.fullname', 'socialmedia.facebook', 'socialmedia.whatsapp', 'socialmedia.x', 'socialmedia.telegram', 'tasks.type', 'tasks.amount', 'tasks.description', 'tasks.link', 'tasks.sm')->where('task_completed.state', '=', 'pending')->limit(10)->get();
        $pending_tasks = DB::table('task_completed')->where('state', 'pending')->get();
        $pending_withdrawals = DB::table('withdrawals')->where('state', '=', 'pending')->get();
        
        // pass all user necesarry data to the view
        $nav = [
            'task' => $pending_tasks,
            'withdrawal' => $pending_withdrawals
        ];

        return $nav;
    }
    static function marknav(string $title, string $nav){
        if($title == $nav){
            return 'bg-blue-600 text-white rounded-r-[100px]';
        }
    }

}
