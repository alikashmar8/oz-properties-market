@extends('layouts.app')

@section('content')
    <div class="hero" style="height: 100px; background-image: linear-gradient(#df0505, #f5f5f5);
    ">

    </div>
    <BR>
        <h1 style=" text-align: center">Clients</h1>

        <BR><BR>

                @if(\Illuminate\Support\Facades\Auth::user()->role == 0)
                    {{--        admin area--}}
                    <div class="container bg-white">
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif

                        @if(count($users)>0)
                            <table class="table1" id="myDataTable">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Phone Number</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Confirmed</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Delete</th>

                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            @foreach($users as $user)
{{--                        {{ $pn = $user->phoneNumber }}--}}
{{--                        {{$phoneNumber = explode(' ', "hi by")}}--}}
{{--                        {{$phoneNumber = split(' ', "hi by")}}--}}
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td><a href="/users/{{ $user->id }}">{{ $user->name }}</a></td>
                            <td>  {{ $user->phoneNumber }}</td>
                            <td>{{ $user->email }} </td>
                            @if($user->email_verified_at == NULL)
                                <td class="text-danger">No</td>
                            @else
                                <td class="text-success">Yes</td>
                            @endif
                            <td>{{ $user->created_at }}</td>

                            <td><button class="btn btn-danger no-sort delete" data-toggle="modal"  data-target="#deleteModal">Delete</button>

                            {{--                        form to trigger delete user--}}
                            {{ Form::open(['action' => ['\App\Http\Controllers\UsersController@destroy',$user->id],'method'=>'DELETE' , 'class'=>'hidden','id'=>'delete-form-'.$user->id]) }} {{ Form::close() }}


                        </tr>
                    @endforeach
                    </tbody>
                </table>

            @else
                <h2>No Users yet</h2>
            @endif
        </div>

        {{--    Delete Modal--}}
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to delete ?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h6>All properties and information added by this user will be delete also</h6>
                    </div>
                    <input type="hidden" name="deleteId" id="deleteId">
                    {{--                {{ Form::open(['action' => ['App\Http\Controllers\PropertiesController@acceptProperty',$user->id],'method'=>'put' ]) }}--}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-danger" value="Delete" onclick="deleteProperty()">
                    </div>
                    {{--                {{ Form::close() }}--}}

                </div>
            </div>
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
            var table = $('#myDataTable').DataTable({
                "columnDefs": [
                    {"orderable": false, "targets": 6}
                ]
            });

            table.on('click','.delete', function () {
                $tr = $(this).closest('tr');
                if($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }
                var data = table.row($tr).data();
                $('#deleteId').val(data[0]);
            });

            function deleteProperty() {
                event.preventDefault();
                console.log($('#deleteId').val())
                document.getElementById('delete-form-'+$('#deleteId').val()).submit();
            }
        </script>
    @else
        {{--                ristricted area--}}
        <script type="text/javascript">
            window.location = "/";//here double curly bracket
        </script>
    @endif
@endsection
