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
    <title>Booking</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">

</head>
<body>
<h3 class="text-center">Book Hotel</h3>
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            Booking Form
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="hotel">Select Hotel</label>
                        <select class="form-control" name="hotel_id" id="hotel_id">
                            @foreach($hotels as $hotel => $key)
                                <option value="{{$hotel}}">{{$key}}</option>
                            @endforeach
                        </select>
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
                    <div class="form-group {{ $errors->has('no_of_adult') ? 'has-error' : '' }}">
                        <label class="control-label">No of Adult<span class="required"> *</span></label>
                        <input type="number" class="form-control" min="0" name="no_of_adult" id="no_of_adult">
                        <span class="text-danger">{{ $errors->first('no_of_adult') }}</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group {{ $errors->has('no_of_child') ? 'has-error' : '' }}">
                        <label class="control-label">No of Child<span class="required"> *</span></label>
                        <input type="number" class="form-control" min="0" name="no_of_child" id="no_of_child">
                        <span class="text-danger">{{ $errors->first('no_of_child') }}</span>
                    </div>
                </div>
            </div>
            <button type="button" id="submit" class="btn btn-primary">Book Now</button>
        </div>
    </div>
    <div class="panel panel-primary rate_calculation">
        <div class="panel-heading">
            Rate Calculation
        </div>
        <div class="panel-body">
            <span>No of Days : <span id="days"></span></span><br>
            <span>Per Adult : <span id="per_adult"></span></span><br>
            <span>Per Child : <span id="per_child"></span></span><br>
            <span>Total : <span id="total"></span></span>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
</body>

</html>
<script>
    $("#submit").on("click",function(){
        var hotel_id=$("#hotel_id").val();
        var from_date=$("#from_date").val();
        var to_date=$("#to_date").val();
        var no_of_adult=$("#no_of_adult").val();
        var no_of_child=$("#no_of_child").val();
        if(hotel_id=="")
        {
            alert("please select hotel");
        }
        else if(from_date=="")
        {
            alert("Please select From Date");
        }
        else if(to_date=="")
        {
            alert("Please select To Date");
        }
        else if(no_of_adult=="")
        {
            alert("Please Enter No of Adult");
        }
        else if(no_of_child=="")
        {
            alert("Please Enter No of Child");
        }
        else{
            $.ajax({
                type:'get',
                url:'{{route("booking.amount")}}',
                data:{"hotel_id":hotel_id,"from_date":from_date,"to_date":to_date,"no_of_adult":no_of_adult,"no_of_child":no_of_child},
                success:function(data) {
//                    console.log(this.url);
                    if(data.success==1)
                    {
                        $("#per_adult").text(data.per_adult);
                        $("#per_child").text(data.per_child);
                        $("#total").text(data.total);
                        $("#days").text(data.no_of_days);
                    }
                    else{
                        alert("Booking not available for these dates");
                    }
                }
            });
        }
    });
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