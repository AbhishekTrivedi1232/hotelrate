<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- Bootstrap Date-Picker Plugin -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
    <title>Rates</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">

</head>
<body>
<h3 class="text-center">Manage Hotel Rates</h3>
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            Hotel Rate Form
        </div>
        <div class="panel-body">
            <form method="post" action="{{$route_name}}">
                {{csrf_field()}}
                <input type="hidden" name="rate_id" value="{{!empty($rate)?$rate->rate_id:""}}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="hotel">Select Hotel</label>
                            <select class="form-control" name="hotel_id" id="hotel_id">
                                @foreach($hotels as $hotel => $key)
                                    <option {{!empty($rate)?($rate->hotel_id==$hotel)?"selected":"":""}} value="{{$hotel}}">{{$key}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">{{ $errors->first('hotel_id') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('from_date') ? 'has-error' : '' }}">
                            <label class="control-label">From Date<span class="required"> *</span></label>
                            <input type="text" class="form-control datepicker" placeholder="Select From Date" autocomplete="off" name="from_date" id="from_date" value="{{!empty($rate)?date("d-m-Y",strtotime($rate['from_date'])):""}}">
                            <span class="text-danger">{{ $errors->first('from_date') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('to_date') ? 'has-error' : '' }}">
                            <label class="control-label">To Date<span class="required"> *</span></label>
                            <input type="text" class="form-control datepicker" placeholder="Select To Date" autocomplete="off" name="to_date" id="to_date" value="{{!empty($rate)?date("d-m-Y",strtotime($rate['to_date'])):""}}">
                            <span class="text-danger">{{ $errors->first('to_date') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('rate_for_adult') ? 'has-error' : '' }}">
                            <label class="control-label">Rate for Adult<span class="required"> *</span></label>
                            <input type="text" value="{{!empty($rate)?$rate->rate_for_adult:""}}" class="form-control" name="rate_for_adult" id="rate_for_adult">
                            <span class="text-danger">{{ $errors->first('rate_for_adult') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('rate_for_child') ? 'has-error' : '' }}">
                            <label class="control-label">Rate for Child<span class="required"> *</span></label>
                            <input type="text" value="{{!empty($rate)?$rate->rate_for_child:""}}" class="form-control" name="rate_for_child" id="rate_for_child">
                            <span class="text-danger">{{ $errors->first('rate_for_child') }}</span>
                        </div>
                    </div>
                </div>



                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
<div class="container">
<div class="panel panel-primary">
    <div class="panel-heading">Hotel Rate List</div>
    <div class="panel-body">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Hotel Name</th>
                    <th scope="col">From Date</th>
                    <th scope="col">To Date</th>
                    <th scope="col">Rate for Adult</th>
                    <th scope="col">Rate for Child</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($rates as $key => $rate)
                <tr>
                    <th scope="row">{{++$key}}</th>
                    <td>{{$rate->hotel_name}}</td>
                    <td>{{$rate->from_date}}</td>
                    <td>{{$rate->to_date}}</td>
                    <td>{{$rate->rate_for_adult}}</td>
                    <td>{{$rate->rate_for_child}}</td>
                    <td>
                        <a href="{{route("rates.edit",$rate->rate_id)}}" class="btn btn-info">Edit </a>
                        <a href="{{route("rates.delete",$rate->rate_id)}}" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
</body>

</html>
<script>
    $("#from_date").datepicker({
        startDate:"-0d",
        autoclose:true,
        format:"dd-mm-yyyy"
    });

    $("#from_date").on("change",function(){
        var from_date=$(this).val();
       $("#to_date").datepicker({
           startDate:from_date,
           autoclose:true,
           format:"dd-mm-yyyy"
       });
    });

@if(Session::has('message'))
   var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;

        case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;

        case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;

        case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
    }
    @endif
</script>
<script src="{{asset('Admin/toastr/toastr.min.js')}}"></script>