<div class="row">
    <div class="col-sm-12">
        <form method="post" action="{{ route('users.store') }}" class="ajaxForm">
            {{csrf_field()}}

            <div class="form-group row">
                <label class="col-3 col-form-label">إسم المستخدم :</label>
                <div class="col-8">
                    <input class="form-control" autofocus style="text-align: center" type="text" id="username" name="username"
                        autocomplete="off">
                </div>
            </div>

            <div class="form-group row">
                    <label class="col-3 col-form-label">البريد الإلكتروني :</label>
                    <div class="col-8">
                        <input class="form-control" autofocus style="text-align: center" type="text" id="email" name="email"
                            autocomplete="off">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-3 col-form-label">الهاتف :</label>
                    <div class="col-8">
                        <input class="form-control" autofocus style="text-align: center" type="text" id="phone" name="phone"
                            autocomplete="off">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-3 col-form-label">الدور :</label>
                    <div class="col-8">
                        <select name="role" class="form-control">
                            <option value="" selected disabled>إختر</option>
                            <option value="manager">Manager</option>
                            <option value="employee">Employee</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-3 col-form-label">الباسورد :</label>
                    <div class="col-8">
                        <input class="form-control" autofocus style="text-align: center" type="password" id="password" name="password"
                            autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                   <label class="col-3 col-form-label">تاكيد الباسورد :</label>
                    <div class="col-8">
                    <input class="form-control" autofocus style="text-align: center" type="password" id="password_confirmation" name="password_confirmation" autocomplete="off">
                                    </div>
                                </div>

            <div class="col-sm-8 offset-sm-4">
                <button type="submit" data-refresh="true" class="btn green btn-primary">حفظ</button>
                <a class="btn btn-default " data-dismiss="modal">الغاء الأمر</a>
            </div>
    </div>

    </form>
</div>


<script>
    PageLoadMethods();
//     $('#Popup .select2').each(function() {  
//    var $p = $(this).parent(); 
//    $(this).select2({  
//      dropdownParent: $p,
//         theme: "bootstrap"
//    });  
// });
    
</script>