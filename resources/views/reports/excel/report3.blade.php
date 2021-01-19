@extends('layouts.excel')
@section('content')

    @if (count($groups))
        <table class="table">
            <thead>
            <tr>
                <th>@lang('Name')</th>
                <th>@lang('Sum')</th>
                <th>@lang('%')</th>
            </tr>
            </thead>
            <tbody class="text-success">
            @foreach ($groups as $name => $group)
                <tr>
                    <td style="font-weight: bold">{{$name != "" && $name != null ? $name : __('Other Income Group')}}</td>
                    <td style="font-weight: bold">{{number_format($group['sum'], 2) ?? 'N/A'}}</td>
                    <td style="font-weight: bold">100%</td>
                </tr>
                @foreach($group['subgroups'] as $n => $subgroup)
                    @if($n != "Other")
                        <tr>
                            <td>{{$n ?? 'Other'}}</td>
                            <td>{{number_format($subgroup['sum'], 2)}}</td>
                            <td>{{number_format($subgroup['percentage'], 2)}}%</td>
                        </tr>
                    @endif
                @endforeach
            @endforeach
            </tbody>
        </table>
    @endif

    @if (count($expense_groups))
        <table class="table">
            <thead>
            <tr>
                <th>@lang('Name')</th>
                <th>@lang('Sum')</th>
                <th>@lang('%')</th>
            </tr>
            </thead>
            <tbody class="text-danger">
            @foreach ($expense_groups as $name => $group)
                <tr style="font-weight: bold">
                    <td style="font-weight: bold">{{$name != "" && $name != null ? $name : __('Other Expense Group')}}</td>
                    <td style="font-weight: bold">{{number_format($group['sum'], 2) ?? 'N/A'}}</td>
                    <td style="font-weight: bold">100%</td>
                </tr>
                @foreach($group as $n => $subgroup)
                    @if($n == 'sum' || !$n)
                        @continue
                    @endif
                    <tr>
                        <td>{{$n != "" && $n != null ? $n :'Other'}}</td>
                        <td>{{number_format($subgroup[0]['sum'], 2)}}</td>
                        <td>{{number_format($subgroup[0]['percentage'], 2)}}%</td>
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
    @endif

@stop
