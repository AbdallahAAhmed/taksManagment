@extends("layouts.superAdmin")
@section('page_title')
Edit Task
@endsection
@section('breadcrumb')

<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-md">
    <li class="breadcrumb-item">
        <a href="{{ route('tasks') }}" class="text-muted">Tasks</a>
    </li>
    <li class="breadcrumb-item">
        <a href="" class="text-muted">Edit Task To anther User </a>
    </li>
</ul>
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
                        <h3 class="card-label font-weight-bolder text-dark">Edit Task </h3>
                        <span class="text-muted font-weight-bold font-size-sm mt-1">Edit Task</span>
                    </div>
                </div>

                <form action="{{ route('update_user_task',['id'=>$task->id]) }}" method="POST" class="ajaxForm">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="put" />
                    <div class="card-body">
                        <div class="row">
                            <label class="col-xl-3"></label>
                            <div class="col-lg-9 col-xl-6">
                                <h5 class="font-weight-bold mb-6">Choose New User</h5>
                            </div>
                        </div>
                            <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label text-right">Choose User</label>
                            <div class="col-6">
                                <select class="form-control select2 userbox" id="user_id" name="user_id">
                                    @foreach ($category_user as $item)
                                        <option value="{{ $item->id }}">{{ $item->username }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="card-toolbar" style="text-align: left">
                            <button type="submit" data-refresh="true" class="btn green btn-primary">Update</button>
                            <button type="reset" class="btn btn-secondary">Cancel</button>
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
    $('#user_id').val(null).trigger('change');
    // $('#project_id').val(null).trigger('change');
    // $('#summernote').summernote('reset');
    ShowMessage(json.msg, "success", "TMS");
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
    ShowMessage(json.msg, "error", "TMS");
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
    ShowMessage(errorsHtml, "error", "TMS");
    }
    });

    });
   
</script>
@endsection