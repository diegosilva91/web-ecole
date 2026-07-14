@extends('layouts.main')
@section('main_id') @parent @endsection

@section('og_tags')
    @parent
    <meta name="robots" content="noindex">
@endsection

@section('main_content')
    <div class="container h-100 mx-auto row justify-content-center">
        <div class="my-auto">
            <div class="card col-12 mt-50 mt-dk-100 mt-tb-50 mb-50" style="max-width: 460px;">
                <div class="p-4 title-modal">{{ __('Restablecer la contraseña') }}</div>
                <hr class="col-10 mx-auto pt-0 pb-0 mt-0">
                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="row">
                            <label for="email" class="pb-0 pl-4 h7-txt">{{ __('E-Mail') }}</label>

                            <div class="col-12 pl-4 pt-0 pr-4">
                                <input id="email" type="email" class="input-box @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <label for="password" class="pb-0 pl-4 h7-txt">{{ __('Contraseña') }}</label>

                            <div class="col-12 pl-4 pt-0 pr-4">
                                <input id="password" type="password" class="input-box @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <label for="password-confirm" class="pb-0 pl-4 h7-txt">{{ __('Confirmar contraseña') }}</label>

                            <div class="col-12 pl-4 pt-0 pr-4">
                                <input id="password-confirm" type="password" class="input-box" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 pl-4 pr-4">
                                <button type="submit" class="btn-modals h7-txt-sbold">
                                    {{ __('Restablecer Contraseña') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script async src="{{ mix('/dist/js/app.js') }}"></script>
@endpush
