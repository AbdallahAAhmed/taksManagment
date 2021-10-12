<div class="row">
    <div class="col-sm-12">
        <form method="post" action="{{ route('categories.store') }}" class="ajaxForm">
            {{csrf_field()}}

            <div class="form-group row">
                <label class="col-3 col-form-label">القسم :</label>
                <div class="col-8">
                    <input class="form-control" name="name" autofocus style="text-align: center" type="text" id="name"
                        autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-3 col-form-label">الموظفين :</label>
                <div class="col-8">
                    <select class="form-control select2" id="users" name="users[]" multiple="multiple">
                        <option disabled>الموظفين:</option>
                        @foreach(App\Models\User::all() as $user)
                        <option value="{{$user->id}}">{{$user->username}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-3 col-form-label">الإيقونة :</label>
                <div class="col-8">
                    <input type="file" name="icon" id="icone"  class="form-control file-image" id="file-image">
                    <div id="thumb-output" class="pt-2" ></div><br>
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
   $('.select2').select2();

   
</script>

<script>
    //image input show image by abed
    $(document).ready(function () {
    $('.file-image').on('change', function () { //on file input change
    if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
    {
    $('#thumb-output').html(''); //clear html of output element
    var data = $(this)[0].files; //this file data

    $.each(data, function (index, file) { //loop though each file
    if (/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)) { //check supported file type
    var fRead = new FileReader(); //new filereader
    fRead.onload = (function (file) { //trigger function on successful read
    return function (e) {
    var img = $('<img style="width:120px;height:120px"/>').addClass('thumb').attr('src', e.target.result); //create image element
    $('#thumb-output').append(img); //append image to output element
    };
    })(file);
    fRead.readAsDataURL(file); //URL representing the file's data.
    }
    });

    } else {
    alert("Your browser doesn't support File API!"); //if File API is absent
    }
    });
    });
</script>