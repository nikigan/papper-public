<tr>
    <td style="width: 40px;">
        <a href="{{ route('accountants.show', $user->id) }}">
            <img
                class="rounded-circle img-responsive"
                width="40"
                src="{{ $user->present()->avatar }}"
                alt="{{ $user->present()->name }}">
        </a>
    </td>
    <td class="align-middle">
        <a href="{{ route('accountants.show', $user->id) }}">
            {{ $user->username ?: __('N/A') }}
        </a>
    </td>
    <td class="align-middle">{{ $user->first_name . ' ' . $user->last_name }}</td>
    <td class="align-middle">{{ $user->email }}</td>
    <td class="align-middle">{{ $user->created_at->format(config('app.date_format')) }}</td>

    <td class="text-center align-middle">
        <a href="{{ route('accountants.show', $user->id) }}" class="btn btn-icon edit"
           title="@lang('View Accountant')"
           data-toggle="tooltip" data-placement="top">
            <i class="fas fa-eye"></i>
        </a>
    </td>
</tr>
