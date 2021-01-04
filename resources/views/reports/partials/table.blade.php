<div class="table-responsive">
    <table class="table table-borderless table-striped">
        <thead>
        <tr>
            @foreach($columns as $column)
                <th>@lang($column['title'])</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @if (count($items))
            @foreach ($items as $item)
                <tr>
                    @foreach($columns as $column)
                        <td class="{{$class ?? ''}}">{{ $item->getAttribute($column['name']) }}</td>
                    @endforeach
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="5"><em>@lang('No records found.')</em></td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
