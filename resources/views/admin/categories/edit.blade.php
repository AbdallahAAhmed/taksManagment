<div class="row">
    <div class="col-sm-12">
        <form method="post" action="{{ route('categories.update',['id' => $category->id]) }}" class="ajaxForm">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="put">
            <div class="form-group row">
                <label class="col-3 col-form-label">Category Name :</label>
                <div class="col-8">
                    <input class="form-control" name="name" value="{{ $category->name }}" autofocus
                        style="text-align: center" type="text" id="name" autocomplete="off">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-3 col-form-label">Users :</label>
                <div class="col-8">
                    <select class="form-control select2" id="users" name="users[]" multiple="multiple">
                        <option disabled>Users:</option>
                        @foreach(App\Models\User::all() as $user)
                        <option value="{{ $user->id }}" @foreach($category->users as $category_users)
                            @if($category_users->id == $user->id)
                            selected
                            @endif
                            @endforeach>{{ $user->username }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-3 col-form-label">Icon :</label>
                <div class="col-8">
                    <input type="file" name="icon" id="icone" class="form-control file-image" id="file-image">
                    @if ($category->icon)
                    <img src="{{ asset('images/categories/icon/' . $category->icon) }}" class="img-rounded pt-2"
                        height="100px" width="90px" style="border-radius: 10px">
                    @endif
                </div>
            </div>

            <div class="col-sm-8 offset-sm-4">
                <button type="submit" data-refresh="true" class="btn green btn-primary">Save</button>
                <a class="btn btn-default " data-dismiss="modal">Cancel</a>
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