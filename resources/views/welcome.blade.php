{{-- extend the main layout --}}
@extends('layouts.main')

{{-- Page title --}}
@section('title', 'Home')

{{-- Content starts --}}
@section('content')
<div id="app" style="">
    <main-app></main-app>
</div>
{{-- <div class="container">
    <div id="app" class="my-5">
        <main-app></main-app>
    </div>
</div> --}}
<script src="{{ mix('js/app.js') }}"></script>
@endsection