<ul class="nav nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    @role('user')
    @include('layouts.menu.user')
    @endrole
    @role('admin')
    @include('layouts.menu.admin')
    @endrole
</ul>
