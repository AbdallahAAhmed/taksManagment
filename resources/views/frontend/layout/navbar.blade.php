    <nav class="navbar navbar-default templatemo-nav" role="navigation">
        <a href="{{ route('home.index') }}"><img src="{{ asset('front_end/logo.png') }}" class="img" width="40px" alt=""></a>
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon icon-bar"></span>
                <span class="icon icon-bar"></span>
                <span class="icon icon-bar"></span>
            </button>
            <a href="{{ route('home.index') }}" class="navbar-brand">Task Management system</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#top">HOME</a></li>
                <li><a href="#about">ABOUT</a></li>
            </ul>
        </div>
    </div>
</nav>

<style>
    .img{
        margin-bottom: -83px;
        margin-left: 105px;
    }
</style>