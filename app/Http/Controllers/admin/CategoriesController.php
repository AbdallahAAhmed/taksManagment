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
                'users' => 'required',
            ],
            [
                'name.required' => 'القسم مطلوب',
                'name.string' => 'القسم يجب ان يكون قيمة نصية',
                'name.max' => 'القسم يجب الا يتعدي 255 حرف',
                'name.min' => 'يجب كتابة 3 احرف على الأقل',
                'name.unique' => 'القسم موجود مسبقآ',
                'users.required' => 'حقل الموظفين مطلوب',
                'icon.image' => 'الإيقونة يجب ان تكون صورة بصيغة jpg|png|jpeg',
            ]
        );
        date_default_timezone_set('Asia/Hebron');
        unset($request['_token']);
        $icon = NULL;
        if ($request->hasFile('icon')) {
            $icon =  $this->saveImages($request->icon, 'images/categories/icon');
        }
        DB::beginTransaction();
        try {
            $category = Category::create([
                'name' => $request->name,
                'icon' => $icon,
            ]);
            $category->users()->sync($request->users);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return response()->json(['status' => 2, "msg" => 'حدث خطأ في ادخال البيانات']);
        }

        return response()->json(['status' => 1, "msg" => "تم إضافة القسم \"$category->name\" بنجاح"]);
    }

    public function AjaxDT(Request $request)
    {
        if (request()->ajax()) {
            $categories = DB::table('categories');

            $categories->select([
                'categories.*',
                DB::raw("DATE_FORMAT(categories.created_at, '%Y-%m-%d') as Date"),
            ])->groupBy('categories.id', 'categories.name')->get();

            return  DataTables::of($categories)
                ->addColumn('actions', function ($categories) {
                    return '<a href="/dashboard/categories/edit/' . $categories->id . '" class="Popup" data-toggle="modal"  data-id="' . $categories->id . '"title="تعديل الصنف"><i class="la la-edit icon-xl" style="color:blue;padding:4px"></i></a>
                            <a href="/dashboard/categories/delete/' . $categories->id . '" data-id="' . $categories->id . '" class="ConfirmLink "' . ' id="' . $categories->id . '"><i class="fa fa-trash-alt icon-md" style="color:red"></i></a>
                            <a href="/dashboard/categories/show/' . $categories->id . '" data-id="' . $categories->id . '" title="عرض الموظفين في هذا القسم"><i class="fas fa-align-justify pl-2" style="color:#28B463"></i></a>';
                })->addColumn('icon', function ($categories) {
                    $url = asset('images/categories/icon/' . $categories->icon);
                    return '<img src="' . $url . '" border="0" style="border-radius: 10px;" width="40" class="img-rounded" align="center" />';
                })->rawColumns(['actions', 'status', 'icon'])->make(true);
        }
    }

    public function show($id)
    {
        $category = Category::with('tasks')->where('id',$id)->first();
        return view('admin.categories.show',compact('category'));
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
                'users' => 'required',
            ],
            [
                'name.required' => 'القسم مطلوب',
                'name.string' => 'القسم يجب ان يكون قيمة نصية',
                'name.max' => 'القسم يجب الا يتعدي 255 حرف',
                'name.min' => 'يجب كتابة 3 احرف على الأقل',
                'name.unique' => 'القسم موجود مسبقآ',
                'users.required' => 'حقل الموظفين مطلوب',
                'icon.image' => 'الإيقونة يجب ان تكون صورة بصيغة jpg|png|jpeg',
            ]
        );

        $category = Category::where('id', $id)->first();

        date_default_timezone_set('Asia/Hebron');
        unset($request['_token']);
        $data = [];
        $data['name']  = $request->name;
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $fileName = time() . Str::random(12) . '.' . $file->getClientOriginalExtension();
            if (File::exists(public_path('/images/categories/icon/') . $category->icon)) {
                File::delete(public_path('/images/categories/icon/') . $category->icon);
            }
            $file->move(public_path('/images/categories/icon/'), $fileName);
            $data = ['icon' => $fileName] + $data;
        }

        DB::beginTransaction();
        try {
            $category->update($data);
            $category->users()->sync($request->users);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return response()->json(['status' => 2, "msg" => 'حدث خطأ في ادخال البيانات']);
        }
        return response()->json(['status' => 1, "msg" => "تم تعديل القسم \"$category->name\" بنجاح"]);
    }

    public function delete($id)
    {
        $category = Category::where('id', $id)->first();
        if (File::exists(public_path('/images/categories/icon/') . $category->icon)) {
            File::delete(public_path('/images/categories/icon/') . $category->icon);
        }
        DB::beginTransaction();
        try {
            $category_users = DB::table('category_users')->where('category_id', "=", $category->id);
            if ($category_users != null)
                $category_users->delete();

            if ($category) {
                $category->delete();
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return response()->json(['status' => 0, "msg" => "حدث خطأ ما"]);
        }
        return response()->json(['status' => 1, "msg" => "تم حذف القسم \"$category->name\" بنجاح"]);
    }
}
