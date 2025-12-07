@extends('layouts.app')

@section('content')
<div id="app" class="min-h-screen bg-gray-50">
    <product-detail :product-id="{{ $productId }}"></product-detail>
</div>
@endsection
