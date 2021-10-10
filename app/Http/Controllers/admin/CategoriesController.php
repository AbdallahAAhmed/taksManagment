<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\UploadImageTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;



class CategoriesController extends Controller
{

    use UploadImageTrait;

    public function __construct()
    {
        $this->middleware(['auth', 'ISManager']);
    }

    public function index()
    {
        return view('admin.categories.index');
    }


    public function store(Request $request)
    {

        $this->validate(
            $request,
            [
                'name' => 'required|string|max:255|min:3|unique:categories,name',
                'icon' => 'nullable|image',
                'user_id' => 'required',
            ],
            [
                'name.required' => 'القسم مطلوب',
                'name.string' => 'القسم يجب ان يكون قيمة نصية',
                'name.max' => 'القسم يجب الا يتعدي 255 حرف',
                'name.min' => 'يجب كتابة 3 احرف على الأقل',
                'name.unique' => 'القسم موجود مسبقآ',
                'user_id.required' => 'المستخدم مطلوب',
                'icon.image' => 'الإيقونة يجب ان تكون صورة بصيغة jpg|png|jpeg',
            ]
        );

        date_default_timezone_set('Asia/Hebron');
        unset($request['_token']);
        $icon = NULL;
        if ($request->hasFile('icon')) {
            $icon =  $this->saveImages($request->icon, 'images/categories/icon');
        }
        $cat_name = $request->name;
        $cat_user_id = $request->user_id;
        $updated_at = Carbon::now();
        $created_at = Carbon::now();
        DB::insert('insert into categories (name,user_id,icon,created_at,updated_at) values (?,?,?,?,?)', [$cat_name, $cat_user_id, $icon, $created_at, $updated_at]);
        return response()->json(['status' => 1, "msg" => "تم إضافة القسم \"$cat_name\" بنجاح"]);
    }

    public function AjaxDT(Request $request)
    {
        if (request()->ajax()) {
            $categories = DB::table('categories')
                ->Join('users', 'users.id', '=', 'categories.user_id');

            $categories->select([
                'categories.*', 'users.username as username',
                DB::raw("DATE_FORMAT(categories.created_at, '%Y-%m-%d') as Date"),
            ])->groupBy('categories.id', 'categories.name')->get();

            return  DataTables::of($categories)
                ->addColumn('actions', function ($categories) {
                    return '<a href="/dashboard/categories/edit/' . $categories->id . '" class="Popup" data-toggle="modal"  data-id="' . $categories->id . '"title="تعديل الصنف"><i class="la la-edit icon-xl" style="color:blue;padding:4px"></i></a>
                            <a href="/dashboard/categories/delete/' . $categories->id . '" data-id="' . $categories->id . '" class="ConfirmLink "' . ' id="' . $categories->id . '"><i class="fa fa-trash-alt icon-md" style="color:red"></i></a>';
                })->addColumn('icon', function ($categories) {
                    $url = asset('images/categories/icon/' . $categories->icon);
                    return '<img src="' . $url . '" border="0" style="border-radius: 10px;" width="40" class="img-rounded" align="center" />';
                })->rawColumns(['actions', 'status', 'icon'])->make(true);
        }
    }


    public function create()
    {
        return view('admin.categories.create');
    }


    public function edit($id)
    {
        $category = Category::where('id', $id)->first();
        if ($category == null) {
            abort(404, 'القسم غير موجود');
        }
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|string|max:255|min:3|unique:categories,name,' . $id,
                'icon' => 'nullable|image',
                'user_id' => 'required',
            ],
            [
                'name.required' => 'القسم مطلوب',
                'name.string' => 'القسم يجب ان يكون قيمة نصية',
                'name.max' => 'القسم يجب الا يتعدي 255 حرف',
                'name.min' => 'يجب كتابة 3 احرف على الأقل',
                'name.unique' => 'القسم موجود مسبقآ',
                'user_id.required' => 'المستخدم مطلوب',
                'icon.image' => 'الإيقونة يجب ان تكون صورة بصيغة jpg|png|jpeg',
            ]
        );

        $category = Category::where('id', $id)->first();

        date_default_timezone_set('Asia/Hebron');
        unset($request['_token']);
        $data = [];
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $fileName = time() . Str::random(12) . '.' . $file->getClientOriginalExtension();
            if (File::exists(public_path('/images/categories/icon/') . $category->icon)) {
                File::delete(public_path('/images/categories/icon/') . $category->icon);
            }
            $file->move(public_path('/images/categories/icon/'), $fileName);
            $data = ['icon' => $fileName] + $data;
        }

        $icon =  implode(" ", $data);
        $cat_name = $request->name;
        $cat_user_id = $request->user_id;
        $updated_at = Carbon::now();
        $query = DB::table('categories')
            ->where('id', $id)
            ->update(['name' => $cat_name, 'icon' => $icon ,'user_id' => $cat_user_id, 'updated_at' => $updated_at]);
        if ($query) {
            return response()->json(['status' => 1, "msg" => "تم تعديل القسم \"$cat_name\" بنجاح"]);
        }
    }

    public function delete($id)
    {
        $category = Category::where('id', $id)->first();
        if ($category) {
            $category->delete();
            return response()->json(['status' => 1, "msg" => "تم حذف القسم \"$category->name\" بنجاح"]);
        }
        return response()->json(['status' => 0, "msg" => "حدث خطأ ما"]);
    }
}
