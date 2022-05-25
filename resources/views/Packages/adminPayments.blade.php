@extends('layouts.app')

@section('content')

    <div class="hero" style=" background-image: url({{asset('/images1/insight.jpg')}}); background-position: 50% 30%;
    ">

        <div class="inner">
            <h1>Payment History</h1>
        </div>
    </div>
    <br><BR>
        <div class="container bg-white p-5" style="overflow-x: scroll;">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            @if(count($payment)>0)
                <table class="table1" id="myDataTable">
                    <thead class="">
                    <tr>
                        <th scope="col" >#</th>
                        <th scope="col">User</th>
                        <th scope="col">Payment Method</th>
                        <th scope="col">Package</th>
                        <th scope="col">Price<small>AUD</small></th>
                        <th scope="col">Status</th>

                        <th scope="col">Date</th>
                        <th scope="col">Receipt</th>

                    </tr>
                    </thead>
                    <tbody class="">
                    @foreach($payment as $pay)
                        <tr>
                            <td> {{ $pay->id }}</td>
                            <td> <a href="/users/{{ $pay->user_id }}">{{ \App\Models\User::findOrFail($pay->user_id)->name }}</a></td>
                            <td> {{ $pay->payment_method }} </td>
                            <td>  {{ $pay->package }} </td>
                            <td> $ {{ $pay->amount }} </td>
                            <td>  {{ $pay->status }} </td>
                            <td>  {{ $pay->created_at }} </td>
                            <td>@if($pay->status == "paid")
                                    <a class="btn btn-success" href="/invoice/{{$pay->id}}"><i class="fas fa-download"></i></a>
                                @else
                                    <a class="btn btn-warning"  ><i class="fas fa-download"></i></a>
                                @endif

                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>

            @else
                <h3>You didn't have any payments yet!</h3>
            @endif
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
                integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
                crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
                integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
                crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
                integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
                crossorigin="anonymous"></script>

        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.22/datatables.min.js"></script>
        <script type="text/JavaScript"
                src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
        <script>

            // var table = document.getElementById('myDataTable');
            var table = $('#myDataTable').DataTable({
                "columnDefs": [
                    {"orderable": false, "targets": 1},
                    {"orderable": false, "targets": 2},
                    {"orderable": false, "targets": 3}
                ]
            });



            table.on('click', '.delete', function () {
                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }
                var data = table.row($tr).data();
                $('#deleteId').val(data[0]);
            });

            function deleteProperty() {
                event.preventDefault();
                document.getElementById('delete-form-' + $('#deleteId').val()).submit();
            }

        </script>
@endsection
