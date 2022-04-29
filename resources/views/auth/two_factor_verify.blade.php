@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Two factor authentication') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A new code has been sent to your phone.') }}
                        </div>
                    @endif

                    {{ __('Please enter the code that was sent to your phone '.$phone) }}
                    <form method="POST" action="{{ url('two-factor/verify') }}">
                        @csrf
                        <input type="hidden" name="guard" value="{{$guard}}"/>
                        <input type="hidden" name="attempt_sid" value="{{$attempt_sid}}"/>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Code') }}</label>
                            <div class="col-md-6">
                                <input id="code" name="code" type="text" class="form-control" required>

                                <span id="code-error" class="invalid-feedback" role="alert" style="display: none">
                                </span>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
