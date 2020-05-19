<!-- Brand Logo -->
<a class="navbar-brand ml-3" href="{{ url('/') }}">
    <b>
        <span id="sidebar-brand">{{ config('app.name', 'Laravel') }}</span>
    </b>
</a>

<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <li class="nav-item">
                <a href="{{route('profile')}}" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>@lang('Profile')</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('training.dashboard')}}" class="nav-link">
                    <i class="nav-icon fas fa-graduation-cap"></i>
                    <p>@lang('Training')</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('deck.index')}}" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>@lang('Decks')</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('vocabulary.index')}}" class="nav-link">
                    <i class="nav-icon fas fa-book"></i>
                    <p>@lang('Vocabulary')</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('collections')}}" class="nav-link">
                    <i class="nav-icon fas fa-star"></i>
                    <p>@lang('Collections')</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('storybook.index')}}" class="nav-link">
                    <i class="nav-icon fas fa-tree"></i>
                    <p>@lang('Storybooks')</p>
                </a>
            </li>

            <li class="nav-header">@lang('ADDITIONALLY')</li>
            <li class="nav-item">
                <a href="{{route('settings.index')}}" class="nav-link">
                    <i class="nav-icon fas fa-cog"></i>
                    <p>@lang('Settings')</p>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
