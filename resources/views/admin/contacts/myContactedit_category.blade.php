<div class="row">
    <div class="col-sm-12">
        <form method="post" action="{{ route('mycontacts.update',['id' => $contact->id]) }}" class="ajaxForm">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="put">

            <div class="form-group row">
                <label class="col-xl-3 col-lg-3 col-form-label text-right">Category</label>
                <div class="col-8">
                    <select class="form-control select2" id="category_id" name="category_id">
                        <option disabled>Category:</option>
                        @foreach(App\Models\Category::all() as $category)
                        <option {{ ($category->id == $contact->category_id) ? 'selected' : '' }}
                            value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
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