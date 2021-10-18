@extends("layouts.superAdmin")
@section('page_title')
تعديل إعدادات النظام
@endsection
@section('breadcrumb')

<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-md">
    <li class="breadcrumb-item">
        <a href="/" class="text-muted">الرئيسية</a>
    </li>
    <li class="breadcrumb-item">
        <a href="" class="text-muted"> تعديل إعدادات النظام </a>
    </li>
</ul>
@endsection

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container">
        <div class="card card-custom gutter-b">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">الإعدادات
                        <span class="d-block text-muted pt-2 font-size-sm">تعديل الإعدادات &amp; الإعدادات</span>
                    </h3>
                </div>

            </div>
            <div class="modal-body pb-2">
                <form action="{{ route('settings.update',['id' => $setting->id]) }}" enctype="multipart/form-data" method="POST" class="ajaxForm">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="put"/>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>العنوان :</label>
                                    <div class="input-icon input-icon-right">
                                        <input name="title" type="text" id="title" class="form-control"
                                            value="{{ $setting->title }}" placeholder="" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>العنوان الفرعي :</label>
                                    <div class="input-icon input-icon-right">
                                        <input name="sub_title" type="text" id="sub_title" class="form-control"
                                            value="{{ $setting->sub_title }}" placeholder="" />
                                    </div>
                                   

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>رقم التواصل :</label>
                                    <div class="input-icon input-icon-right">
                                        <input name="contact_number" value="{{ $setting->contact_number }}" type="text"
                                            id="contact_number" class="form-control" placeholder="" />
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>البريد الإلكتروني :</label>
                                    <div class="input-icon input-icon-right">
                                        <input name="email" value="{{ $setting->email }}" type="email" id="email"
                                            class="form-control" placeholder="" />
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>الأنستقرام :</label>
                                    <div class="input-icon input-icon-right">
                                        <input name="instagram_url" type="text" value="{{ $setting->instagram_url }}"
                                            id="instagram_url" class="form-control" placeholder="" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>التويتر :</label>
                                    <div class="input-icon input-icon-right">
                                        <input name="twitter_url" type="text" value="{{ $setting->twitter_url }}"
                                            id="twitter_url" class="form-control" placeholder="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>الفيسبوك :</label>
                                    <div class="input-icon input-icon-right">
                                        <input name="facebook_url" type="text" value="{{ $setting->facebook_url }}"
                                            id="facebook_url" class="form-control" placeholder="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                      <div class="col-md-6">
                        <input type="file" name="logo" id="logo" class="form-control file-image" id="file-image">
                        @if($setting->logo)
                        <img src="{{ asset('images/settings/logo/' . $setting->logo) }}" class="img-rounded pt-2" height="100px"
                            width="90px" style="border-radius: 10px">
                        @endif
                    </div>
                    </div>
                    <div class="card-toolbar" style="text-align: left">
                        <button type="submit" data-refresh="true" class="btn green btn-primary">تعديل</button>
                        <button type="reset" class="btn btn-secondary">إلغاء</button>
                    </div>
                </form>
                <!--end::Form-->
            </div>
        </div>

    </div>
</div>
@endsection
@section('js')
<script>
   $(document).ready(function() {
    $(".ajaxForm").ajaxForm({
    success: function(json) {
    $(".ajaxForm :submit").prop("disabled", false);
    if (json.status == 1) {
    $('.ajaxForm').resetForm();
    ShowMessage(json.msg, "success", "ادارة المهام");
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