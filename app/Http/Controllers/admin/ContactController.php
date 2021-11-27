<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\category_users;
use App\Models\Contact;
use App\Models\User;
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
                    return '<a href="/dashboard/contacts/edit/' . $contacts->id . '" class="Popup" data-toggle="modal"  data-id="' . $contacts->id . '"title="edit category"><i class="la la-edit icon-xl" style="color:blue;padding:4px"></i></a>
                            <a href="/dashboard/contacts/delete/' . $contacts->id . '" data-id="' . $contacts->id . '" class="ConfirmLink "' . ' id="' . $contacts->id . '"><i class="fa fa-trash-alt icon-md" style="color:red"></i></a>';
                })->editColumn('status', function ($contacts) {
                    return ($contacts->status == 1) ? "<span class='badge badge-primary'>Contact Completed</span>" : "<span class='badge badge-success'>Contact in progress</span>";
                })->editColumn('message', function ($contacts) {
                    return view('admin.contacts.message', compact('contacts'));
                })->addColumn('change_status', function ($contacts) {
                    return '<input type="checkbox" class="cbActive"  ' . ($contacts->status == "1" ? "checked" : "") . '  name="status" value="' . $contacts->id . '"/>';
                })->rawColumns(['actions', 'status', 'change_status'])->make(true);
        }
    }

    public function create()
    {
       $user_categories = User::with('categories')->where('id',parent::authId())->first();
       return view('admin.contacts.create',compact('user_categories'));
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
        );

        date_default_timezone_set('Asia/Hebron');
        unset($request['_token']);

        $title = $request->input('title');
        $message = $request->input('message');
        $category_id = $request->input('category_id');
        $user_id = parent::authId();
        $updated_at = Carbon::now();
        $created_at = Carbon::now();
        DB::insert('insert into contacts (title,message,category_id,user_id,created_at,updated_at) values (?,?,?,?,?,?)', [$title, $message, $category_id, $user_id, $created_at, $updated_at]);
        return response()->json(['status' => 1, "msg" => "Contact  \"$title\" Send Success"]);
    }

    public function edit($id)
    {
        $contact = $this->editContactData($id);
        if (!$contact) {
            abort(404, 'not found');
        }
        return view('admin.contacts.edit_category', compact('contact'));
    }

    public function myContactIndex()
    {
        return view('admin.contacts.my_contacts');
    }

    public function myContact()
    {

        if (request()->ajax()) {
            $my_contact = DB::table('contacts')
                ->Join('categories', 'categories.id', '=', 'contacts.category_id');

            $my_contact->select([
                'contacts.id', 'contacts.title', 'contacts.status', 'categories.name as category_name',
                DB::raw("DATE_FORMAT(contacts.created_at, '%Y-%m-%d') as Date"),
            ])->groupBy('contacts.id', 'contacts.title')->where('user_id', parent::authId())->get();


            return  DataTables::of($my_contact)
                ->addColumn('actions', function ($my_contact) {
                    return '<a href="/dashboard/contacts/edit-myContact/' . $my_contact->id . '" class="Popup" data-toggle="modal"  data-id="' . $my_contact->id . '"title="edit category"><i class="la la-edit icon-xl" style="color:blue;padding:4px"></i></a>';
                })->editColumn('status', function ($my_contact) {
                    return ($my_contact->status == 1) ? "<span class='badge badge-primary'>Contact Completed </span>" : "<span class='badge badge-success'>Contact in progress</span>";
                })->rawColumns(['actions', 'status'])->make(true);
        }
    }

    public function editContact($id)
    {
        $contact = $this->editContactData($id);
        if (!$contact) {
            abort(404, 'not found');
        }
        return view('admin.contacts.myContactedit_category', compact('contact'));
    }

    public function update(Request $request, $id)
    {
        $result = $this->UpdateContactData($request, $id);
        if ($result) {
            return response()->json(['status' => 1, "msg" => "Category Updated"]);
        } else {
            return response()->json(['status' => 0, "msg" => "Somthing went wrong"]);
        }
    }

    public function updateContact(Request $request, $id)
    {
        $result = $this->UpdateContactData($request, $id);
        if ($result) {
            return response()->json(['status' => 1, "msg" => "Category Updated"]);
        } else {
            return response()->json(['status' => 0, "msg" => "Somthing went wrong"]);
        }
    }

    public function activate($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->status = $contact->status == 1 ? '0' : '1';
        $contact->save();
        return response()->json(['status' => 1, "msg" => "Contact Status updated"/*,"redirect"=>"/unit"*/]);
    }

    public function delete($id)
    {
        $contact = Contact::where('id', $id)->first();
        if ($contact) {
            $contact->delete();
        }
        return response()->json(['status' => 1, "msg" => "Contact \"$contact->title\" deleted"]);
    }

    protected function editContactData($id)
    {
        $contact = Contact::where('id', $id)->select(['id', 'category_id'])->first();
        if ($contact != null) {
            return $contact;
        } else {
            return false;
        }
    }

    protected function UpdateContactData($request, $id)
    {
        try {
            $category_id = $request->category_id;
            $query =  DB::table('contacts')
                ->where('id', $id)
                ->update(['category_id' => $category_id]);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
