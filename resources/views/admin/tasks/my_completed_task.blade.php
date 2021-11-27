@extends("layouts.superAdmin")
@section('page_title')
My Comlpeted Tasks
@endsection
@section('breadcrumb')

<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-md">
    <li class="breadcrumb-item">
        <a href="/" class="text-muted">Home Page</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('MyTask') }}" class="text-muted"> My Tasks </a>
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
                    <h3 class="card-label">My Comlpeted Tasks</h3>
                </div>
                <div class="card-toolbar">

                    <a href="{{ route('MyTask') }}" class="btn btn-primary font-weight-bolder" title="Back">
                        <span class="svg-icon svg-icon-md">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"></rect>
                                    <circle fill="#000000" cx="9" cy="15" r="6"></circle>
                                    <path
                                        d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                                        fill="#000000" opacity="0.3"></path>
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>Back </a>
                </div>
            </div>

            <div class="card-body">
                <!--begin: Datatable-->
                <div id="" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap table-bordered">
                                    <thead>
                                     <tr>
                                            <th width="1%">#</th>
                                            <th width="1%">Task Title</th>
                                            <th width="3%">Start date</th>
                                            <th width="3%">End Date</th>
                                            <th width="3%">Category</th>
                                            <th width="3%">Project</th>
                                            <th width="3%">Task Description</th>
                                            <th width="3%">Status</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        @if ($tasks->count() > 0)
                                        @foreach ($tasks as $task)
                                        <tr>
                                            <td>{{ $task->id}}</td>
                                            <td>{{ $task->task_name}}</td>
                                            <td>{{ $task->start_date}}</td>
                                            <td>{{ $task->end_date}}</td>
                                            <td>{{ $task->cat_name}}</td>
                                            <td>{{ $task->project_name}}</td>
                                            <td>{!! Str::limit($task->task_description,50) !!}</td>
                                            <td>@if ($task->status == 'completed')
                                                <span class="badge badge-success">
                                                   Comlpeted
                                                </span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr class="text-center">
                                            <td colspan="10">
                                                <p class="mt-2">No Data </p>
                                            </td>
                                        </tr>
                                        @endif
                                    <tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section("css")
<style>
    td {
        text-align: center;
        
    }
</style>
@endsection()