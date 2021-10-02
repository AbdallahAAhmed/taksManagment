<!DOCTYPE html>
<html lang="en">

<head>
    @include('frontend.layout.header-meta')
    @include('frontend.layout.footer-meta')
</head>

<body id="top">
    <!-- start preloader -->
    {{-- @include('frontend.layout.loader') --}}
    <!-- end preloader -->

    <!-- start header -->
    @include('frontend.layout.header')
    @include('frontend.layout.navbar')
    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-md-12 ">
                    <h2 class="wow bounceIn animated" data-wow-offset="50" data-wow-delay="0.3s" style="
                visibility: visible;
                animation-delay: 0.3s;
                animation-name: bounceIn;
              ">
                        LO <span>GIN</span>
                    </h2>
                </div>



                <div class="col-md-6 col-sm-6 col-xs-12 wow fadeInLeft animated" data-wow-offset="50"
                    data-wow-delay="0.9s"
                    style="visibility: visible;animation-delay: 0.9s;animation-name: fadeInLeft; text-align: center;">

                      
                   
                    <form id="postion" action="{{ route('user.login') }}" method="POST">
                        @csrf
                        @if($errors->any())
                        <div class="alert alert-danger" style="text-align: left">
                            <ul>
                                @foreach($errors->all() as $error)
                                <li style="">{{ $error }} </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        
                        @if(Session::has('error'))
                        <div class="row">
                            <button type="text" class="btn btn-lg btn-block btn-outline-danger mb-2" id="type-error">{{Session::get('error')}}
                            </button>
                        </div>
                        @endif

                        <label>USER-NAME :</label>
                        <input name="username" type="text" class="form-control" id="username" />


                        <label>PASSWORD :</label>
                        <input type="password" name="password" class="form-control" id="password">

                         <a href="{{ route('user.register') }}">Register new account</a><br>
                        <button type="submit" style="margin-top: 10px !important;" value=""
                            class=" btn btn-primary">LOGIN</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- start copyright -->
   @include('frontend.layout.footer')
    <!-- end copyright -->
</body>

</html>