<tr>
    <td class="align-middle">
        <a href="{{ route('documents.show', $document) }}">
            {{ $document->document_number ?: __('N/A') }}
        </a>
    </td>
    <td class="align-middle">
        <a href="
        @if ($document->user->id == auth()->id())
        {{ route('profile') }}
        @else
        {{ route('clients.show', $document->user) }}
        @endif">
            {{ $document->user->username ?: __('N/A') }}
        </a>
    </td>
    <td class="align-middle">{{ $document->getDocumentDate() ?? 'N/A'}}</td>
    <td class="align-middle">
        <span class="badge badge-lg badge-{{ $document->present()->labelClass() }}">
            {{ trans("document.status.{$document->status}") }}
        </span>
    </td>
    <td class="align-middle">
        <span class="{{$document->present()->sumClass()}}">{{$document->present()->sum()}}</span>
    </td>
    <td class="align-middle">
        <span class="{{$document->present()->sumClass()}}">{{$document->present()->vat()}}</span>
    </td>
    <td class="align-middle">
        <span class="{{$document->present()->sumClass()}}">{{$document->present()->sum_without_vat()}}</span>
    </td>
    <td class="text-center align-middle">
        {{--<div class="dropdown show d-inline-block">
            <a class="btn btn-icon"
               href="#" role="button" id="dropdownMenuLink"
               data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-h"></i>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                <a href="{{ route('documents.show', $document) }}" class="dropdown-item text-gray-500">
                    <i class="fas fa-eye mr-2"></i>
                    @lang('View Document')
                </a>
            </div>
        </div>--}}


        <a href="{{ route('documents.show', $document) }}"
           class="btn btn-icon"
           title="@lang('View Document')"
           data-toggle="tooltip"
           data-placement="top">
            <i class="fas fa-eye"></i>
        </a>
        {{--@if($current_user->hasPermission('document.edit'))
            <a href="--}}{{--- route('documents.edit', $document) ---}}{{--"
               class="btn btn-icon edit"
               title="@lang('Edit document')"
               data-toggle="tooltip" data-placement="top">
                <i class="fas fa-edit"></i>
            </a>
        @endif--}}


        @if(auth()->user()->hasPermission('document.delete'))
            @if(!$document->trashed())
                <a href="{{ route('documents.destroy', $document) }}"
                   class="btn btn-icon"
                   title="@lang('Delete Document')"
                   data-toggle="tooltip"
                   data-placement="top"
                   data-method="DELETE"
                   data-confirm-title="@lang('Please Confirm')"
                   data-confirm-text="@lang('Are you sure that you want to delete this document?')"
                   data-confirm-delete="@lang('Yes, delete it!')">
                    <i class="fas fa-trash"></i>
                </a>
            @else
                <a href="{{ route('documents.restore', ['document' => $document ]) }}"
                   class="btn btn-icon"
                   title="@lang('Restore Document')"
                   data-toggle="tooltip"
                   data-placement="top"
                   data-method="GET"
                   data-confirm-title="@lang('Please Confirm')"
                   data-confirm-text="@lang('Are you sure that you want to restore this document?')"
                   data-confirm-get="@lang('Yes, restore it!')">
                    <i class="fas fa-trash-restore"></i>
                </a>
            @endif
        @endif
    </td>
</tr>
