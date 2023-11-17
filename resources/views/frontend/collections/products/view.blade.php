@extends('layouts.app')
@section('title')
    {{$products->meta_title}}
@endsection
@section('meta_keyword')
    {{$products->meta_keyword}}
@endsection
@section('meta_description')
    {{$products->meta_description}}
@endsection
@section('content')
    <div>
        <livewire:frontend.product.view :category="$category" :products="$products"/>
    </div>
@endsection
