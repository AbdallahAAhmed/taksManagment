@if(Session::get("msg")!=NULL)
    <?php
    $msg=Session::get("msg");
    $msgClass="alert-info";
    if(strpos($msg,"s:")===0){
        $msgClass="alert-success"; $msg=substr($msg,2);
    }
    else if(strpos($msg,"e:")===0){
        $msgClass="alert-danger"; $msg=substr($msg,2);
    }
    else if(strpos($msg,"w:")===0){
        $msgClass="alert-warning"; $msg=substr($msg,2);
    }
    else if(strpos($msg,"i:")===0){
        $msgClass="alert-info"; $msg=substr($msg,2);
    }
    ?>
    <div class="alert {{$msgClass}} alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      {{$msg}}.
    </div>
@endif




@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
