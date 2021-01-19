@if ($item && $item->authorize(auth()->user()))
    <li class="nav-main-item">
        <a href="{{ $item->getHref() }}" class="nav-main-link {{ Request::is($item->getActivePath()) || Route::is($item->getActivePath()) ? 'active' : '' }}"
           @if($item->isDropdown())
           data-toggle="collapse"
           aria-expanded="{{ Request::is($item->getExpandedPath()) ? 'true' : 'false' }}"
            @endif>
            @if ($item->getIcon())
                <i class="{{ $item->getIcon() }}"></i>
            @endif
                <span class="nav-main-link-name">{{ $item->getTitle() }}</span>
                @if($item->getCount())
                    <span class="badge badge-pill badge-danger">{{$item->getCount()}}</span>
                @endif
        </a>
        @if ($item->isDropdown())
            <ul class="{{ Request::is($item->getExpandedPath()) ? '' : 'collapse' }} list-unstyled sub-menu"
                id="{{ str_replace('#', '', $item->getHref()) }}">
                @foreach ($item->children() as $child)
                    @include('partials.sidebar.items', ['item' => $child])
                @endforeach
            </ul>
        @endif
    </li>
{{--    <li class="nav-item">
        <a class="nav-link {{ Request::is($item->getActivePath()) ? 'active' : '' }}"
           href="{{ $item->getHref() }}"
           @if($item->isDropdown())
           data-toggle="collapse"
           aria-expanded="{{ Request::is($item->getExpandedPath()) ? 'true' : 'false' }}"
            @endif
        >
            @if ($item->getIcon())
                <i class="{{ $item->getIcon() }}"></i>
            @endif

            <span>{{ $item->getTitle() }}</span>
            @if($item->getCount())
                <span class="badge badge-pill badge-danger">{{$item->getCount()}}</span>
            @endif
        </a>

        @if ($item->isDropdown())
            <ul class="{{ Request::is($item->getExpandedPath()) ? '' : 'collapse' }} list-unstyled sub-menu"
                id="{{ str_replace('#', '', $item->getHref()) }}">
                @foreach ($item->children() as $child)
                    @include('partials.sidebar.items', ['item' => $child])
                @endforeach
            </ul>
        @endif
    </li>--}}
@endif
