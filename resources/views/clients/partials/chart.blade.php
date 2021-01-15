<canvas id="clientChart" width="400" height="200"></canvas>
@section('scripts')
    <script>
        $(document).ready(function () {
            const ctx = document.getElementById('clientChart');
            const myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode(array_reverse(array_keys($monthly_docs)), JSON_NUMERIC_CHECK) !!},
                    datasets: [{
                        label: 'Sum',
                        data: {!! json_encode(array_reverse(array_column($monthly_docs, 'sum'))) !!},
                        borderColor: 'blue'
                    }]
                },
                responsive: true,
                options: {
                    plugins: {
                        datalabels: {
                            formatter: function(value, context) {
                                return value.toFixed(2);
                            }
                        }
                    }
                }
            })
        });
    </script>
@stop

