@extends('layouts.main')
@section('main_id') @parent @endsection

@section('og_tags')
    @parent
    <meta name="robots" content="noindex">
@endsection

@section('main_content')

    <div class="container h-100 mx-auto row justify-content-center">
        <div class="my-auto">
            <div class="card col-12 mt-50 mt-dk-100 mt-tb-50 mb-50">
                <div class="p-4 title-modal">{{ __('Verifique su correo electrónico') }}</div>
                <hr class="col-10 mx-auto pt-0 pb-0 mt-0">
                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Se ha enviado un nuevo enlace de verificación a su correo electrónico.') }}
                        </div>
                    @endif

                    {{ __('Antes de continuar, revise su correo electrónico para obtener un enlace de verificación.') }}
                    {{ __('Si no recibiste el correo electrónico') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn-modals h7-txt-sbold p-0 m-0 align-baseline">{{ __('Clic aquí para solicitar otro') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script async src="{{ mix('/dist/js/app.js') }}"></script>
@endpush
