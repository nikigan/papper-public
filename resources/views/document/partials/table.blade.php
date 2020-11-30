<div class="table-responsive" id="users-table-wrapper">
    <table class="table table-borderless table-striped">
        <thead>
        <tr>
            <th class="min-width-80">@lang('Document id')</th>
            <th class="min-width-100">@lang('Username')</th>
            <th class="min-width-80">@lang('Upload date')</th>
            <th class="min-width-80">@lang('Status')</th>
            <th class="min-width-100">@lang('Sum')</th>
            <th class="min-width-100">@lang('VAT')</th>
            <th class="text-center min-width-100">@lang('Action')</th>
        </tr>
        </thead>
        <tbody>
        @if (count($documents))
            @foreach ($documents as $document)
                @include('document.partials.row')
            @endforeach
            @isset($sum_class)
                <tr>
                    <td colspan="4"></td>
                    <td><strong class="{{$sum_class}}">@money($sum)</strong></td>
                    <td><strong class="{{$sum_class}}">@money($vat)</strong></td>
                    <td></td>
                </tr>
            @endisset
        @else
            <tr>
                <td colspan="7"><em>@lang('No records found.')</em></td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
