<div class="block-item">
    <div class="block-container">
        <div class="block-header">
            <h3 class="block-title">{{ number_format($count) }}</h3>
        </div>
        <div class="block-content">
            <p class="block-desc">@lang('Waiting documents')</p>
        </div>
    </div>
    <div class="block-footer">
        <a href="{{route('documents.waiting')}}"><span>@lang('Show') @lang('Documents')</span><i
                class="far fa-arrow-alt-circle-left"></i></a>
    </div>
</div>

