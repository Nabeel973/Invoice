<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>



    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">

</head>

<body style="margin-top: 30px;">
<div class="container">
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif
    <h3 class="text-center">INVOICE</h3>
    <form action="{{route('invoice.submit')}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="supplier_name">Supplier Name</label>
                    <input name="supplier_name" type="text" class="form-control" placeholder="Enter Supplier Name" >
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="invoice_number">Invoice Number</label>
                    <input name="invoice_number" type="text" class="form-control" placeholder="Enter Invoice Number" >
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="delivery_date">Select Date</label>
                    <input name="delivery_date" type="text" class="form-control datetimepicker" id="datepicker" placeholder="Select Date" >
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input name="amount" type="text" class="form-control" placeholder="AED" >
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label for="submit_by">Submitted By</label>
                <input name="submit_by" type="text" class="form-control" placeholder="Submitted By" >
            </div>
            <div class="col-sm-6 mt-4">
                <div class="input-group" style="margin-top: 6px;">
                    <div class="input-group-prepend">
                        <label class="input-group-text">Items Delivered</label>
                    </div>
                    <select class="custom-select" name="items_delivered" >
                        <option selected>Select...</option>
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-sm-6">
                <label for="image">Image</label>
                <input type="file" name="image" class="form-control">
            </div>
        </div>
        <div class="row mt-4 justify-content-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>

    </form>
</div>

</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>

<script type="javascript">
    $(document).ready(function(){
    });

</script>
