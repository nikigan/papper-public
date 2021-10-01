<div class="block-item">
    <div class="block-container">
        <div class="block-header">
            <h3 class="block-title">{{ number_format($count) }}</h3>
        </div>
        <div class="block-content">
            <p class="block-desc">@lang('Clients')</p>
        </div>
    </div>
    <div class="block-footer">
        <a href="{{route('clients.index')}}"><span>@lang('View') @lang('Clients')</span><i
                class="far fa-arrow-alt-circle-left"></i></a>
    </div>
</div>

