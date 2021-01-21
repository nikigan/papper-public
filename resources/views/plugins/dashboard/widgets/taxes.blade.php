<div class="block-item">
    <div class="block-container">
        <div class="block-content">
            <p class="block-desc">@lang('Taxes')</p>
        </div>
        <div class="block-content">
            <p class="block-desc">@lang('VAT to pay'): {{$diff_vat}}</p>
            <p class="block-desc">@lang('Income Tax'): {{$in_tax}}</p>
            <p class="block-desc">@lang('Social Security Payment'): {{$client->social_security}}</p>
        </div>
    </div>
</div>

