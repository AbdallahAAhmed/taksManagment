@if (is_null($contacts->message))
No Message
@else
<button data-toggle="modal" data-target="#contact_{{$contacts->id}}" class="btn btn-info btn-sm" id="notbtn">
    Show Message
</button>
@endif

<div class="modal fade Popup" id="contact_{{$contacts->id}}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Show Message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body " style=" text-align: right!important;font-size: 1.3em!important;">
                <p>{{Str::limit($contacts->message,70)}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@section('css')
    
<style>
    .modal-body p {
        word-wrap: break-word;
    }
    </style>
    @endsection

