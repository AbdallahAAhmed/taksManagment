@extends("layouts.superAdmin")
@section('page_title')
  {{ $category->name }} -
@endsection
@section('breadcrumb')

<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-md">
    <li class="breadcrumb-item">
        <a href="{{ route('categories') }}" class="text-muted">الأقسام</a>
    </li>
    <li class="breadcrumb-item">
        <a href="" class="text-muted"> الموظفين </a>
    </li>
</ul>
@endsection

@section('content')
    <div class="card-body pt-4">
        <!--begin::Item-->
        <div class="card-header border-0" style="padding-top: 15px !important">
            <h3 class="card-title fw-bolder text-dark">الموظفين لهذا القسم</h3>
        </div>
        @foreach ($category->users as $category_user)
        <div class="d-flex align-items-center">
            {{ $loop->iteration }} |
            <div class="symbol symbol-80px me-5" style="padding-left:1px">
                <img src="{{ asset('user-image.png') }}" class="img-fluid" alt="">
            </div>
            <div class="flex-grow-1">
                <a  class="text-dark fw-bolder text-hover-primary fs-6"><span style="font-weight: bolder">الإسم :</span> {{ $category_user->username }}</a><br>
                <a  class="text-dark fw-bolder text-hover-primary fs-6"><span style="font-weight: bolder">البريد الإلكتروني :</span> {{ $category_user->email }}</a><br>
            </div>
        </div><br>
        @endforeach
        
    </div>
@endsection

@section('css')
    <style>
        .card-header{
            padding:0 !important
        }
        .symbol > img{
            max-width: 100px !important;
        }
    </style>
@endsection