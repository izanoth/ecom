@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="container bg-light p-3">
                <h2>Products</h2>
                <table class="table">
                </table>
            </div>
        </div>
        <div class="col-md-4">
            <div class="container bg-light p-3">
                <a class="btn btn-primary" href="{{ route('admin.product.create') }}">Create New Product</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">

        </div>
        <div class="col-md-4">
            <div class="container bg-light p-3">
                @if (isset($message))
                    {{ $message }}
                @endif
            </div>
        </div>
    </div>
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Categoria</th>
                    <th>Marca</th>
                    <th>Title</th>
                    <th>Descrição</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>
                            <form method='post' action='{{ route('admin.product.destroy', $product->id) }}'>
                                @csrf
                                @method('DELETE')
                                <button class='btn btn-danger' type='submit'>Delete</button>
                            </form><br>
                        </td>
                        <td>
                            <a class='btn btn-info' href="{{ route('admin.product.edit', $product->id) }}">Edit</a>

                        </td>
                        <td>{{ $product->id }}</td>
                        <td>@if ($product->images!=null)
                            <img src="" height="30" width="auto">
                        @else

                        @endif
                        </td>
                        <td>{{ $product->category->title }}</td>
                        <td>{{ $product->brand->title }}</td>
                        <td>{{ $product->title }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->price }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
