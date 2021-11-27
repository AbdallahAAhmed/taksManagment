@extends("layouts.superAdmin")
@section('page_title')
Tasks
@endsection
@section('breadcrumb')

<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-md">
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard.index') }}" class="text-muted">Home Page</a>
    </li>
    <li class="breadcrumb-item">
        <a href="" class="text-muted"> All Tasks </a>
    </li>
</ul>
@endsection

@section('content')


<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">
        <div class="card card-custom gutter-b">


            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="flaticon2-supermarket text-primary"></i>
                    </span>
                    <h3 class="card-label">All Tasks</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-9 row mt-4 ">
                    <div class="col-sm-12 row d-flex flex-row" style="margin-right: 0.01em">
                        <form method="get" class="col-sm-12 row mt-2 DTForm" id="search-form">
                            @csrf
                            <p class="col-sm-12 d-flex flex-row">
                                <span class="ml-6 mr-3 mt-1"></span>
                                <select name="status" id="status" class="form-control col-md-3 select2">
                                    <option value="" id="disable-option">Status</option>
                                    <option value="completed">completed</option>
                                    <option value="inProgress">InProgress</option>
                                </select>

                                <span class="ml-3 mr-3 mt-1"></span>
                                <select name="category_id" id="category_id" class="form-control col-md-3 select2">
                                    <option value="">Choose Category</option>
                                    @foreach (App\Models\Category::all() as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>

                                <span class="ml-3 mr-3 mt-1"></span>
                                <select name="project_id" id="project_id" class="form-control select2 col-md-3">
                                    <option value="">Choose Project</option>
                                    @foreach (App\Models\Project::all() as $project)
                                    <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                                    @endforeach
                                </select>

                                <span class="ml-3 mr-3 mt-1"></span>
                                <select name="user_id" id="user_id" class="form-control select2 col-md-3">
                                    <option value="">Choose User</option>
                                    @foreach (App\Models\User::all() as $user)
                                    <option value="{{ $user->id }}">{{ $user->username }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" id="filter" class="btn btn-sm btn-success btn-submit"
                                    style="margin-right: 5px;display: none;">filter</button>
                                <button type="submit" id="reset_filter"
                                    style="display: none; margin-left: 10px !important;"
                                    class="btn btn-sm btn-info btn-submit pl-2" style="margin-left: 5px">Reset</button>
                            </p>

                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!--begin: Datatable-->
                <div id="" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap table-bordered" id="tblAjax">
                                    <thead>
                                    <tr>
                                            <th width="1%">#</th>
                                            <th width="1%">Task Title</th>
                                            <th width="3%">Start date</th>
                                            <th width="3%">End Date</th>
                                            <th width="3%">Employee</th>
                                            <th width="3%">Category</th>
                                            <th width="3%">Project</th>
                                            <th width="3%">Status</th>
                                            <th width="3%">Actions</th>
                                        </tr>

                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end: Datatable-->
            </div>
        </div>
    </div>
</div>

@endsection
@section("css")

@include('include.dataTable_css')

@endsection()

@section('js')

@include('include.dataTable_scripts')
<script>
    var oTable;
  $(function() {
$(document).on("click", ".cbActive", function() {
var id = $(this).val();
Swal.fire({
icon: 'warning',
title: 'Are You Sure ?',
text: "Are you sure to change status" ,
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonText: 'cancel',
cancelButtonColor: '#d33',
confirmButtonText: 'yes , Change'
}).then((result) => {

if (result.isConfirmed) {
$.ajax({
url: '/dashboard/tasks/activate/' + id ,
method:'get',
data:{},
success:function (response){
ShowMessage(response.msg, "success", "TMS");
BindDataTable();
}
})

}
})
});
BindDataTable();
});
    //هذه تختلف حسب الصفحة
    function BindDataTable() {
        oTable = $('#tblAjax').DataTable({
        
            lengthMenu: [5, 10, 25, 50],
            pageLength: 10,

           "paging": true,
            "lengthChange": true,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
            serverSide: true,
            "bDestroy": true,
            "bSort": true,
            visible: true,
            "iDisplayLength": 10,
            "sPaginationType": "full_numbers",
            "bAutoWidth":false,
            "bStateSave": true,
            columnDefs: [ {
            // targets: 0,
            visible: true
            } ],
            // Pagination settings
            // dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
			// <'row'<'col-sm-12'tr>>
			// <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
            
           dom: 'lBfrtip',
                 buttons: [

                { extend: 'print',
                    text: 'Print All',
                    customize: function (win) {
                    $(win.document.body).css('direction', 'ltr');
                    },
                    exportOptions: {
                    columns: ':visible' }},

                   { extend: 'colvis',
                    text: ' Select Columns'},
                   
                    {extend: 'excelHtml5',
                    text: 'Print Excel',
                    exportOptions: {
                    columns: ':visible', }},
                    ],

            columnDefs: [{
                targets: 0,
                visible: true
            }],

            "order": [
                [0, "asc"]
            ],
            serverSide: true,
            columns: [

                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'task_name',
                    name: 'task_name'
                },
                {
                data: 'start_date',
                name: 'start_date'
                },

                {
                data: 'end_date',
                name: 'end_date'
                },
                {
                data: 'username',
                name: 'username'
                },

                {
                data: 'category_name',
                name: 'category_name'
                },

                {
                data: 'project_name',
                name: 'project_name'
                },
                {
                data: 'status',
                name: 'status'
                },
                {data: 'change_status',
                 name: 'change_status',orderable:false,serachable:false,},

            ],
            ajax: {
                type: "POST",
                contentType: "application/json",
                url: '/dashboard/tasks/allTasksAjaxDT',
                data: function(d) {
                    d._token = "{{csrf_token()}}";
                    d.status = $("[name=status]").val();
                    d.category_id = $("[name=category_id]").val();
                    d.project_id = $("[name=project_id]").val();
                    d.user_id = $("[name=user_id]").val();
                  return JSON.stringify(d);
            },
            },
            fnDrawCallback: function() {}
        });
    }
</script>

<script>
    $(document).ready(function() {
       //filter by status
       $('#status').on('change',function () {
           var status = $("#status").val();
           if(status != null && status != ''){
                BindDataTable();
                $("#reset_filter").css('display','block');
                
                $("#reset_filter").on('click',function() {
                  $('#status').val(null).trigger('change');
                $("#reset_filter").css('display','none');
                });
          }
       }); 

       //filter by category
       $('#category_id').on('change',function () {
        var category = $("#category_id").val();
        if(category != null && category != ''){
             BindDataTable();
             $("#reset_filter").css('display','block');
        
        $("#reset_filter").on('click',function() {
             $('#category_id').val(null).trigger('change');
             $("#reset_filter").css('display','none');
        });
        }
        });

        //filter by user
        $('#user_id').on('change',function () {
            var user = $("#user_id").val();
            if(user != null && user != ''){
             BindDataTable();
             $("#reset_filter").css('display','block');
            
            $("#reset_filter").on('click',function() {
             $('#user_id').val(null).trigger('change');
             $("#reset_filter").css('display','none');
            });
            }
        });

        //filter by project
        $('#project_id').on('change',function () {
          var project = $("#project_id").val();
          if(project != null && project != ''){
           BindDataTable();
           $("#reset_filter").css('display','block');
        
        $("#reset_filter").on('click',function() {
          $('#project_id').val(null).trigger('change');
          $("#reset_filter").css('display','none');
        });
        }
        });

    });


</script>
@endsection()