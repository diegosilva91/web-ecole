@extends('layouts.main')
@section('main_id') <v-app id="portalmi-empresa"> @endsection

@section('main_content')
<div>
    <router-view :auth='@json(Auth::check())'></router-view>
</div>
@endsection

@push('scripts')
    <script async src="{{ mix('/dist/js/portalmi-empresa.js') }}" defer></script>
@endpush
