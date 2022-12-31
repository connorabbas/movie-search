@section('title')
    Movie Search
@endsection

{{-- extend the main layout --}}
@extends('layouts.main')

{{-- Page title --}}
@section('title', 'Home')

{{-- Content starts --}}
@section('content')
    <div id="app" style="">
        <main-app></main-app>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
@endsection