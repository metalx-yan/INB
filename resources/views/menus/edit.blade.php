@extends('main')

@section('content')
<div class="container-fluid">
       
        <div class="row page-titles">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="text-themecolor m-b-0 m-t-0">Dashboard</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Edit Menu Application</li>
                </ol>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                    <form action=" {{ route('menus.update', $menus->id) }} " method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Application</label>
                                    <select name="permission_id" id="" class="form-control">
                                            <option value=""></option>
                                        @foreach ($application as $app)
                                            <option value="{{ $app->id }}" {{ old("permission_id", $menus->permission->name) == $app->name ? "selected" : "" }} >{{ $app->name }}</option>
                                        @endforeach
                                    </select>
                                    {{-- <input type="name" value="{{ $menus->permission->name }}" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : ''}}" id="name" autocomplete="off"> --}}
                                    {!! $errors->first('name', '<span class="invalid-feedback">:message</span>') !!}
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Nama</label>
                                    <input type="name" value="{{ $menus->name }}" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : ''}}" id="name" autocomplete="off">
                                    {!! $errors->first('name', '<span class="invalid-feedback">:message</span>') !!}
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('menus.index') }}" class="btn btn-danger">Back</a>
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