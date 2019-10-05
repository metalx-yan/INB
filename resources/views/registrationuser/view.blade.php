@extends('main')

@section('content')
<div class="container-fluid">
       
        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Dashboard</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">View</li>
                    <li class="breadcrumb-item active">User</li>
                </ol>
            </div>
        </div>
        <div class="card">
            <div class="card-title">
                <br>
                <div class="container">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="">Name</label>
                        <input type="text" class="form-control" disabled value="{{ $view->name }}">
                        </div>
                        <div class="col-md-2">
                            <label for="">Username</label>
                            <input type="text" class="form-control" disabled value="{{ $view->name }}">
                        </div>
                        <div class="col-md-2">
                            <label for="">Region</label>
                        <input type="text" class="form-control" disabled value="{{ $view->region->name }}">
                        </div>
                        <div class="col-md-2">
                            <label for="">Level</label>
                            <input type="text" class="form-control" disabled value=" {{ $view->level->name }} ">
                        </div>
                        <div class="col-md-2">
                            <label for="">Job Level</label>
                            <input type="text" class="form-control" disabled value=" {{ $view->job_level->name }} ">
                        </div>
                        <div class="col-md-2">
                            <label for="">Management Unit</label>
                            <input type="text" class="form-control" disabled value=" {{ $view->management_unit->name }} ">
                        </div>
                        {{-- <input type="text" class="form-control" disabled value=" {{ Auth::user()->management_unit->name }} "> --}}
                    </div>
                    <br>
                    {{-- <a href="" class="btn btn-primary">Edit Password</a> --}}
                    <div class="container">

                        <div class="row">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                Edit Password
                            </button>
                            <div class="col-md-9"></div>
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#photoModal" style="margin-left: 45px;">
                                Upload Photo
                            </button>
                        </div>

                    </div>
                          
                          <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Password</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            
                            <div class="modal-body">
                                {{-- {{ $view }} --}}
                                <div class="row">
                                    
                                    <form action=" {{ route('updatedata', $view->id) }} " method="post">
                                            @csrf
                                            @method('PUT')
                                            <div class="container">

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>New Password</label>
                                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                                        @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <label>Password Confirmation</label>
                                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                                        
                                                    </div>
                                                </div>

                                                <br>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                            </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="photoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Upload Photo</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                
                                <div class="modal-body">
                                    <div class="row">
                                        <form action=" {{ route('uploadphoto', $view->id) }} " method="post" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input type="file" name="avatar" required>
                                                        </div>
                                                    </div>
    
                                                    <br>
                                                    <button type="submit" class="btn btn-primary">Upload</button>
                                                </div>
                                            </form>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                </div>
                                </div>
                            </div>
                        </div>
                </div>

                
            </div>
            
        </div>
        
    </div>
        <footer class="footer">
            © 2017 Monster Admin by wrappixel.com
        </footer>

        


@endsection