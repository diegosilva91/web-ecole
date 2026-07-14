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
                <div class="p-4 title-modal">{{ __('Confirmar contraseña') }}</div>
                <hr class="col-10 mx-auto pt-0 pb-0 mt-0">
                <div class="card-body">
                    {{ __('Por favor confirme su contraseña antes de continuar.') }}

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="row">
                            <label for="password" class="pb-0 pl-4 h7-txt">{{ __('Contraseña') }}</label>

                            <div class="col-12 pl-4 pt-0 pr-4">
                                <input id="password" type="password" class="input-box @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 pl-4 pr-4">
                                <button type="submit" class="btn-modals h7-txt-sbold">
                                    {{ __('Confirmar contraseña') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="info-text purple-info" href="{{ route('password.request') }}">
                                        {{ __('¿Olvidaste tu contraseña?') }}
                                    </a>
                                @endif
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
