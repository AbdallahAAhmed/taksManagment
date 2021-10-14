<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ContactController extends Controller
{
    
    public function __construct()
    {
        return $this->middleware(['auth', 'ISManager'], ['only' => ['index', 'delete', 'activate', 'edit']]);
    }

    public function index()
    {
        return view('admin.contacts.index');
    }

    public function AjaxDT(Request $request)
    {
        if (request()->ajax()) {
            $contacts = DB::table('contacts')
                ->join('users', 'users.id', '=', 'contacts.user_id')
                ->join('categories', 'categories.id', '=', 'contacts.category_id');

            $contacts->select([
                'contacts.*', 'users.username as username', 'categories.name as category_name',
                DB::raw("DATE_FORMAT(contacts.created_at, '%Y-%m-%d') as Date"),
            ])->groupBy('contacts.id', 'contacts.title')->get();

            return  DataTables::of($contacts)
                ->addColumn('actions', function ($contacts) {
                    return '<a href="/dashboard/contacts/edit/' . $contacts->id . '" class="Popup" data-toggle="modal"  data-id="' . $contacts->id . '"title="تغيير القسم"><i class="la la-edit icon-xl" style="color:blue;padding:4px"></i></a>
                            <a href="/dashboard/contacts/delete/' . $contacts->id . '" data-id="' . $contacts->id . '" class="ConfirmLink "' . ' id="' . $contacts->id . '"><i class="fa fa-trash-alt icon-md" style="color:red"></i></a>';
                })->editColumn('status', function ($contacts) {
                    return ($contacts->status == 1) ? "<span class='badge badge-primary'>تمت معالجة الطلب</span>" : "<span class='badge badge-success'>قيد المعالجة</span>";
                })->editColumn('message', function ($contacts) {
                    return view('admin.contacts.message', compact('contacts'));
                })->addColumn('change_status', function ($contacts) {
                    return '<input type="checkbox" class="cbActive"  ' . ($contacts->status == "1" ? "checked" : "") . '  name="status" value="' . $contacts->id . '"/>';
                })->rawColumns(['actions', 'status', 'change_status'])->make(true);
        }
    }

    public function create()
    {
        return view('admin.contacts.create');
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'title' => 'required|min:6',
                'message' => 'required|min:8|max:255',
                'category_id' => 'required|integer',
            ],
            [
                'title.required' => 'عنوان الطلب مطلوب',
                'message.required' => 'نص الرسالة مطلوب',
                'title.min' => 'عنوان الطلب: يجب كتابة 6 أحرف على الأقل',
                'message.min' => 'الرسالة: يجب كتابة 6 أحرف على الأقل',
                'message.max' => 'الحد الأعلى المسموح للأحرف 255',
                'category_id.required' => 'القسم مطلوب',
                'category_id.integer' => 'القسم يجب ان يكون قيمة رقمية صحيحة',
            ]
        );

        date_default_timezone_set('Asia/Hebron');
        unset($request['_token']);

        $title = $request->input('title');
        $message = $request->input('message');
        $category_id = $request->input('category_id');
        $user_id = auth()->user()->id;
        $updated_at = Carbon::now();
        $created_at = Carbon::now();
        DB::insert('insert into contacts (title,message,category_id,user_id,created_at,updated_at) values (?,?,?,?,?,?)', [$title, $message, $category_id, $user_id, $created_at, $updated_at]);
        return response()->json(['status' => 1, "msg" => "تم ارسال الطلب \"$title\" بنجاح"]);
    }

    public function edit($id)
    {
        $contact = Contact::where('id', $id)->select(['id', 'category_id'])->first();
        if ($contact == null) {
            abort(404, 'الطلب غير موجود');
        }
        return view('admin.contacts.edit_category', compact('contact'));
    }

    public function myContactIndex()
    {
        return view('admin.contacts.my_contacts');
    }

    public function myContact()
    {

        $id = auth()->user()->id;
        if (request()->ajax()) {
            $my_contact = DB::table('contacts')
                ->Join('categories', 'categories.id', '=', 'contacts.category_id');

            $my_contact->select([
                'contacts.id', 'contacts.title', 'contacts.status', 'categories.name as category_name',
                DB::raw("DATE_FORMAT(contacts.created_at, '%Y-%m-%d') as Date"),
            ])->groupBy('contacts.id', 'contacts.title')->where('user_id', $id)->get();


            return  DataTables::of($my_contact)
                ->addColumn('actions', function ($my_contact) {
                    return '<a href="/dashboard/contacts/edit-myContact/' . $my_contact->id . '" class="Popup" data-toggle="modal"  data-id="' . $my_contact->id . '"title="تغيير القسم"><i class="la la-edit icon-xl" style="color:blue;padding:4px"></i></a>';
                })->editColumn('status', function ($my_contact) {
                    return ($my_contact->status == 1) ? "<span class='badge badge-primary'>تمت معالجة الطلب</span>" : "<span class='badge badge-success'>قيد المعالجة</span>";
                })->rawColumns(['actions', 'status'])->make(true);
        }
    }

    public function editContact($id)
    {
        $contact = Contact::where('id', $id)->select(['id', 'category_id'])->first();
        if ($contact == null) {
            abort(404, 'الطلب غير موجود');
        }
        return view('admin.contacts.myContactedit_category', compact('contact'));
    }

    public function update(Request $request, $id)
    {
        // $contact->update([
        //     'category_id' => $request->category_id
        // ]);

        $category_id = $request->category_id;
        $query =  DB::table('contacts')
        ->where('id', $id)
            ->update(['category_id' => $category_id]);
        if ($query) {
            return response()->json(['status' => 1, "msg" => "تم تغير القسم بنجاح"]);
        }
    }

    public function updateContact(Request $request, $id)
    {

        $contact = Contact::where('id',$id)->first();
        $contact->update([
            'category_id' => $request->category_id
        ]);
        return response()->json(['status' => 1, "msg" => "تم تغير القسم بنجاح"]);

        // $category_id = $request->category_id;
        // $query =  DB::table('contacts')
        //     ->where('id', $id)
        //     ->update(['category_id' => $category_id]);
        // if ($query) {
        //     return response()->json(['status' => 1, "msg" => "تم تغير القسم بنجاح"]);
        // }
    }

    public function activate($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->status = $contact->status == 1 ? '0' : '1';
        $contact->save();
        return response()->json(['status' => 1, "msg" => "تم تعديل حالة الطلب بنجاح"/*,"redirect"=>"/unit"*/]);
    }

    public function delete($id)
    {
        $contact = Contact::where('id', $id)->first();
        if ($contact) {
            $contact->delete();
        }
        return response()->json(['status' => 1, "msg" => "تم حذف الطلب \"$contact->title\" بنجاح"]);
    }
}
