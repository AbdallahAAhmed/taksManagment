@extends("layouts.superAdmin")
@section('page_title')
تعديل المهمة
@endsection
@section('breadcrumb')

<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-md">
    <li class="breadcrumb-item">
        <a href="{{ route('tasks') }}" class="text-muted">المهمات</a>
    </li>
    <li class="breadcrumb-item">
        <a href="" class="text-muted">تعديل المهمة  </a>
    </li>
</ul>
@endsection
@section('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

@endsection
@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">
        <div class="flex-row-fluid ml-lg-8">
            <!--begin::Card-->
            <div class="card card-custom card-stretch">
                <!--begin::Header-->
                <div class="card-header py-3">
                    <div class="card-title align-items-start flex-column">
                        <h3 class="card-label font-weight-bolder text-dark">تعديل المهمة | {{ $task->task_name }}</h3>
                        <span class="text-muted font-weight-bold font-size-sm mt-1">تعديل المهمة</span>
                    </div>
                </div>

                <form action="{{ route('tasks.update',['id' => $task->id]) }}" method="POST" class="ajaxForm">
                    {{csrf_field()}}
                        <input type="hidden" name="_method" value="put" />
                    <div class="card-body">
                        <div class="row">
                            <label class="col-xl-3"></label>
                            <div class="col-lg-9 col-xl-6">
                                <h5 class="font-weight-bold mb-6">تعديل بيانات المهمة |Edit task Information</h5>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label text-right">إسم المهمة</label>
                            <div class="col-lg-9 col-xl-6">
                                <input class="form-control form-control-lg form-control-solid" id="task_name"
                                    placeholder="الإسم" value="{{ $task->task_name }}" type="text" name="task_name">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label text-right">وصف عام</label>
                            <div class="col-lg-9 col-xl-6">
                                <textarea name="task_description" placeholder="وصف عام" class="form-control"
                                   cols="30" rows="10">{{ $task->task_description }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label text-right">تاريخ بداية المهمة</label>
                            <div class="col-lg-9 col-xl-6">
                                <input style="text-align: center" value="{{ $task->start_date }}"
                                    class="form-control form-control-lg form-control-solid" id="start_date" type="date"
                                    name="start_date">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label text-right">تاريخ نهاية المهمة</label>
                            <div class="col-lg-9 col-xl-6">
                                <input style="text-align: center" value="{{ $task->end_date }}"
                                    class="form-control form-control-lg form-control-solid" id="end_date" type="date"
                                    name="end_date">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label text-right">الحالة</label>
                            <div class="col-6">
                                <select class="form-control" id="status" name="status">
                                    <option selected disabled>الحالة</option>
                                    <option {{ $task->status == 'inProgress' ? 'selected' : '' }} value="inProgress">inProgress</option>
                                    <option {{ $task->status == 'completed' ? 'selected' : '' }} value="completed">completed</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label text-right">إختر الموظف</label>
                            <div class="col-6">
                                <select class="form-control select2" id="user_id" name="user_id">
                                    <option selected disabled>الموظف</option>
                                    @foreach(App\Models\User::all() as $user)
                                    <option {{ ($user->id == $task->user_id) ? 'selected' : '' }} value="{{$user->id}}">{{$user->username}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label text-right">إختر المشروع</label>
                            <div class="col-6">
                                <select class="form-control select2" id="project_id" name="project_id">
                                    <option selected disabled>المشروع</option>
                                    @foreach(App\Models\Project::all() as $project)
                                    <option {{ ($project->id == $task->project_id) ? 'selected' : '' }} value="{{$project->id}}">{{$project->project_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label text-right">إختر القسم</label>
                            <div class="col-6">
                                <select class="form-control select2" id="category_id" name="category_id">
                                    <option selected disabled>القسم</option>
                                    @foreach(App\Models\Category::all() as $category)
                                    <option {{ ($category->id == $task->category_id) ? 'selected' : '' }} value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="card-toolbar" style="text-align: left">
                            <button type="submit" data-refresh="true" class="btn green btn-primary">تعديل</button>
                            <button type="reset" class="btn btn-secondary">إلغاء</button>
                        </div>
                    </div>
                    <!--end::Body-->
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>
    $(document).ready(function() {
    $('#summernote').summernote({
        height: 100, // set editor height
        toolbar: [
        [ 'style', [ 'style' ] ],
        [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
        [ 'fontname', [ 'fontname' ] ],
        [ 'fontsize', [ 'fontsize' ] ],
        [ 'color', [ 'color' ] ],
        [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
        [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
        ]
    });
    
    $(".ajaxForm").ajaxForm({
    success: function(json) {
    $(".ajaxForm :submit").prop("disabled", false);
    if (json.status == 1) {
    $('.ajaxForm').resetForm();
    // $('#category_id').val(null).trigger('change');
    // $('#user_id').val(null).trigger('change');
    // $('#project_id').val(null).trigger('change');
    // $('#summernote').summernote('reset');
    ShowMessage(json.msg, "success", "ادارة المهام");
    // $('#password').val('');
    // $('#password_confirmation').val('');
    if (json.redirect != null)
    setTimeout(function() {
    window.location = json.redirect
    }, 800);
    
    if ($(".ajaxForm :submit").data("refresh") == true) {
    // $('.ajaxForm').resetForm();
    }
    } else {
    ShowMessage(json.msg, "error", "ادارة المهام");
    }
    if (json.redirect != null)
    setTimeout(function() {
    window.location = json.redirect
    }, 800);
    
    },
    beforeSubmit: function() {
    $(".ajaxForm :submit").prop("disabled", true);
    },
    error: function(json) {
    $(".ajaxForm :submit").prop("disabled", false);
    errorsHtml = "<ul>";
        $.each(json.responseJSON, function(key, value) {
        console.log(value);
        errorsHtml += '<li>' + value[0] + '</li>';
        });
        errorsHtml += "</ul>";
    ShowMessage(errorsHtml, "error", "ادارة المهام");
    }
    });
    
    });
   
</script>
@endsection