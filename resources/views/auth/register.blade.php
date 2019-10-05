@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Level Jabatan') }}</label>

                            <div class="col-md-6">
                                {{-- <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus> --}}
                                <select class="form-control" name="job_level_id" id="exampleFormControlSelect1">
                                    @foreach (App\Models\JobLevel::all() as $levelJob)
                                    <option value="{{ $levelJob->id }}">{{ $levelJob->name }} </option>
                                    @endforeach
                                  </select>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Wilayah') }}</label>
    
                                <div class="col-md-6">
                                    {{-- <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus> --}}
                                    <select class="form-control" name="region_id" id="exampleFormControlSelect1">
                                        @foreach (App\Models\Region::all() as $reg)
                                    <option value="{{ $reg->id }}" >{{ $reg->name }} </option>
                                        @endforeach
                                      </select>
    
                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>

                        <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Level') }}</label>
    
                                <div class="col-md-6">
                                    {{-- <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus> --}}
                                    <select class="form-control" name="level_id" id="exampleFormControlSelect1">
                                        @foreach (App\Models\Level::all() as $level)
                                        <option value="{{ $level->id }}" >{{ $level->name }} </option>
                                        @endforeach
                                    </select>
    
                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>

                        <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Management Unit') }}</label>
    
                                <div class="col-md-6">
                                    {{-- <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus> --}}
                                    <select class="form-control" name="management_unit_id" id="exampleFormControlSelect1">
                                        @foreach (App\Models\ManagementUnit::all() as $manage)
                                    <option value="{{ $manage->id }}" >{{ $manage->name }} </option>
                                        @endforeach
                                      </select>
    
                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>

                        <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Aplikasi') }}</label>
    
                                <div class="col-md-6">
                                    <select class="form-control dynamic" name="permissions[]" id="exampleFormControlSelect1">
                                        <option>Select </option>
                                        @foreach (App\Models\Permission::all() as $manage)
                                            @if ($manage->permission_id == null)
                                                <option value="{{ $manage->id }}" >{{ $manage->name }} </option>
                                            @endif
                                        @endforeach
                                      </select>
    
                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>

                        <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Menu') }}</label>
    
                                <div class="col-md-6">
                                        @foreach (App\Models\Permission::all() as $manage)
                                        @if ($manage->permission_id != null)
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                  <div class="input-group-text">
                                                  <input type="checkbox" name="permissions[]" value="{{ $manage->id }}" aria-label="Checkbox for following text input">
                                                  </div>
                                                </div>
                                            <input type="text" disabled class="form-control" value="{{ $manage->name }}" aria-label="Text input with checkbox">
                                            </div>
                                        @endif
                                        @endforeach
    
                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>

                     

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.dynamic').change(function(){

        });
    });
</script>
@endsection
