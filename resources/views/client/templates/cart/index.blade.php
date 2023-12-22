@extends('client.layout.layout')
@section('content')
<h2>Giỏ hàng của bạn</h2>

@if(empty($cart))
    <p>Giỏ hàng trống.</p>
@else
<table class="table table-bordered table-striped">
    <thead>
       <tr>
        <th>Name</th>
        <th>Price</th>
        <th>Quantity</th>
       </tr>
    </thead>
    <tbody>
        @foreach($cart as $productId => $item)
        <tr>
            <td>{{$item['name']}}</td>
            <td>{{$item['price']}}</td>
            <td>{{$item['quantity']}}</td>
        </tr>
         @endforeach
    </tbody>
</table>     
<form action="{{ route('place-order') }}" method="post">
    @csrf
    <button type="submit">Đặt hàng</button>
</form>  
@endif

@endsection