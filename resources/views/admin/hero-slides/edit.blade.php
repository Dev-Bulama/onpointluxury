@extends('layouts.admin')
@section('title','Edit Hero Slide') @section('page-title','Edit Slide: ' . Str::limit($slide->headline, 40))
@section('content')
<form method="POST" action="{{ route('admin.hero-slides.update', $slide) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    @include('admin.hero-slides._form')
</form>
@endsection
