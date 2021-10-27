<!DOCTYPE html>
<html lang="en">

<head>

    @include('frontend.layout.header-meta')
    @include('frontend.layout.footer-meta')
</head>

<body id="top">

    <!-- start preloader -->
    @include('frontend.layout.loader')
    <!-- end preloader -->

    <!-- start header -->
    @include('frontend.layout.header')
    <!-- end header -->

    <!-- start navigation -->
    @include('frontend.layout.navbar')
    <!-- end navigation -->

    <!-- start home -->
    <section id="home">
        <div class="container">
            <div class="row">
                <div class="col-md-offset-2 col-md-8">
                    <h1 class="wow fadeIn" data-wow-offset="50" data-wow-delay="0.9s">We make website that are
                        <span>{{$settings->title}}</span></h1>
                    <div class="element">
                        <div class="sub-element">Hello, This is a task Management Website.</div>
                        <div class="sub-element">Task Management system Website is Designed and provided by Giri
                            Designs.</div>
                        <div class="sub-element">If you need this website, Please contact us.</div>
                    </div>
                    @if (auth()->check())
                    @else
                    <a href="{{ route('user.register') }}" class="btn btn-default wow fadeInUp" data-wow-offset="50"
                        data-wow-delay="0.6s">NEW RIGISTER</a>
                    @endif

                </div>
            </div>
        </div>
    </section>
    <!-- end home -->
    <!-- start about -->
    <section id="about">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="wow bounceIn" data-wow-offset="50" data-wow-delay="0.3s">WE ARE <span>{{$settings->title}}</span></h2>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 wow fadeInLeft" data-wow-offset="50" data-wow-delay="0.6s">
                    <div class="media">
                        <div class="media-heading-wrapper">
                            <div class="media-object pull-left">
                                <i class="fa fa-mobile"></i>
                            </div>
                            <h3 class="media-heading">FULLY RESPONSIVE</h3>
                        </div>
                        <div class="media-body">
                            <p>
                                @if (isset($about->responsive))
                                {{ $about->responsive }}
                                 @endif
                        </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 wow fadeInUp" data-wow-offset="50" data-wow-delay="0.9s">
                    <div class="media">
                        <div class="media-heading-wrapper">
                            <div class="media-object pull-left">
                                <i class="fa fa-comment-o"></i>
                            </div>
                            <h3 class="media-heading">FREE SUPPORT</h3>
                        </div>
                        <div class="media-body">
                            <p>
                                @if (isset($about->support))
                                {{ $about->support }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 wow fadeInRight" data-wow-offset="50" data-wow-delay="0.6s">
                    <div class="media">
                        <div class="media-heading-wrapper">
                            <div class="media-object pull-left">
                                <i class="fa fa-columns"></i>
                            </div>
                            <h3 class="media-heading">Stay on track to hit project goals.</h3>
                        </div>
                        <div class="media-body">
                            <p>
                                @if (isset($about->goal_track))
                                {{ $about->goal_track }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end about -->


    <!-- start copyright -->
    @include('frontend.layout.footer')
    <!-- end copyright -->

</body>

</html>