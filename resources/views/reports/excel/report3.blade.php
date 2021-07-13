@extends('layouts.excel')
<?php /** @var \Vanguard\User $client */ ?>
@section('content')
    <p>@lang("Name"):{{$client->present()->name}}</p>
    <p>@lang("Passport"):{{$client->passport}}</p>
    <p>@lang("VAT number"):{{$client->vat_number}}</p>
    <p>@lang("From"):{{$start_date}}</p>
    <p>@lang("To"):{{$end_date}}</p>
    @if (count($groups))
        <table class="table">
            <thead>
            <tr>
                <th>@lang('Name')</th>
                <th>@lang('Sum')</th>
                @if($percentage)<th>@lang('%')</th>@endif
            </tr>
            </thead>
            <tbody class="text-success">
            @foreach ($groups as $name => $group)
                <tr>
                    <td style="font-weight: bold">{{$name != "" && $name != null ? $name : __('Other Income Group')}}</td>
                    <td style="font-weight: bold">{{number_format($group['sum'], 2) ?? 'N/A'}}</td>
                    @if($percentage)<td style="font-weight: bold">100%</td>@endif
                </tr>
                @foreach($group['subgroups'] as $n => $subgroup)
                    @if($n != "Other")
                        <tr>
                            <td>{{$n ?? 'Other'}}</td>
                            <td>{{number_format($subgroup['sum'], 2)}}</td>
                            @if($percentage)<td>{{number_format($subgroup['percentage'], 2)}}%</td>@endif
                        </tr>
                    @endif
                @endforeach
            @endforeach
            <tr style="font-weight: bold">
                <td style="font-weight: bold">@lang('Sum')</td>
                <td style="font-weight: bold">{{number_format($income_sum, 2)}}</td>
                @if($percentage)<td></td>@endif
            </tr>
            </tbody>
        </table>
    @endif

    @if (count($expense_groups))
        <table class="table">
            <thead>
            <tr>
                <th>@lang('Name')</th>
                <th>@lang('Sum')</th>
                @if($percentage)<th>@lang('%')</th>@endif
            </tr>
            </thead>
            <tbody class="text-danger">
            @foreach ($expense_groups as $name => $group)
                <tr style="font-weight: bold">
                    <td style="font-weight: bold">{{$name != "" && $name != null ? $name : __('Other Expense Group')}}</td>
                    <td style="font-weight: bold">{{number_format($group['sum'], 2) ?? 'N/A'}}</td>
                    @if($percentage)<td style="font-weight: bold">100%</td>@endif
                </tr>
                @foreach($group as $n => $subgroup)
                    @if($n == 'sum' || !$n)
                        @continue
                    @endif
                    <tr>
                        <td>{{$n != "" && $n != null ? $n :'Other'}}</td>
                        <td>{{number_format($subgroup[0]['sum'], 2)}}</td>
                        @if($percentage)<td>{{number_format($subgroup[0]['percentage'], 2)}}%</td>@endif
                    </tr>
                @endforeach
            @endforeach
            <tr style="font-weight: bold">
                <td style="font-weight: bold">@lang('Sum')</td>
                <td style="font-weight: bold">{{number_format($expense_sum, 2)}}</td>
                @if($percentage)<td></td>@endif
            </tr>
            </tbody>
        </table>
    @endif
    <table>
        <tr>
            <td style="font-weight: bold">@if($diff >= 0)
                    @lang('Report 3 Income')</td>
            <td style="font-weight: bold">{{number_format($diff, 2)}}
                @else
                    @lang('Report 3 Expense')</td>
            <td style="font-weight: bold">({{number_format($diff, 2)}})
            @endif
        </tr>
    </table>
@stop
