@extends('layouts.main')
@section('main_id') <v-app id="reviewsPage"> @endsection

@section('main_content')
<div>
    @php
        if(isset($token,$title,$users,$course_users,$url)){
            $modal_message='¡Opinión enviada correctamente!';
        }
        else if(isset($exist)){
            $modal_message='¡Vaya! Parece que ya tenemos tu opinión sobre este curso!';
        }else{
            $modal_message='Datos no encontrados con las especificaciones solicitadas.';
        }
    @endphp
    @isset($token,$title,$course_users,$url)
        <reviews-form :token='@json($token)' :url='@json($url)'
                      :title='@json($title)' :course_users='@json($course_users)' :modal-message='@json($modal_message)'
                      class="mt-mob-100 mt-tb-100 mt-dk-100 mb-mob-100 mb-tb-100 mb-dk-100"></reviews-form>
    @else
        <reviews-form :modal-message='@json($modal_message)'
            class="mt-mob-100 mt-tb-100 mt-dk-100 mb-mob-100 mb-tb-100 mb-dk-100"></reviews-form>
    @endisset
    <review-modal></review-modal>
</div>
@endsection

@push('scripts')
    <script async src="{{ mix('/dist/js/reviews.js') }}" defer></script>
@endpush
