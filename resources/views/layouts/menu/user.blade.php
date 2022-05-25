<ul class="nav nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item" style="border-bottom:solid 1px #000;">
        <a href="{{ route('home') }}" class="nav-link @if (Request::segment(2)=='weights' ) active @endif">
            <i class="fas fa-home sidebari"></i>
            <p>{{ __('menu.home') }} </p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{route('user.edit', ['user' => \Illuminate\Support\Facades\Auth::id()])}}" class="nav-link @if(Request::segment(2) == 'users') active @endif">
            <i class="fas fa-user sidebari"></i>
            <p>{{__('menu.profilmanag')}} </p>
        </a>
    </li>
</ul>
