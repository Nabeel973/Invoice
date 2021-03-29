<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <linK href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body style="margin-top: 30px;">
<div class="container">

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <h1 class="mb-5">
                    Report
                </h1>
                <div class="card">
                    <div class="card-content" aria-expanded="true">
                        <div class="card-body">

                            <table class="table table-bordered datatable" id="datatable" style="z-index: 3;">
                                <thead>
                                <tr role="row" class="bg-primary white">
                                    <th class="border-primary border-darken-1">S. No.</th>
                                    <th class="border-primary border-darken-1">Supplier Name</th>
                                    <th class="border-primary border-darken-1">Invoice Number</th>
                                    <th class="border-primary border-darken-1">Delivery Date</th>
                                    <th class="border-primary border-darken-1">Amount</th>
                                    <th class="border-primary border-darken-1">Items Delivered</th>
                                    <th class="border-primary border-darken-1">Submitted By</th>
                                    <th class="border-primary border-darken-1">Image</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="modal fade" id="picture_modal" role="dialog" aria-labelledby="picture_modal" aria-hidden="true" data-backdrop="false" >
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="picture_modal_title">Picture</h4>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

</div>
<script src="https://code.jquery.com/jquery-3.1.1.min.js">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function(){

        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('invoice.list') !!}',
            rowId: 'id',
            columns: [
                { data: 'id', name: 'id',class:'id' },
                { data: 'supplier_name', name: 'supplier_name',class:'supplier_name' },
                { data: 'invoice_no', name: 'invoice_no', class:'invoice_no'},
                { data: 'delivery_date', name: 'delivery_date', class:'delivery_date' },
                { data: 'amount', name: 'amount', class:'amount' },
                { data: 'items_delivered', name: 'items_delivered', class:'items_delivered' },
                { data: 'submitted_by', name: 'submitted_by', class:'submitted_by' },
                { data: 'action', name: 'action', class:'action text-center'},
            ]
        });

        $(document.body).on('click', '.action', function() {
            var orderid = $(this).closest('tr')[0].id;
            var currentRow = $(this).closest('tr')[0];

            var counter = 0;
            $(currentRow).each(function () {
                var tds = $(this).html();
                $(tds).each(function () {
                    counter++;
                    if (counter == 1) {
                        $.ajax({
                            url: '{!! route('invoice.image') !!}',
                            method: 'POST',
                            data: {
                                '_token': '{{ csrf_token() }}',
                                'id': $(this).text(),
                            }
                        }).done(function(data){
                           if(data){
                               var image = '<img src="' + data + '" style="width: 100%; max-width: 200px;" />';

                               $('#picture_modal .modal-body').html(image);

                               $('#picture_modal').modal('show');
                           }
                        });
                    }
                });
            });
        });

    });
</script>
</body>
</html>


{{--<script src="//code.jquery.com/jquery.js"></script>--}}
{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>--}}
<!-- DataTables -->

{{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />--}}
<!-- Bootstrap JavaScript -->


