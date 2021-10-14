@extends("layouts.superAdmin")
@section('page_title')
الطلبات
@endsection
@section('breadcrumb')

<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-md">
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard.index') }}" class="text-muted">الرئيسية</a>
    </li>
    <li class="breadcrumb-item">
        <a href="" class="text-muted"> الطلبات </a>
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
                    <h3 class="card-label">الطلبات</h3>
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
                                            <th width="3%">عنوان الطلب</th>
                                            <th width="3%">القسم</th>
                                            <th width="3%">الموظف</th>
                                            <th width="3%">الحالة</th>
                                            <th width="3%">نص الرسالة</th>
                                            <th width="3%">تغير حالة الطلب</th>
                                            <th width="3%">تاريخ الإضافة</th>
                                            <th width="3%">إجراءات</th>
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
title: 'هل أنت متأكد ؟',
text: "هل أنت متأكد من تعديل الحالة" ,
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonText: 'إلغاء',
cancelButtonColor: '#d33',
confirmButtonText: 'نعم , عدل'
}).then((result) => {

if (result.isConfirmed) {
$.ajax({
url: '/dashboard/contacts/activate/' + id ,
method:'get',
data:{},
success:function (response){
ShowMessage(response.msg, "success", "إدارة المهام");
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
            "language": {
            emptyTable:"لا يوجد بيانات لعرضها",
            "sProcessing": "جارٍ التحميل...",
            "sLengthMenu": "أظهر _MENU_ مدخلات",
            "sZeroRecords": "لم يعثر على أية سجلات",
            "sInfo": "إظهار _START_ إلى _END_ ",
            "sInfoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
            "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
            "sInfoPostFix": "",
            "sSearch": "بحث:",
            'selectedRow': 'مجمل المحدد',
            "sUrl": "",
            "oPaginate": {
            "sFirst": "الأول",
            "sPrevious": "السابق",
            "sNext": "التالي",
            "sLast": "الأخير",
            }
            },
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
                    text: 'طباعة الكل',
                    customize: function (win) {
                    $(win.document.body).css('direction', 'rtl');
                    },
                    exportOptions: {
                    columns: ':visible' }},

                   { extend: 'colvis',
                    text: ' تحديد الأعمدة'},
                   
                    {extend: 'excelHtml5',
                    text: 'طباعة أكسل',
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
                    data: 'title',
                    name: 'title'
                },
                
                {
                data: 'category_name',
                name: 'category_name'
                },

                {
                data: 'username',
                name: 'username'
                },

                {
                data: 'status',
                name: 'status'
                },

                {
                data: 'message',
                name: 'message'
                },
                {data: 'change_status',
                 name: 'change_status',orderable:false,serachable:false,},
                {
                    data: 'Date',
                    name: 'Date'
                },

               {data: 'actions', name: 'actions',orderable:false,serachable:false,sClass:'text-center'},
            ],
            ajax: {
                type: "POST",
                contentType: "application/json",
                url: '/dashboard/contacts/AjaxDT',
                data: function(d) {
                    d._token = "{{csrf_token()}}";
                  return JSON.stringify(d);
            },
            },
            fnDrawCallback: function() {}
        });
    }
    
</script>

@endsection()