<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'ISManager']);
    }

    public function index()
    {
        return view('admin.projects.index');
    }


    public function store(Request $request)
    {

        $this->validate(
            $request,
            [
                'project_name' => 'required|max:255|min:3',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'description' => 'nullable|max:255|min:3',
            ],
        );

        date_default_timezone_set('Asia/Hebron');
        unset($request['_token']);

        $project_name = $request->project_name;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $description = $request->description;
        $user_id = Auth::id();
        $updated_at = Carbon::now();
        $created_at = Carbon::now();
        DB::insert(
            'insert into projects (project_name,start_date,end_date,description,user_id,created_at,updated_at) values (?,?,?,?,?,?,?)',
            [$project_name, $start_date, $end_date, $description, $user_id, $created_at, $updated_at]
        );
        return response()->json(['status' => 1, "msg" => "Project \"$project_name\" Added"]);
    }

    public function AjaxDT(Request $request)
    {
        if (request()->ajax()) {
            $projects = DB::table('projects')
                ->Join('users', 'users.id', '=', 'projects.user_id');

            $projects->select([
                'projects.*', 'users.username as username',
                DB::raw("DATE_FORMAT(projects.created_at, '%Y-%m-%d') as Date"),
            ])->groupBy('projects.id', 'projects.project_name')->get();

            return  DataTables::of($projects)
                ->addColumn('actions', function ($projects) {
                    return '<a href="/dashboard/projects/edit/' . $projects->id . '" class="Popup" data-toggle="modal"  data-id="' . $projects->id . '"title="Edit Project"><i class="la la-edit icon-xl" style="color:blue;padding:4px"></i></a>
                            <a href="/dashboard/projects/delete/' . $projects->id . '" data-id="' . $projects->id . '" class="ConfirmLink "' . ' id="' . $projects->id . '"><i class="fa fa-trash-alt icon-md" style="color:red"></i></a>';
                })->rawColumns(['actions'])->make(true);
        }
    }


    public function create()
    {
        return view('admin.projects.create');
    }


    public function edit($id)
    {
        $project = Project::where('id', $id)->first();
        if ($project == null) {
            abort(404, 'not found');
        }
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'project_name' => 'required|max:255|min:3',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'description' => 'nullable|max:255|min:3',
            ],
        );

        $project = Project::where('id', $id)->first();

        date_default_timezone_set('Asia/Hebron');
        unset($request['_token']);
        $project_name = $request->project_name;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $description = $request->description;
        $updated_at = Carbon::now();
        $query = DB::table('projects')
            ->where('id', $id)
            ->update(['project_name' => $project_name, 'start_date' => $start_date, 'end_date' => $end_date, 'description' => $description, 'updated_at' => $updated_at]);
        if ($query) {
            return response()->json(['status' => 1, "msg" => "Project \"$project_name\" Updated"]);
        }
    }

    public function delete($id)
    {
        $project = Project::where('id', $id)->first();
        $task = Task::where('project_id', $id)->first();

        if ($task != null) {
            return response()->json(['status' => 2, "msg" => "Can't delete project have tasks "]);
        } else {
            $project->delete();
            return response()->json(['status' => 1, "msg" => "Project \"$project->project_name\" Deleted"]);
        }
        return response()->json(['status' => 0, "msg" => "Somthing Went Wrong"]);
    }
}
