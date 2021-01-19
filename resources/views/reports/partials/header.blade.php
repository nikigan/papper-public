<div class="card">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-6">
                <form action="" method="GET" class="mb-0" id="search-form">
                    <div class="form-row align-items-center">
                        <div class="col">
                            <div class="form-group">
                                <label for="startDate">@lang('From'):</label>
                                <input type="date" name="start_date" class="form-control datechk" id="startDate"
                                       value="{{Request::get('start_date') ?? date('Y-m-d', strtotime(date('Y-m-d') . "-{$client->report_period} month"))}}">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="endDate">@lang('To'):</label>
                                <input type="date" name="end_date" class="form-control datechk" id="endDate"
                                       value="{{ Request::get('end_date') ?? date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col">
                            <button class="btn btn-primary" type="submit">{{ __('Make report')}}</button>
                        </div>
                    </div>
                </form>
            </div>
            @isset($route)
                <div class="col-md-6 text-left">
                    <a class="btn btn-primary"
                       href="{{route($route.'.excel', [$client, request()->getQueryString()])}}"><i
                            class="far fa-file-excel"></i></a>
                    <a class="btn btn-danger"
                       href="{{route($route.'.pdf', [$client, request()->getQueryString()])}}"><i
                            class="far fa-file-pdf"></i></a>
                </div>
            @endif
        </div>
    </div>
</div>
