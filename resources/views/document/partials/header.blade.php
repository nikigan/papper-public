<div class="card">
    <div class="card-body">
        <form action="" method="GET" class="mb-0" id="search-form">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="input-group custom-search-form">
                            <span class="input-group-append">
                                @if (Request::has('query') && Request::get('query') != '')
                                    <a href="{{ url()->current()}}"
                                       class="btn btn-light d-flex align-items-center text-muted"
                                       role="button">
                                                            <i class="fas fa-times"></i>
                                                        </a>
                                @endif
                            </span>
                        <input type="text"
                               class="form-control input-solid search-input"
                               id="search"
                               name="query"
                               value="{{ Request::get('query') }}"
                               placeholder="@lang('Search...')">

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-row align-items-center">
                        <div class="col-5">
                            <div class="form-group mb-4">
                                <label for="startDate">@lang('From'):</label>
                                <input name="start_date" class="form-control dp" id="startDate"
                                       value="{{Request::get('start_date') ?? \Carbon\Carbon::now()->subYear()->format( "m-Y")}}">
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group mb-4">
                                <label for="endDate">@lang('To'):</label>
                                <input name="end_date" class="form-control dp" id="endDate"
                                       value="{{ Request::get('end_date') ?? \Carbon\Carbon::now()->format( "m-Y") }}">
                            </div>
                        </div>
                        <div class="col-2">
                            <button class="btn btn-light search-btn" type="submit" id="search-users-btn">
                                <i class="fas fa-search text-muted"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@section('scripts')
    <script>
        $(document).ready(function () {
            $(".dp").datepicker({
                language: "en",
                minView: "months",
                view: "months",
                dateFormat: "mm-yyyy",
                onSelect: function () {
                    $('#search-form').submit();
                }
            });
        })
    </script>
@endsection
