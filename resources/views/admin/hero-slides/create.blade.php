@extends('layouts.admin')
@section('title','Add Hero Slide') @section('page-title','Add Hero Slide')
@section('content')
<form method="POST" action="{{ route('admin.hero-slides.store') }}" enctype="multipart/form-data">
    @csrf
    @include('admin.hero-slides._form')
</form>
@endsection
