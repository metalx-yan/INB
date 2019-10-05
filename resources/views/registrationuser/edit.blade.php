@extends('main')

@section('content')
<div class="container-fluid">
       
        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Dashboard</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Edit User</li>
                </ol>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                    <form action=" {{ route('user.update', $users->id) }} " method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Nama</label>
                                    <input type="name" value="{{ $users->name }}" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : ''}}" id="name" autocomplete="off">
                                    {!! $errors->first('name', '<span class="invalid-feedback">:message</span>') !!}
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Username</label>
                                    <input type="username" value="{{ $users->username }}" name="username" class="form-control {{ $errors->has('username') ? 'is-invalid' : ''}}" id="username" autocomplete="off">
                                    {!! $errors->first('username', '<span class="invalid-feedback">:message</span>') !!}
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Level Jabatan</label>
                                    <select value="{{ $users->job_level }}" class="form-control {{ $errors->has('job_level_id') ? 'is-invalid' : ''}}" name="job_level_id" id="exampleFormControlSelect1">
                                        <option></option>
                                        @foreach (App\Models\JobLevel::all() as $joblevel)
                                            <option value="{{ $joblevel->id }}" {{ old("job_level_id", $users->job_level->name) == $joblevel->name ? "selected" : "" }}> {{ $joblevel->name }}</option>
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
                                        @foreach (App\Models\Level::all() as $level)
                                            <option value="{{ $level->id }}" {{ old("level_id", $users->level->name) == $level->name ? "selected" : "" }}>{{ $level->name }} </option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('level_id', '<span class="invalid-feedback">:message</span>') !!}
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Wilayah</label>
                                    <select value="{{ old('region_id') }}" class="form-control {{ $errors->has('region_id') ? 'is-invalid' : ''}}" name="region_id" id="exampleFormControlSelect1">
                                        <option></option>
                                        @foreach (App\Models\Region::all() as $reg)
                                            <option value="{{ $reg->id }}" {{ old("region_id", $users->region->name) == $reg->name ? "selected" : "" }}>{{ $reg->name }} </option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('region_id', '<span class="invalid-feedback">:message</span>') !!}
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Unit Kelola</label>
                                    <select value="{{ old('management_unit_id') }}" class="form-control {{ $errors->has('management_unit_id') ? 'is-invalid' : ''}}" name="management_unit_id" id="exampleFormControlSelect1">
                                        <option></option>
                                        @foreach (App\Models\ManagementUnit::all() as $manage)
                                            <option value="{{ $manage->id }}" {{ old("management_unit_id", $users->management_unit->name) == $manage->name ? "selected" : "" }}>{{ $manage->name }} </option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('management_unit_id', '<span class="invalid-feedback">:message</span>') !!}
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Password</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                </div>  
                                <div class="form-group col-md-4">
                                    <label>Password Conf</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div> 
                            </div> --}}
                            <div class="row">
                                @foreach ($applications as $application)
                                      <div class="form-group col-md-4">
                                            <div id="menus">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <label>Application</label>
                                                                <div class="input-group-text" >
                                                                    <input {{ $users->hasApplication($application->slug) ? 'checked' : null }} data-permission="{{ $application->slug }}" name="permissions[]"  type="checkbox" value="{{ $application->id }}" data-id="{{ $application->id }}" class="parent"> {{ Str::title($application->name) . " Application" }}
                                                                </div>
                                                            </div>
                                                            @if ($application->hasPermissions())
                                                            @foreach ($application->permissions as $permission)
                                                            <div class="col-11 offset-1">
                                                                <div class="input-group-text">
                                                                    <input {{ $users->hasPermission($permission->slug) ? 'checked' : null }} data-permission="{{ $permission->slug }}" name="permissions[]"  class="child" data-bound="{{ $application->id }}" type="checkbox" value="{{ $permission->id }}"> {{ " {$permission->name}"}}
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
                                
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('user.index') }}" class="btn btn-danger">Back</a>
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
         $(document).ready(function() {
            $('.parent').click(function() {
                if ($(this).is(':checked')) {
                    $('.child[data-bound="' + $(this).attr('data-id') + '"]').attr('disabled', false);
                } else {
                    $('.child[data-bound="' + $(this).attr('data-id') + '"]').attr('disabled', true);
                    $('.child[data-bound="' + $(this).attr('data-id') + '"]').prop('checked', false);
                }
            });
        }); 
                
                // Jika parent di check
                // Enable Persmission
                // Jika False
                // Disabled dan Uncheck Permission
                
    </script>
@endsection
