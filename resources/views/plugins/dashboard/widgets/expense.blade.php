<div class="block-item">
    <div class="block-container">
        <div class="block-header">
            <h3 class="block-title">{{$exp_sum}}</h3>
        </div>
        <div class="block-content">
            <p class="block-desc">@lang('Expense')</p>
        </div>
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: {{$diff}}%" aria-valuenow="{{$diff}}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <p>@lang('Difference'): {{$diff}}%</p>
        <p>@lang('Last Month'): {{$exp_sum_prev}}</p>
    </div>
</div>

