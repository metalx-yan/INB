@extends('main')

@section('content')
<div class="container-fluid">
       
        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Dashboard</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Level</li>
                    <li class="breadcrumb-item active">List</li>
                </ol>
            </div>
        </div>  
        <div class="card">
            <div class="card-title">
                <br>
                <button type="button" class="btn btn-primary" style="margin-left: 20px;" data-toggle="modal" data-target="#exampleModal">
                    Create Level
                </button>

                <div class="modal fade" id="exampleModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create Level</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" >
                            <form action=" {{ route('level.store') }} " method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Nama</label>
                                            <input type="name" value="{{ old('name') }}" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : ''}}" id="name" autocomplete="off">
                                            {!! $errors->first('name', '<span class="invalid-feedback">:message</span>') !!}
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <button type="submit" class="btn btn-primary">Create</button>
                                        </div>
                                    </div>
                                </form>
                        </div>
                       
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table border" id="myTable">
                    <thead>
                        <th>id</th>
                        <th>Nama</th>
                        <th>Action</th>
                    </thead>

                    <tbody>
                        @foreach ($level as $level)
                            <tr>
                                <td> {{ $level->id }} </td>
                                <td> {{ $level->name }} </td>
                                <td>
                                    <div class="row">
                                        <div class="col-xs-1">
                                       
                                        <a href=" {{ route('level.edit', $level->id) }} " class="btn btn-warning btn-sm">Update
                                            <i class="ion ion-edit"></i>
                                        </a>

                                        </div>
                                        <div class="col-xs-2"></div>
                        
                                        <div class="col-xs-1">
                                            <form class="" action=" {{ route('level.destroy', $level->id) }} " method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="ion ion-android-delete btn btn-danger btn-sm" name="delete" onclick="return confirm('Are you sure?')" type="submit">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- {{ $user->links() }} --}}
            </div>
        </div>
        
    </div>
        <footer class="footer">
            © 2017 Monster Admin by wrappixel.com
        </footer>

        

@endsection

@section('scripts')
    <script src="{{ asset('js/js/jquery.dataTables.min.js') }}"></script>

    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>

    {{-- <script>
        $("#signin_button").on("click", function(e) {
            e.preventDefault();
        });
    </script> --}}
@endsection