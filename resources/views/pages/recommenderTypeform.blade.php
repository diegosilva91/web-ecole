@extends('layouts.main')
@section('main_id') <v-app id="type-form"> @endsection

@section('main_content')
    <div id="typeform-widget" class="typeform-widget"    data-cc-on-file="false" data-form-id="{{$form_id ?? ''}}"
         data-user-id="{{Auth::id()}}" style="width: 100%; height: 100%;"></div>
@endsection

@push('scripts')
    <script async src="{{ mix('/dist/js/recommender-typeform.js') }}" defer></script>
    <script src="https://embed.typeform.com/embed.js" type="text/javascript"></script>
@endpush

