@extends('main')

@section('content')
<div class="container-fluid">
       
        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Dashboard</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Registration User</li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action=" {{ route('user.store') }} " method="post">
                    @csrf
                    <h4 class="card-title">Register User</h4>
                    <hr>
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
                        <div class="form-group col-md-4">
                            <label>Password</label>
                            <input value="{{ old('password') }}" id="password" type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : ''}}" name="password" autocomplete="new-password">
                            {!! $errors->first('password', '<span class="invalid-feedback">:message</span>') !!}
                        </div>
                        <div class="form-group col-md-4">
                            <label>Konfirmasi Password</label>
                            <input value="{{ old('password') }}" id="password-confirm" type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : ''}}" name="password_confirmation" autocomplete="new-password">
                            {!! $errors->first('password', '<span class="invalid-feedback">:message</span>') !!}
                        </div>
                        <div class="form-group col-md-4">
                            <label>Aplikasi</label>
                            <select class="form-control dynamic" name="permissions[]" id="exampleFormControlSelect1">
                            <option></option>
                            @foreach ($permission as $parent)
                                @if ($parent->permission_id == null)
                                    <option value="{{ $parent->id }}" >{{ $parent->name }} </option>
                                @endif
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($permission as $permission)
                        @if ($permission->permission_id != null)
                            <div class="form-group col-md-4">
                                <label>Menu</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" aria-label="Checkbox for following text input">
                                            </div>
                                        </div>
                                        <input type="text" disabled class="form-control" value="{{ $permission->name }}" aria-label="Text input with checkbox">
                                    </div>
                                </div>
                                @endif
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
        <footer class="footer">
            © 2017 Monster Admin by wrappixel.com
        </footer>

        
@endsection

@section('scripts')
<script>
        $(document).ready(function(){
            $(document).on('change', '.dynamic', function(){
                console.log("hey you");

                var id = $(this).val();
                console.log(id);
                // $.ajax({
                //     type: 'get',
                //     url : '{{ url('admin/registrationuser/create') }}',
                //     data : {'id': permission_id},
                //     success: function(data){
                //         console.log('success');
                //         console.log(data);
                //     }
                // });
            });
        });
    </script>
@endsection