<script>
    var KTAppSettings = {
        "breakpoints": {
            "sm": 576,
            "md": 768,
            "lg": 992,
            "xl": 1200,
            "xxl": 1200
        },
        "colors": {
            "theme": {
                "base": {
                    "white": "#ffffff",
                    "primary": "#3699FF",
                    "secondary": "#E5EAEE",
                    "success": "#1BC5BD",
                    "info": "#8950FC",
                    "warning": "#FFA800",
                    "danger": "#F64E60",
                    "light": "#F3F6F9",
                    "dark": "#212121"
                },
                "light": {
                    "white": "#ffffff",
                    "primary": "#E1F0FF",
                    "secondary": "#ECF0F3",
                    "success": "#C9F7F5",
                    "info": "#EEE5FF",
                    "warning": "#FFF4DE",
                    "danger": "#FFE2E5",
                    "light": "#F3F6F9",
                    "dark": "#D6D6E0"
                },
                "inverse": {
                    "white": "#ffffff",
                    "primary": "#ffffff",
                    "secondary": "#212121",
                    "success": "#ffffff",
                    "info": "#ffffff",
                    "warning": "#ffffff",
                    "danger": "#ffffff",
                    "light": "#464E5F",
                    "dark": "#ffffff"
                }
            },
            "gray": {
                "gray-100": "#F3F6F9",
                "gray-200": "#ECF0F3",
                "gray-300": "#E5EAEE",
                "gray-400": "#D6D6E0",
                "gray-500": "#B5B5C3",
                "gray-600": "#80808F",
                "gray-700": "#464E5F",
                "gray-800": "#1B283F",
                "gray-900": "#212121"
            }
        },
        "font-family": "Poppins"
    };
</script>
<script src="/assets/plugins/global/plugins.bundle.js"></script>
{{-- <script src="/assets/plugins/custom/prismjs/prismjs.bundle.js"></script> --}}
<script src="/assets/js/scripts.bundle.js"></script>
{{-- <!-- <script src="/assets/js/pages/widgets.js"></script> --> --}}
<script src="/assets/plugins/select2/js/select2.min.js"></script>
<script src="/js/jquery.form.min.js"></script>
<script src="/js/moment.min.js"></script>
<script src="/assets/plugins/nprogress-master/nprogress.js"></script>
<script src="/assets/plugins/datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="{{ asset('backend_assets/bootstrap-fileinput/js/plugins/piexif.min.js') }}"></script>
<script src="{{ asset('backend_assets/bootstrap-fileinput/js/plugins/sortable.min.js') }}"></script>
<script src="{{ asset('backend_assets/bootstrap-fileinput/js/plugins/purify.min.js') }}"></script>

<script src="{{ asset('backend_assets/bootstrap-fileinput/js/fileinput.min.js') }}"></script>
<script src="{{ asset('backend_assets/bootstrap-fileinput/themes/fas/theme.min.js') }}"></script>




<script>
    $(function() {

        $(".select2").select2();


        $(document).on("click", ".ConfirmLink", function() {
             var id =   $(this).attr("data-id");
            var item = this;
            Swal.fire({
            icon: 'warning',
            title: 'هل أنت متأكد ؟',
            text: "هل أنت متأكد من الحذف" ,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonText: 'إلغاء',
            cancelButtonColor: '#d33',
            confirmButtonText: 'نعم , إحذف'
            }).then((result) => {

            if (result.isConfirmed) {
           $.ajax({
              url: $(item).attr('href') ,
              method:'get',
              data:{},
              success:function (response){
              ShowMessage(response.msg, "success", "متجري");
                 BindDataTable();
            }
        })

            }
            })
        //    $("#Confirm").modal("show");

            return false;
        });

        $(document).on("click", ".Popup", function() {
            $("#Popup .modal-body").html("<h1 class='text-center'><i style='font-size:50px;' class='fa fa-spinner fa-spin'></i></h1>");
            $("#Popup .modal-title").text($(this).attr("title"));
            $("#Popup .modal-body").load($(this).attr("href"));
            $("#Popup").modal("show");
            return false;
        });


        $(document).ajaxStart(function() {
            NProgress.start()

        });

        $(document).ajaxStop(function() {
            NProgress.done()
        });

        $(document).ajaxError(function() {
            NProgress.done()
        });
        PageLoadMethods();

        $(".DTForm").submit(function(e) { //index form for search
            BindDataTable();
            // cDataTable();
            // fDataTable();
            return false;
        });


        if ($('#tblAjax').length > 0) {
            $("#Confirm .btn-danger").click(function(e) {
                $.get($("#Confirm .btn-danger").attr("href"), function(json) {
                    if (json.status == 1) {
                        ShowMessage(json.msg, "success", "متجري");

                    } else {
                        ShowMessage(json.msg, "error", "متجري");
                    }
                    BindDataTable();
                    // cDataTable();
                    // fDataTable();


                });
                $("#Confirm").modal("hide");
                return false;
            });
        }

    });

    function PageLoadMethods() {
        $(".ajaxForm").ajaxForm({
            success: function(json) {
                $(".ajaxForm :submit").prop("disabled", false);
                if (json.status == 1) {
                    $('.ajaxForm').resetForm();
                    $("#tblItems tbody tr").remove();
                    // $('.select2').val('').trigger('change.select2');

                    ShowMessage(json.msg, "success", "متجري");


                    if (json.redirect != null)

                        setTimeout(function() {
                            window.location = json.redirect
                        }, 800);



                    if (json.close != null)
                        $("#Popup").modal("hide");



                    if ($(".ajaxForm :submit").data("refresh") == true) {
                        $("#Popup").modal("hide");
                        // fDataTable();
                        // cDataTable();
                        BindDataTable();


                    }
                } else {
                    ShowMessage(json.msg, "error", "متجري");
                }
                if (json.redirect != null)
                    setTimeout(function() {
                        window.location = json.redirect
                    }, 800);
                if (json.close != null)
                    $("#Popup").modal("hide");
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
                ShowMessage(errorsHtml, "error", "متجري");
            }
        });


        $(".ajaxFormss").ajaxForm({
            success: function(json) {
                $(".ajaxFormss :submit").prop("disabled", false);
                if (json.status == 1) {
                    $('.ajaxFormss').resetForm();
                    // $('.select2').val('').trigger('change.select2');

                    ShowMessage(json.msg, "success", "متجري");


                    if (json.redirect != null)

                        setTimeout(function() {
                            window.location = json.redirect
                        }, 800);



                    if (json.close != null)
                        $("#Popup").modal("hide");



                    if ($(".ajaxFormss :submit").data("refresh") == true) {
                        $("#Popup").modal("hide");


                    }
                } else {
                    ShowMessage(json.msg, "error", "متجري");
                }
                if (json.redirect != null)
                    setTimeout(function() {
                        window.location = json.redirect
                    }, 800);
                if (json.close != null)
                    $("#Popup").modal("hide");
            },
            beforeSubmit: function() {
                $(".ajaxFormss :submit").prop("disabled", true);
            },
            error: function(json) {
                $(".ajaxFormss :submit").prop("disabled", false);
                errorsHtml = "<ul>";
                $.each(json.responseJSON, function(key, value) {
                    console.log(value);
                    errorsHtml += '<li>' + value[0] + '</li>';
                });
                errorsHtml += "</ul>";
                ShowMessage(errorsHtml, "error", "متجري");
            }
        });


    }
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    function ShowMessage(msg, color, title) {
        Command: toastr[color](msg, title);
    }


// $('#Popup .select2').each(function() {
//     var $p = $(this).parent();
//     $(this).select2({
//     dropdownParent: $p,
//     theme: "bootstrap"
//     });
//     });


</script>


<div id="Confirm" class="modal fade" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">تأكيد</h4>
            </div>
            <div class="modal-body">
                <p>هل انت متأكد من الاستمرار في العملية</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">الغاء الأمر</button>
                <a class="btn btn-danger">نعم, متأكد</a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="Popup" class="modal  fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header ">
                <div class=" row col-sm-12 modal-title font-weight-bold h3">

                </div>
            </div>
            <div class="modal-body">
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@yield('js')