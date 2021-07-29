<div class="table-responsive" id="users-table-wrapper">
    <table class="table table-borderless table-striped" data-table="documents">
        <thead>
        <tr>
            <th class="min-width-80"><a data-sort-prop="document_number"
                                        class="table-sort-btn">@lang('Document number')</a></th>
            <th class="min-width-100"><a data-sort-prop="user_id" class="table-sort-btn">@lang('Username')</a></th>
            <th class="min-width-80"><a data-sort-prop="document_date" class="table-sort-btn">@lang('Document date')</a>
            </th>
            <th class="min-width-80"><a data-sort-prop="status" class="table-sort-btn">@lang('Status')</a></th>
            <th class="min-width-100"><a data-sort-prop="sum" class="table-sort-btn">@lang('Sum')</a></th>
            <th class="min-width-100"><a data-sort-prop="vat" class="table-sort-btn">@lang('VAT')</a></th>
            <th class="min-width-100"><a data-sort-prop="sum_without_vat"
                                         class="table-sort-btn">@lang('Sum without VAT')</a></th>
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
                    <td><strong class="{{$sum_class}}">{{number_format($sum, 2)}} ₪</strong></td>
                    <td><strong class="{{$sum_class}}">{{number_format($vat, 2)}} ₪</strong></td>
                    <td><strong class="{{$sum_class}}">{{number_format($sum - $vat, 2)}} ₪</strong></td>
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
@if($documents instanceof \Illuminate\Pagination\LengthAwarePaginator)
    {{ $documents->onEachSide(0)->withQueryString()->links() }}
@endif

@foreach($documents as $document)
    <div class="modal" tabindex="-1" id="documentCheckModal-{{$document->id}}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang("Document check")</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        @foreach($document_checks as $check)
                            <li class="list-group-item">
                                <a href="{{route('documents.check', ['document_check' => $check, 'document' => $document])}}">{{$check->title}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endforeach
