@extends("layouts.superAdmin")
@section('page_title')
جميع المستخدمين
@endsection
@section('breadcrumb')

<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-md">
    <li class="breadcrumb-item">
        <a href="/" class="text-muted">الرئيسية</a>
    </li>
    <li class="breadcrumb-item">
        <a href="" class="text-muted"> المستخدمين </a>
    </li>
</ul>
@endsection


@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">
        <div class="card card-custom gutter-b">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">المستخدمين
                        <span class="d-block text-muted pt-2 font-size-sm">عرض جميع &amp; المستخدمين</span>
                    </h3>
                </div>
       <div class="card-toolbar">


    <a href="{{ route('users.create') }}" class="btn btn-primary font-weight-bolder Popup" title="إضافة مستخدم">
        <span class="svg-icon svg-icon-md">
            <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect x="0" y="0" width="24" height="24"></rect>
                    <circle fill="#000000" cx="9" cy="15" r="6"></circle>
                    <path
                        d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                        fill="#000000" opacity="0.3"></path>
                </g>
            </svg>
            <!--end::Svg Icon-->
        </span>إضافة مستخدم </a>

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
                                            <th width="3%">المستخدم</th>
                                            <th width="3%">الإيميل</th>
                                            <th width="3%">الهاتف</th>
                                            <th width="3%">الدور</th>
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
        BindDataTable();
    });

    //هذه تختلف حسب الصفحة
    function BindDataTable() {
        oTable = $('#tblAjax').dataTable({
            language: {
                aria: {
                    sortAscending: ": فعال لترتيب العمود تصاعديا",
                    sortDescending: ": فعال لترتيب العمود تنازليا"
                },
                emptyTable: "لا يوجد بيانات لعرضها",
                info: "عرض _START_ الى _END_ من _TOTAL_ صف",
                infoEmpty: "لا يوجد نتائج لعرضها",
                infoFiltered: "(filtered1 من _MAX_ اجمالي صفوف)",
                lengthMenu: "_MENU_ صف",
                search: "بحث",
                zeroRecords: "لا يوجد نتائج لعرضها",
                paginate: {
                    sFirst: "الاول",
                    sLast: "الاخير",
                    sNext: "التالي",
                    sPrevious: "السابق"
                }
            },
            lengthMenu: [5, 10, 25, 50],
            pageLength: 10,

            "paging": true,
            lengthChange: true,
            "lengthChange": true,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
            serverSide: true,
            select: true,
            "bDestroy": true,
            "bSort": true,
            visible: true,
            "iDisplayLength": 10,
            "sPaginationType": "full_numbers",
            "bAutoWidth":false,
            "bStateSave": true,
             "dom": '<"top"i>rt<"bottom"flp><"clear">',
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
                    data: 'username',
                    name: 'username'
                },
                {
                    data: 'email',
                    name: 'email'
                },

                 {
                    data: 'phone',
                    name: 'phone'
                },

                  {
                    data: 'role',
                    name: 'role'
                },
                {
                    data: 'Date',
                    name: 'Date'
                },

               {data: 'actions', name: 'actions',orderable:false,serachable:false,sClass:'text-center'},
            ],
            ajax: {
                type: "POST",
                contentType: "application/json",
                url: '/dashboard/users/AjaxDT',
                data: function(d) {
                    d._token = "{{csrf_token()}}";
                  return JSON.stringify(d);
            },
            },
            fnDrawCallback: function() {}
        });
    }
    
</script>

@endsection