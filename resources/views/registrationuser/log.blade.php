@extends('main')

@section('content')
<div class="container-fluid">
       
        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Dashboard</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Log Activities</li>
                    <li class="breadcrumb-item active">List</li>
                </ol>
            </div>
        </div>
        <div class="card">
            <div class="card-title">
               
            </div>
            <div class="card-body">
                <table class="table border" id="myTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Subject</th>
                            <th>URL</th>
                            <th>Method</th>
                            <th>Ip</th>
                            <th width="300px">User Agent</th>
                            <th>Name User</th>
                            <th>Date</th>
                            {{-- <th>Action</th> --}}
                        </tr>
                        </thead>

                    <tbody>
                        @if($logs->count())
                            @foreach($logs as $key => $log)
                            @if (Auth::user()->level->name == 'admin')
                            {{-- @foreach ($log->user as $user) --}}
                                
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $log->subject }}</td>
                                <td class="text-success">{{ $log->url }}</td>
                                <td><label class="label label-info">{{ $log->method }}</label></td>
                                <td class="text-warning">{{ $log->ip }}</td>
                                <td class="text-danger">{{ $log->agent }}</td>
                                @if ($log->user == null)
                                    <td>{{ "Null" }}</td>
                                @else
                                    <td>{{ $log->user->name }}</td>
                                @endif
                                <td>{{ $log->created_at }}</td>
                                {{-- <td><button class="btn btn-danger btn-sm">Delete</button></td> --}}
                            </tr>
                            {{-- @endforeach --}}
                            @elseif(Auth::user()->id == $log->user_id)
                            <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $log->subject }}</td>
                                    <td class="text-success">{{ $log->url }}</td>
                                    <td><label class="label label-info">{{ $log->method }}</label></td>
                                    <td class="text-warning">{{ $log->ip }}</td>
                                    <td class="text-danger">{{ $log->agent }}</td>
                                    @if ($log->user == null)
                                        <td>{{ "Null" }}</td>
                                    @else
                                        <td>{{ $log->user->name }}</td>
                                    @endif
                                    <td>{{ $log->created_at }}</td>
                                </tr>
                            @endif
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
@endsection

@section('scripts')

    <script src="{{ asset('js/js/jquery.dataTables.min.js') }}"></script>

    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>
@endsection