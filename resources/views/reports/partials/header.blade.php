<div class="card">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-6">
                <form action="" method="GET" class="mb-0" id="search-form">
                    <div class="form-row align-items-center">
                        <div class="col">
                            <div class="form-group">
                                <label for="startDate">@lang('From'):</label>
                                <input name="start_date" class="form-control datechk" id="startDate"
                                       value="{{Request::get('start_date') ?? \Carbon\Carbon::now()->format('Y-m-d', strtotime(date('Y-m-d') . "-{$client->report_period} month"))}}">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="endDate">@lang('To'):</label>
                                <input name="end_date" class="form-control datechk" id="endDate"
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
                    <form method="GET">
                        <input type="hidden" name="start_date" value="{{Request::get('start_date')}}">
                        <input type="hidden" name="end_date" value="{{Request::get('end_date')}}">
                        <button type="submit" class="btn btn-primary"
                           formaction="{{route($route.'.excel', [$client])}}"><i
                                class="far fa-file-excel"></i></button>
                        <button type="submit" class="btn btn-danger"
                           formaction="{{route($route.'.pdf', [$client])}}"><i
                                class="far fa-file-pdf"></i></button>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="percentage" name="percentage">
                            <label class="custom-control-label" for="percentage">@lang("Include percents")</label>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
