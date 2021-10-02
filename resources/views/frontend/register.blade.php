<!DOCTYPE html>
<html lang="en">

<head>
  
    @extends('frontend.layout.header-meta')
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
                        NEW <span>REGISTER</span>
                    </h2>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-12 wow fadeInLeft animated" data-wow-offset="50"
                    data-wow-delay="0.9s"
                    style="visibility: visible;animation-delay: 0.9s;animation-name: fadeInLeft; text-align: center;">

                    <form id="postion" action="{{ route('user.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>USER-NAME <span class="text-danger">*</span></label>
                            <input name="username" type="text" value="{{ old('username') }}" class="form-control @error('username') is-invalid @enderror" id="username" />
                            @error('username')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>EMAIL <span class="text-danger">*</span></label>
                            <input name="email" type="email" class="form-control" id="email" />
                            @error('email')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label>PHONE <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" id="phone">
                            @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>PASSWORD <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" id="password">
                            @error('password')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>PASSWORD CONFIRMATION<span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control" id="password">
                            @error('password')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                      
                        <a href="{{ route('show.login') }}" >already have account ?</a><br>
                        <button type="submit" style="margin-top: 10px !important;" value="" class=" btn btn-primary">REGISTER</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @include('frontend.layout.footer')
</body>

</html>