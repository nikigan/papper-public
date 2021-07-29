<?php /** @var Vanguard\Document $document
 * @var Vanguard\DocumentCheck $document_check
 */ ?>
<div>
    <p>
        {{ $document_check->text }}
    </p>
</div>
<div>
    <p>@lang('Document number: ') {{$document->document_number}}</p>
    <p>@lang('Document date: ') {{$document->document_date}}</p>
    <a href="{{route('documents.show', $document)}}">@lang('Link to the document')</a>

</div>
