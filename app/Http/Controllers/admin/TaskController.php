<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\category_users;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;


class TaskController extends Controller
{
   
    public function __construct()
    {
       return $this->middleware(['auth','ISManager'])
            ->except(
                [
                    'MyTask', 'MyTaskAjaxDT', 'activate', 'MycomlpetedTask', 'showTask','edit_user_task','update_user_task'
                ]
            );
    }

    public function index()
    {
        return view('admin.tasks.index');
    }

    public function AjaxDT(Request $request)
    {
        if (request()->ajax()) {
            $tasks = $this->joinData();
            $tasks = $this->selectionData($tasks);
            $tasks->where("tasks.isDelete", "=", 0)
            ->where('tasks.status', "=", 'inProgress')
            ->get();

            return  DataTables::of($tasks)
                ->addColumn('actions', function ($tasks) {
                    return '<a href="/dashboard/tasks/edit/' . $tasks->id . '"   data-id="' . $tasks->id . '"title="تعديل المهمة"><i class="la la-edit icon-xl" style="color:blue;padding:4px"></i></a>';
                })->editColumn('status', function ($tasks) {
                    return ($tasks->status == "inProgress") ? "<span class='badge badge-primary'>المهمة قيد العمل</span>" : "<span class='badge badge-success'>المهمة مكتملة بنجاح</span>";
                })->addColumn('change_status', function ($tasks) {
                    return '<input type="checkbox" class="cbActive"  ' . ($tasks->status == "completed" ? "checked" : "") . '  name="status" value="' . $tasks->id . '"/>';
                })->rawColumns(['actions', 'status', 'change_status'])->make(true);
        }
    }

    public function all_tasks()
    {
        return view('admin.tasks.all_tasks');
    }

    public function allTasksAjaxDT(Request $request)
    {
        if (request()->ajax()) {
          $tasks = $this->joinData();   
          if ($this->filter($request,$tasks)) {
              $tasks = $this->selectionData($tasks);
              $tasks->where("tasks.isDelete", "=", 0)
               ->get();
          }  
         
         return DataTables::of($tasks)
        ->editColumn('status', function ($tasks) {
         return ($tasks->status == "inProgress") ? "<span class='badge badge-primary'>المهمة قيد العمل</span>" : "<span
             class='badge badge-success'>المهمة مكتملة بنجاح</span>";
         })->addColumn('change_status', function ($tasks) {
         return '<input type="checkbox" class="cbActive" ' . ($tasks->status == "completed" ? "checked" : "") . '
             name="status" value="' . $tasks->id . '" />';
         })->rawColumns(['actions', 'status', 'change_status'])->make(true);
         }
    }

    public function comlpetedTask()
    {
        return view('admin.tasks.completed_task');
    }

    public function comlpetedTaskAjaxDT(Request $request)
    {
        if (request()->ajax()) {
            $tasks = $this->joinData();
            $tasks =$this->selectionData($tasks);
            $tasks->where("tasks.isDelete", "=", 0)
                ->where('tasks.status', "=", 'completed')->get();

            return  DataTables::of($tasks)
                ->addColumn('actions', function ($tasks) {
                    return '<a href="/dashboard/tasks/delete/' . $tasks->id . '" data-id="' . $tasks->id . '" class="ConfirmLink "' . ' id="' . $tasks->id . '"><i class="fa fa-trash-alt icon-md" style="color:red"></i></a>';
                })->editColumn('status', function ($tasks) {
                    return ($tasks->status == "inProgress") ? "<span class='badge badge-primary'>المهمة قيد العمل</span>" : "<span class='badge badge-success'>المهمة مكتملة بنجاح</span>";
                })->rawColumns(['actions', 'status'])->make(true);
        }
    }

    public function MyTask()
    {
        return view('admin.tasks.my_tasks');
    }

    public function MyTaskAjaxDT()
    {
        if (request()->ajax()) {
            $task = DB::table('tasks')
                ->join('categories', 'categories.id', '=', 'tasks.category_id')
                ->join('projects', 'projects.id', '=', 'tasks.project_id')
                ->select('tasks.*','categories.name as category_name',
                        'projects.project_name as project_name')
                ->where('tasks.user_id', parent::authId())
                ->where("tasks.isDelete", "=", 0)
                ->where('tasks.status', "=", 'inProgress')->get();

            return DataTables::of($task)
                ->addColumn('actions', function ($task) {
                    return '<a href="/dashboard/tasks/show/' . $task->id . '"   data-id="' . $task->id . '"title="عرض بيانات مفصلة عن المهمة"><i class="fas fa-align-justify pl-2" style="color:#28B463"></i></a>
                            <a href="/dashboard/tasks/edit-user-task/' . $task->id . '" data-id="' . $task->id . '" title="تعديل المهمة"><i class="la la-edit icon-xl" style="color:blue;padding:4px"></i></a>';
                })->editColumn('status', function ($task) {
                    return  "<span class='badge badge-primary'>المهمة قيد العمل</span>";
                })->addColumn('change_status', function ($task) {
                    return '<input type="checkbox" class="cbActive"' . ($task->status == "completed" ? "checked" : "") . '  name="status" value="' . $task->id . '"/>';
                })->rawColumns(['actions', 'status', 'change_status'])->make(true);
        }
    }

    public function edit_user_task($id)
    {
       $task = Task::where('id',$id)->where('status','inProgress')->first();
       $category_user = DB::table('category_users')
       ->join('users', 'users.id', 'category_users.user_id')
       ->select('users.id','users.username as username')->where('category_id',$task->category_id)->get();
        return view('admin.tasks.edit_task_user',compact('category_user','task'));
    }

    public function update_user_task(Request $request,$id)
    {
        date_default_timezone_set('Asia/Hebron');
        unset($request['_token']);
        try {
        $user_id = $request->user_id;
        DB::table('tasks')
        ->where('id', $id)
        ->update(['user_id' => $user_id]);
          return response()->json(['status' => 1, "msg" => "تم تعين مستخدم جديد للمهمة"]);
        } catch (\Throwable $th) {
          return response()->json(['status' => 0, "msg" => "حدث خطأ ما"]);
        }
    }

    public function MycomlpetedTask()
    {
        $tasks = DB::table('tasks')
            ->join('categories', 'categories.id', 'tasks.category_id')
            ->join('projects', 'projects.id', '=', 'tasks.project_id')
            ->select('tasks.*', 'categories.name as cat_name', 'projects.project_name as project_name')
            ->where('tasks.status', 'completed')
            ->where('tasks.user_id', parent::authId())->get();
        return view('admin.tasks.my_completed_task', compact('tasks'));
    }

    public function showTask($id)
    {
        $task =  DB::table('tasks')
            ->join('categories', 'categories.id', 'tasks.category_id')
            ->join('projects', 'projects.id', '=', 'tasks.project_id')
            ->select('tasks.*', 'categories.name as cat_name', 'projects.project_name as project_name')
            ->where('tasks.id', $id)->first();
        return view('admin.tasks.show_task', compact('task'));
    }

    public function create()
    {
        return view('admin.tasks.create');
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'task_name' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'task_description' => 'required|min:6|max:255',
                'user_id' => 'nullable|exists:users,id',
                'project_id' => 'required|exists:projects,id',
                'category_id' => 'required|exists:categories,id',
            ],
            [
                'task_name.required' => 'اسم المهمة مطلوب',
                'start_date.required' => 'تاريخ بداية المهمة مطلوب',
                'end_date.required' => 'تاريخ نهاية المهمة مطلوب',
                'task_description.required' => 'وصف المهمة مطلوب',
                'project_id.required' => 'المشروع مطلوب',
                'start_date.date' => 'تاريخ البداية يجب ان يكون تاريخ',
                'end_date' => 'تاريخ النهاية يجب ان يكون تاريخ',
                'task_description.min' => 'الوصف يجب ان يتكون من 6 على الأقل',
                'task_description.max' => 'الحد المسموح به هو 255 حرف',
                'category_id.required' => 'القسم مطلوب',
            ]
        );

        $project_date = DB::table('projects')->where('id', $request->project_id)->first();
        $checkDate = $this->checkDate($request, $project_date); // checkdata function
        //the real task adding
        if ($checkDate == false) {
            return response()->json(['status' => 0, "msg" => "يرجى التحقق من فترة نهاية وبداية المهمة بالنسبة لفترة المشروع"]);
        } else {
            if ($this->insertData($request)) {
                return response()->json(['status' => 1, "msg" => "تم إضافة المهمة بنجاح"]);
            } else {
                return response()->json(['status' => 0, "msg" => "حدث خطأ ما"]);
            }
        }
    }

    public function edit($id)
    {
        $task = Task::where('id', $id)->first();
        if ($task == null) {
            abort(404, 'المهمة غير موجودة');
        }
        return view('admin.tasks.edit', compact('task'));
    }

    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'task_name' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'task_description' => 'required|min:6|max:255',
                'user_id' => 'required',
                'project_id' => 'required',
                'category_id' => 'required',
            ],
            [
                'task_name.required' => 'اسم المهمة مطلوب',
                'start_date.required' => 'تاريخ بداية المهمة مطلوب',
                'end_date.required' => 'تاريخ نهاية المهمة مطلوب',
                'task_description.required' => 'وصف المهمة مطلوب',
                'user_id.required' => 'الموظف مطلوب',
                'project_id.required' => 'المشروع مطلوب',
                'start_date.date' => 'تاريخ البداية يجب ان يكون تاريخ',
                'end_date' => 'تاريخ النهاية يجب ان يكون تاريخ',
                'task_description.min' => 'الوصف يجب ان يتكون من 6 على الأقل',
                'task_description.max' => 'الحد المسموح به هو 255 حرف',
                'category_id.required' => 'القسم مطلوب',
            ]
        );
        $task_name = $request->task_name;
        $project_date = DB::table('projects')->where('id', $request->project_id)->first();
        $checkDate = $this->checkDate($request, $project_date); // checkdata function
        $updateTasktData = $this->updateTaskData($request, $id); // update data function
        if ($checkDate) {
            //the real task adding
            if ($updateTasktData) {
                return response()->json(['status' => 1, "msg" => "تم تعديل المهمة \"$task_name\" بنجاح"]);
            } else {
                return response()->json(['status' => 0, "msg" => "حدث خطأ ما"]);
            }
        } else {
            return response()->json(['status' => 0, "msg" => "يرجى التحقق من فترة نهاية وبداية المهمة بالنسبة لفترة المشروع"]);
        }
    }

    public function category_users($id)
    {
        $category_user = DB::table('category_users')
            ->join('users', 'users.id', 'category_users.user_id')
            ->where('category_id', $id)->get();
        if ($category_user->isEmpty()) {
            return response()->json(['status' => false]);
        } else {
            return response()->json(['status' => true, 'data' => $category_user]);
        }
    }

    public function delete($id)
    {
        $task = Task::where('id', $id)->first();
        if ($task) {
            $task->isDelete = 1;
            $task->save();
        }
        return response()->json(['status' => 1, "msg" => "تم حذف المهمة \"$task->task_name\" بنجاح"]);
    }

    public function activate($id)
    {
        $tasks = Task::where('id',$id)->first();
        $tasks->status = $tasks->status == "inProgress" ? 'completed' : 'inProgress';
        $tasks->save();
        return response()->json(['status' => 1, "msg" => "تم إكمال المهمة بنجاح"]);
    }

    protected function checkDate($request, $project_date)
    {
        if (
            $request->start_date >= $project_date->start_date &&
            $request->start_date <= $project_date->end_date &&
            $request->end_date <= $project_date->end_date &&
            $request->start_date <= $request->end_date
        ) {
            return true;
        } else {
            return false;
        }
    }
    protected function insertData($request)
    {
        // dd($request->all());
        $created_at = Carbon::now();
        $updated_at = Carbon::now();
        try {
            $query = DB::insert(
                'insert into tasks (task_name,start_date,end_date,task_description,user_id,project_id,category_id,created_at,updated_at) values (?,?,?,?,?,?,?,?,?)',
                [$request->task_name, $request->start_date, $request->end_date, $request->task_description, $request->user_id, $request->project_id, $request->category_id, $created_at, $updated_at]
            );
            return true;
        } catch (\Throwable $th) {
            echo $th;
            return false;
        }
    }

    protected function updateTaskData($request, $id)
    {
        // $task = Task::where('id', $id)->first();
        date_default_timezone_set('Asia/Hebron');
        unset($request['_token']);
        try {
            $task_name = $request->task_name;
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $task_description = $request->task_description;
            $status = $request->status;
            $user_id = $request->user_id;
            $updated_at = Carbon::now();
            $query = DB::table('tasks')
                ->where('id', $id)
                ->update(['task_name' => $task_name, 'start_date' => $start_date, 'end_date' => $end_date, 'task_description' => $task_description, 'status' => $status, 'user_id' => $user_id, 'updated_at' => $updated_at]);
            return true;
        } catch (\Throwable $th) {
            return  false;
        }
    }

    protected function joinData()
    {
         $tasks = DB::table('tasks')
         ->leftJoin('users', 'users.id', '=', 'tasks.user_id')
         ->join('categories', 'categories.id', '=', 'tasks.category_id')
         ->join('projects', 'projects.id', '=', 'tasks.project_id');
         return $tasks;
    }

    protected function filter($request,$tasks)
    {
          if ($request->status != Null && $request->status != '')
             $tasks->where('status', $request->status);

          if ($request->project_id != Null && $request->project_id != '')
             $tasks->where('tasks.project_id', $request->project_id);

          if ($request->category_id != Null && $request->category_id != '')
             $tasks->where('tasks.category_id', $request->category_id);

          if ($request->user_id != Null && $request->user_id != '')
              $tasks->where('tasks.user_id', $request->user_id);
          return true;
    }

    protected function selectionData($tasks)
    {
          $tasks->select([
          'tasks.*','users.username as username','categories.name as category_name',
          'projects.project_name as project_name',
          DB::raw("DATE_FORMAT(tasks.created_at, '%Y-%m-%d') as Date"),
          ])->groupBy('tasks.id', 'tasks.task_name');
          return $tasks;
    }
}
