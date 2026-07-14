@extends('errors::minimal')
@section('custom-message')
    <p>Nuestro sistema ha detectado inactividad en la página</p>
@endsection
@section('title', __('Page Expired'))
@section('code', '419')
@section('message', __('Page Expired'))
