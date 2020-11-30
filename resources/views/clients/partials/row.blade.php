<tr>
    <td style="width: 40px;">
        <a href="{{ route('clients.show', $user->id) }}">
            <img
                class="rounded-circle img-responsive"
                width="40"
                src="{{ $user->present()->avatar }}"
                alt="{{ $user->present()->name }}">
        </a>
    </td>
    <td class="align-middle">
        <a href="{{ route('clients.show', $user->id) }}">
            {{ $user->username ?: __('N/A') }}
        </a>
    </td>
    <td class="align-middle">{{ $user->first_name . ' ' . $user->last_name }}</td>
    <td class="align-middle">{{ $user->email }}</td>
    <td class="align-middle">{{ $user->created_at->format(config('app.date_format')) }}</td>
    {{--<td class="align-middle">
        <span class="badge badge-lg badge-{{ $user->present()->labelClass }}">
            {{ trans("app.status.{$user->status}") }}
        </span>
    </td>--}}
    <td class="text-center align-middle">
        <a href="{{ route('clients.show', $user->id) }}" class="btn btn-icon edit"
           title="@lang('View Client')"
           data-toggle="tooltip" data-placement="top">
            <i class="fas fa-eye mr-2"></i>
        </a>
    </td>
</tr>
