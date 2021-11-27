<div class="row">
    <div class="col-sm-12">
        <form method="post" action="{{ route('projects.update',['id' => $project->id]) }}" class="ajaxForm">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="put">
            <div class="form-group row">
                <label class="col-3 col-form-label">Project Name :</label>
                <div class="col-8">
                    <input class="form-control" value="{{ $project->project_name }}" name="project_name" autofocus style="text-align: center" type="text"
                        id="project_name" autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-3 col-form-label">Start Date :</label>
                <div class="col-8">
                    <input type="date" value="{{ $project->start_date }}" name="start_date" class="form-control" style="text-align: center">
                </div>
            </div>
            
            <div class="form-group row">
               <label class="col-3 col-form-label">End Date :</label>
                <div class="col-8">
                    <input type="date" name="end_date" value="{{ $project->end_date }}" class="form-control" style="text-align: center">
                </div>
            </div>
            
            <div class="form-group row">
                 <label class="col-3 col-form-label">Description :</label>
                <div class="col-8">
                    <textarea name="description" id="description" style="text-align: center" cols="40" rows="5">{{$project->description }}</textarea>
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