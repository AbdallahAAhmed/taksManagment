<header>
<div class="container">
    <div class="row">
        <div class="col-md-3 col-sm-4 col-xs-12">
            <p><i class="fa fa-phone"></i><span> Phone</span>+9999999999</p>
        </div>
        <div class="col-md-3 col-sm-4 col-xs-12">
            <p><i class="fa fa-envelope-o"></i><span> Email</span><a
                    href="mailto:giridesigns5@gmail.com">task.manage@gmail.com</a></p>
        </div>
        <div class="col-md-5 col-sm-4 col-xs-12">
            <ul class="social-icon">
                <li><span>Follwo us</span></li>
                <li><a href="#" class="fa fa-facebook"></a></li>
                <li><a href="#" class="fa fa-twitter"></a></li>
                <li><a href="#" class="fa fa-instagram"></a></li>
            </ul>
        </div>
        @if (auth()->check())
            <span class="fa fa-user"></span>{{Str::limit(auth()->user()->username, 8) }}
            <a href="{{ route('user.logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><br>
                 <span class="fa fa-share-square-o primary-font"></span>{{ "logout"." " }}
                <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </a>
          @else
          <a href="{{ route('show.login') }}">LOGIN</a>
        @endif
    </div>
</div>
</header>