@extends('main')

@section('content')
<div class="container-fluid">
       
        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Dashboard</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">User</li>
                    <li class="breadcrumb-item active">List</li>
                </ol>
            </div>
        </div>
        <div class="card">
            <div class="card-title">
                <br>
                <button type="button" class="btn btn-primary" style="margin-left: 20px;" data-toggle="modal" data-target="#exampleModal">
                    Register User
                </button>

                <div class="modal fade" id="exampleModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" >
                            <form action=" {{ route('user.store') }} " method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Nama</label>
                                            <input type="name" value="{{ old('name') }}" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : ''}}" id="name" autocomplete="off">
                                            {!! $errors->first('name', '<span class="invalid-feedback">:message</span>') !!}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Username</label>
                                            <input type="username" value="{{ old('username') }}" name="username" class="form-control {{ $errors->has('username') ? 'is-invalid' : ''}}" id="username" autocomplete="off">
                                            {!! $errors->first('username', '<span class="invalid-feedback">:message</span>') !!}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Level Jabatan</label>
                                            <select value="{{ old('job_level_id') }}" class="form-control {{ $errors->has('job_level_id') ? 'is-invalid' : ''}}" name="job_level_id" id="exampleFormControlSelect1">
                                                <option></option>
                                                @foreach ($joblevel as $joblevel)
                                                    <option value="{{ $joblevel->id }}">{{ $joblevel->name }} </option>
                                                @endforeach
                                            </select>
                                            {!! $errors->first('job_level_id', '<span class="invalid-feedback">:message</span>') !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Hak Akses</label>
                                            <select value="{{ old('level_id') }}" class="form-control {{ $errors->has('level_id') ? 'is-invalid' : ''}}" name="level_id" id="exampleFormControlSelect1">
                                                <option></option>
                                                @foreach ($level as $level)
                                                    <option value="{{ $level->id }}">{{ $level->name }} </option>
                                                @endforeach
                                            </select>
                                            {!! $errors->first('level_id', '<span class="invalid-feedback">:message</span>') !!}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Wilayah</label>
                                            <select value="{{ old('region_id') }}" class="form-control {{ $errors->has('region_id') ? 'is-invalid' : ''}}" name="region_id" id="exampleFormControlSelect1">
                                                <option></option>
                                                @foreach ($region as $reg)
                                                    <option value="{{ $reg->id }}" >{{ $reg->name }} </option>
                                                @endforeach
                                            </select>
                                            {!! $errors->first('region_id', '<span class="invalid-feedback">:message</span>') !!}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Unit Kelola</label>
                                            <select value="{{ old('management_unit_id') }}" class="form-control {{ $errors->has('management_unit_id') ? 'is-invalid' : ''}}" name="management_unit_id" id="exampleFormControlSelect1">
                                                <option></option>
                                                @foreach ($managementunit as $manage)
                                                    <option value="{{ $manage->id }}" >{{ $manage->name }} </option>
                                                @endforeach
                                            </select>
                                            {!! $errors->first('management_unit_id', '<span class="invalid-feedback">:message</span>') !!}
                                        </div>
                                    </div>
                                    <div class="row">

                                    @foreach ($parent as $key)
                                    {{-- {{ $parent }} --}}
                                      <div class="form-group col-md-4">
                                            <div id="menus">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <label>Application</label>
                                                                <div class="input-group-text" >
                                                                    <input name="permissions[]" type="checkbox" value="{{ $key->id }}" data-id="{{ $key->id }}" class="parent"> {{ Str::title($key->name) . " Application" }}
                                                                </div>
                                                            </div>
                                                            @if ($key->hasPermissions())
                                                            @foreach ($key->permissions as $permission)
                                                                <div class="col-11 offset-1">
                                                                    <div class="input-group-text">
                                                                    <input name="permissions[]" disabled="true" class="child" data-bound="{{ $key->id }}" type="checkbox" value="{{ $permission->id }}"> {{ " {$permission->name}"}}
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
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
                <table class="table border" id="myTable" style="font-size: 14px;">
                    <thead>
                        <th>id</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Level Jabatan</th>
                        <th>Hak Akses</th>
                        <th>Wilayah</th>
                        <th>Last Sign In</th>
                        <th>Aplikasi</th>
                        <th>Status</th>
                        <th>Action</th>
                    </thead>

                    <tbody>
                        @foreach ($user as $users)
                            <tr>
                                <td> {{ $users->id }} </td>
                                <td> {{ $users->name }} </td>
                                <td> {{ $users->username }} </td>
                                <td> {{ $users->job_level->name }} </td>
                                <td> {{ $users->level->name }} </td>
                                <td> {{ $users->region->name }} </td>
                                @if ($users->last_sign_in_at == null)
                                    <td> {{ " Belum Login " }} </td>
                                @else
                                    <td> {{ $users->last_sign_in_at->format('m-d-Y') }} </td>
                                @endif
                                <td>
                                    @foreach ($users->permissions as $permission)
                                        @if ($permission->permission_id == null)
                                            {{ $permission->name }},    
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @if ($users->isOnline())
                                        <li class="text-success">
                                            Online 
                                        </li>
                                    @else
                                        <li class="text-muted">
                                            Offline
                                        </li>
                                    @endif
                                </td>
                                {{-- <td> 
                                @foreach ($users->permissions as $permission)
                                    @if ($permission->permission_id != null)
                                        {{ $permission->name }},
                                    @endif
                                @endforeach
                                </td> --}}
                                <td>
                                    <div class="row">
                                        <div class="col-xs-1">
                                       
                                        <a href=" {{ route('user.edit', $users->id) }} " class="btn btn-warning btn-sm">Update
                                            <i class="ion ion-edit"></i>
                                        </a>

                                        </div>
                                        <div class="col-xs-1">
                                            <form action=" {{ route('resetdata', $users->id ) }} " method="post">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-primary btn-sm" >
                                                        Reset Password
                                                </button>
                                            </form>
                                        </div>
                        
                                        <div class="col-xs-1">
                                            <form class="" action=" {{ route('user.destroy', $users->id) }} " method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="ion ion-android-delete btn btn-danger btn-sm" onclick="return confirm('Are you sure?')" name="delete" type="submit">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
        <footer class="footer">
            © 2017 Monster Admin by wrappixel.com
        </footer>

        

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.parent').click(function() {
                if ($(this).is(':checked')) {
                    $('.child[data-bound="' + $(this).attr('data-id') + '"]').attr('disabled', false);
                } else {
                    $('.child[data-bound="' + $(this).attr('data-id') + '"]').attr('disabled', true);
                    $('.child[data-bound="' + $(this).attr('data-id') + '"]').prop('checked', false);
                }
                
                // Jika parent di check
                // Enable Persmission
                // Jika False
                // Disabled dan Uncheck Permission
                
            });
        });
    </script>

    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>

@endsection