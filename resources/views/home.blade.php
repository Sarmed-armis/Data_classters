@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif



                        <div class="container">
                            <div class="row my-3">
                                <div class="col">
                                    <h4>Datasets</h4>
                                    <a href="{{url('reset')}}" class=" btn btn-danger">Reset</a>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div id="chart_div"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif



                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif



                    <div class="container">
                        <div class="row my-3">
                            <div class="col">
                                <h4>Datasets</h4>
                                <form method="post" action="{{url('store')}}">
                                    @csrf
                                    <div class = "form-group">
                                        <input type = "text"  name="min" class = "form-control" id = "name" placeholder = "min">
                                    </div>
                                    <div class = "form-group">

                                        <input type = "text"  name="ex" class = "form-control" id = "name" placeholder = "ex">

                                    </div>

                                    <button type="submit" class="btn btn-success">Submit</button>

                                </form>
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div id="chart_div2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>





</div>
@endsection
@section("javascript")
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChartofunvisited);

        function drawChartofunvisited() {
            var data = google.visualization.arrayToDataTable([
                ['x-axis', 'unvisited'],
                @foreach($unvisiteds as $unvisited)

                [ {{$unvisited->x_axis}},{{$unvisited->y_axis}}],
                @endforeach
            ]);

            var options = {
                title: 'unvisited point ',
                hAxis: {title: 'x-axis', minValue: 0, maxValue: 11},
                vAxis: {title: 'Y-axis', minValue: 0, maxValue: 14},
                legend: 'none'
            };

            var chart = new google.visualization.ScatterChart(document.getElementById('chart_div'));

            chart.draw(data, options);
        }



        ///


        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChartofvisited);

        function drawChartofvisited() {
            var data = google.visualization.arrayToDataTable([
                ['x-axis', 'visited'],
                    @foreach($visiteds as $visited)

                [ {{$visited->x_axis}},{{$visited->y_axis}}],
                @endforeach
            ]);

            var options = {
                title: 'Visited point ',
                hAxis: {title: 'x-axis', minValue: 0, maxValue: 11},
                vAxis: {title: 'Y-axis', minValue: 0, maxValue: 14},
                legend: 'none'
            };

            var chart = new google.visualization.ScatterChart(document.getElementById('chart_div2'));

            chart.draw(data, options);
        }











    </script>


@endsection