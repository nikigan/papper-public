<div class="card">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-6">
                <form action="" method="GET" class="mb-0" id="search-form">
                    <div class="form-row align-items-center">
                        <div class="col">
                            <div class="form-group">
                                <label for="startDate">@lang('From'):</label>
                                <input name="start_date" class="form-control dp"
                                       id="startDate"
                                       value="{{Request::get('start_date') ?? $start_date}}">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="endDate">@lang('To'):</label>
                                <input name="end_date" class="form-control dp"
                                       id="endDate"
                                       value="{{ Request::get('end_date') ?? $end_date }}">
                            </div>
                        </div>
                        <div class="col">
                            <button class="btn btn-primary" type="submit">{{ __('Make report')}}</button>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div class="input-group custom-search-form">
                            <span class="input-group-prepend">
                                @if (Request::has('query') && Request::get('query') != '')
                                    <a href="{{ url()->current()}}"
                                       class="btn btn-light d-flex align-items-center text-muted"
                                       role="button">
                                                            <i class="fas fa-times"></i>
                                                        </a>
                                @endif
                                <button class="btn btn-light" type="submit" id="search-users-btn">
                                    <i class="fas fa-search text-muted"></i>
                                </button>
                            </span>
                                <input type="text"
                                       class="form-control input-solid"
                                       id="search"
                                       name="query"
                                       value="{{ Request::get('query') }}"
                                       placeholder="@lang('Search...')">

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            @isset($route)
                <div class="col-md-6 text-left">
                    <form method="GET">
                        <input type="hidden" name="start_date" value="{{Request::get('start_date')}}">
                        <input type="hidden" name="end_date" value="{{Request::get('end_date')}}">
                        <button type="submit" class="btn btn-primary"
                                formaction="{{route($route.'.excel', [$client])}}"><i
                                class="far fa-file-excel"></i></button>
                        <button type="submit" class="btn btn-danger"
                                formaction="{{route($route.'.pdf', [$client])}}"><i
                                class="far fa-file-pdf"></i></button>
                        @if($show_percents ?? false)
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="percentage" name="percentage">
                            <label class="custom-control-label" for="percentage">@lang("Include percents")</label>
                        </div>
                        @endif
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>

@section('scripts')
    <script>
        $(document).ready(function () {
            const options = {
                language: "en",
                minView: "months",
                view: "months",
                dateFormat: "mm-yyyy"
            };
            const reportPeriod = {{$client->report_period}};
            let flag = true;

            const startDate = $("#startDate").datepicker({
                ...options,
                onSelect: function (_, date) {
                    if (flag) {
                        flag = false;
                        const d = date;
                        d.setMonth(d.getMonth() + reportPeriod);
                        endDate.selectDate(d);
                    } else {
                        flag = true;
                    }
                }
            }).data('datepicker');

            const endDate = $("#endDate").datepicker({
                ...options,
                onSelect: function (_, date) {
                    if (flag) {
                        flag = false;
                        const d = date;
                        d.setMonth(d.getMonth() - reportPeriod);
                        startDate.selectDate(d);
                    } else {
                        flag = true;
                    }
                }
            }).data('datepicker');
        });
    </script>
@endsection
