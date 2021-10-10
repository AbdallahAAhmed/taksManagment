<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Category;
use App\Models\Project;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'ISManager']);
    }

    public function index()
    {
        return view('admin.users.index');
    }


    public function store(Request $request)
    {

        $this->validate(
            $request,
            [
                'username' => 'required|string|max:255|min:3|unique:users,username',
                'email' => 'required|unique:users,email',
                'phone' => 'nullable|unique:users,phone',
                'role' => 'required|in:manager,employee',
                'password' => 'required|confirmed|string|max:255|min:6',
            ],
            [
                'username.required' => 'المستخدم مطلوب',
                'username.string' => 'المستخدم يجب ان يكون قيمة نصية',
                'username.max' => 'المستخدم يجب الا يتعدي 255 حرف',
                'username.min' => 'يجب كتابة 3 احرف على الأقل',
                'username.unique' => 'المستخدم موجود مسبقآ',
                'email.required' => 'الإيميل مطلوب',
                'email.unique' => 'الإيميل مستخدم مسبقآ',
                'phone.unique' => 'الهاتف مستخدم مسبقآ',
                'password.required' => 'كلمة المرور مطلوبة',
                'password.confirmed' => 'كلمة المرور غير متطابقة',
                'password.min' => 'يجب كتابة 6 احرف على الأقل',
            ]
        );

        date_default_timezone_set('Asia/Hebron');
        unset($request['_token']);
        $username = $request->username;
        $user_email = $request->email;
        $user_phone = $request->phone;
        $user_role = $request->role;
        $user_password = bcrypt($request->password);

        $user = User::create([
            'username' => $username,
            'email' => $user_email,
            'phone' => $user_phone,
            'role' => $user_role,
            'password' => $user_password,
        ]);
        return response()->json(['status' => 1, "msg" => "تم إضافة المستخدم \"$username\" بنجاح"]);
    }

    public function AjaxDT(Request $request)
    {
        if (request()->ajax()) {
            $users = DB::table('users');

            $users->select([
                'users.id', 'users.username', 'users.email', 'users.phone', 'users.role',
                DB::raw("DATE_FORMAT(users.created_at, '%Y-%m-%d') as Date"),
            ])->groupBy('users.id', 'users.username')->get();

            return  DataTables::of($users)
                ->addColumn('actions', function ($users) {
                    return '<a href="/dashboard/users/edit/' . $users->id . '" class="Popup" data-toggle="modal"  data-id="' . $users->id . '"title="تعديل المستخدم"><i class="la la-edit icon-xl" style="color:blue;padding:4px"></i></a>
                            <a href="/dashboard/users/delete/' . $users->id . '" data-id="' . $users->id . '" class="ConfirmLink "' . ' id="' . $users->id . '"><i class="fa fa-trash-alt icon-md" style="color:red"></i></a>';
                })->rawColumns(['actions'])->make(true);
        }
    }


    public function create()
    {
        return view('admin.users.create');
    }


    public function edit($id)
    {
        $user = User::where('id', $id)->first();
        if ($user == null) {
            abort(404, 'المستخدم غير موجود');
        }
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'username' => 'required|string|max:255|min:3|unique:users,username,' . $id,
                'email' => 'required|unique:users,email,' . $id,
                'phone' => 'nullable|unique:users,phone,' . $id,
                'role' => 'required|in:manager,employee',

            ],
            [
                'username.required' => 'المستخدم مطلوب',
                'username.string' => 'المستخدم يجب ان يكون قيمة نصية',
                'username.max' => 'المستخدم يجب الا يتعدي 255 حرف',
                'username.min' => 'يجب كتابة 3 احرف على الأقل',
                'username.unique' => 'المستخدم موجود مسبقآ',
                'email.required' => 'الإيميل مطلوب',
                'email.unique' => 'الإيميل مستخدم مسبقآ',
                'phone.unique' => 'الهاتف مستخدم مسبقآ',
            ]
        );

        $user = User::where('id', $id)->first();
        $username = $request->username;
        date_default_timezone_set('Asia/Hebron');
        unset($request['_token']);

        $array = [];

        if ($request->username != $user->username) {
            $array['username'] = $request->username;
        }

        if ($request->email != $user->email) {
            $array['email'] = $request->email;
        }

        if ($request->phone != $user->phone) {
            $array['phone'] = $request->phone;
        }

        if ($request->role != $user->role) {
            $array['role'] = $request->role;
        }

        if ($request->password != '') {
            $array['password'] = Hash::make($request->password);
        }
        if (!empty($array)) {
            $user->update($array);
        }
        return response()->json(['status' => 1, "msg" => "تم تعديل المستخدم \"$username\" بنجاح"]);
    }

    public function delete($id)
    {
        $user = User::where('id', $id)->first();
        $category = Category::where('user_id', '=', $id)->first();
        $project = Project::where('user_id', '=', $id)->first();

        if ($category != null) {
            return response()->json(['status' => 2, "msg" => "لا يمكن الحذف لان المستخدم مرتبط ب قسم"]);
        } elseif (auth()->user()->id == $id) {
            return response()->json(['status' => 2, "msg" => "لا يمكن حذف المستخدم المسجل للدخول"]);
        } elseif ($project != null) {
            return response()->json(['status' => 2, "msg" => "لا يمكن حذف المستخدم لارتباطه ب مشروع"]);
        } else {
            $user->delete();
            return response()->json(['status' => 1, "msg" => "تم حذف المستخدم \"$user->username\" بنجاح"]);
        }
        return response()->json(['status' => 0, "msg" => "حدث خطأ ما"]);
    }
}
