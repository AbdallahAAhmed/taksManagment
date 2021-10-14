<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
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
                'user_id' => 'required',
                'project_id' => 'required',
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
            ]
        );

        $project_date = DB::table('projects')->where('id', $request->project_id)->first();
        if ($this->checkDate($request, $project_date) == true) {
            //the real task adding
            if ($this->insertData($request) == true) {
                return response()->json(['status' => 1, "msg" => "تم إضافة المهمة بنجاح"]);
            } else {
                return response()->json(['status' => 0, "msg" => "حدث خطأ ما"]);
            }
        } else {
            return response()->json(['status' => 0, "msg" => "يرجى التحقق من فترة نهاية وبداية المهمة بالنسبة لفترة المشروع"]);
        }
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
        $created_at = Carbon::now();
        $updated_at = Carbon::now();
        try {
            $query = DB::insert(
                'insert into tasks (task_name,start_date,end_date,task_description,user_id,project_id,created_at,updated_at) values (?,?,?,?,?,?,?,?)',
                [$request->task_name, $request->start_date, $request->end_date, $request->task_description, $request->user_id, $request->project_id, $created_at, $updated_at]
            );
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
