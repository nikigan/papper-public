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
                    <li>
                        <form
                            action="{{route('documents.check', ['document_check' => $check, 'document' => $document])}}">
                            @csrf
                            <textarea rows="3" class="form-control" name="custom_text"
                                      placeholder="@lang("Custom text")"></textarea>
                            <button type="submit" class="btn btn-primary mt-2">@lang("Send")</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
