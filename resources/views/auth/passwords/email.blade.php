@extends('layouts.main')
@section('main_id') @parent @endsection

@section('og_tags')
    @parent
    <meta name="robots" content="noindex">
@endsection

@section('main_content')
<div class="bg-reset-pass h-100">
    <div class="container h-100 mx-auto row justify-content-center">
        <div class="my-auto">
            <div class="card reset-mail col-12 mt-50 mt-dk-100 mt-tb-50 mb-50" style="max-width: 460px;">
                <div class="p-4 title-modal">{{ __('Restablecer la contraseña') }}</div>
                <hr class="col-10 mx-auto pt-0 pb-0 mt-0">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="row">
                            <label for="email" class="pb-0 pl-4 h7-txt">{{ __('E-Mail') }}</label>

                            <div class="col-12 pl-4 pt-0 pr-4">
                                <input id="email" type="email" class="input-box @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 pl-4 pr-4">
                                <button type="submit" class="btn-modals h7-txt-sbold">
                                    {{ __('Solicito cambio de contraseña') }}
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

@push('styles')
    <style>
        .reset-mail{
            border-radius: 10px !important;
            box-shadow: 0 5px 10px 0 rgba(74, 64, 87, 0.2) !important;
        }

        .bg-reset-pass{
            background-color: #eef0f3;
        }
    </style>
@endpush

@push('scripts')
    <script async src="{{ mix('/dist/js/app.js') }}"></script>
@endpush
