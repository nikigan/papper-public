<div class="table-responsive" id="users-table-wrapper">
    <table class="table table-borderless table-striped" data-table="users">
        <thead>
        <tr>
            <th></th>
            <th class="min-width-80"><a data-sort-prop="username" class="table-sort-btn">@lang('Username')</a></th>
            <th class="min-width-150"><a data-sort-prop="first_name" class="table-sort-btn">@lang('Full Name')</a></th>
            <th class="min-width-100"><a data-sort-prop="email" class="table-sort-btn">@lang('Email')</a></th>
            <th class="min-width-80"><a data-sort-prop="created_at" class="table-sort-btn">@lang('Registration Date')</a></th>
            <th class="min-width-80"><a data-sort-prop="accountant_id" class="table-sort-btn">@lang('Accountant')</a></th>
            <th class="text-center min-width-150">@lang('Action')</th>
        </tr>
        </thead>
        <tbody>
        @if (count($users))
            @foreach ($users as $user)
                @include('clients.partials.row')
            @endforeach
        @else
            <tr>
                <td colspan="7"><em>@lang('No records found.')</em></td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
