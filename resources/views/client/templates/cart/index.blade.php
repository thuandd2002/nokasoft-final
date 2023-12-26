@extends('client.layout.layout')
@section('content')
    <div class="cart-custom">
        <h2>Your Cart</h2>
        @if (empty($cart))
            <p>Cart empty</p>
        @else
            <table class="cart-list">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalPrice = 0; // Khởi tạo biến tổng giá trị
                    @endphp
                    @foreach ($cart as $productId => $item)
                        <tr>
                            <td><a href="{{ route('detail.product', ['id' => $item['id']]) }}">{{ $item['name'] }}</a></td>
                            <td><img src="{{ asset('storage/' . $item['image']) }}" alt="avt"></td>
                            <td>{{ $item['price'] * $item['quantity'] }}</td>

                            <td>
                                <button  style="background-color: green;width: 15px; height: 15px"><a href="{{ route('increase.quantity', ['id' => $item['id']]) }}">+</a></button>
                                {{ $item['quantity'] }}
                                <button  style="background-color: rgb(255, 0, 13);width: 15px; height: 15px"><a href="{{ route('decrease.quantity', ['id' => $item['id']]) }}">-</a></button>
                            </td>

                        </tr>
                        @php
                            $totalPrice += $item['price'] * $item['quantity']; // Cập nhật tổng giá trị
                        @endphp
                    @endforeach
                    <tr>
                        <td>Total Price: {{ $totalPrice }}$ </td>
                    </tr>
                </tbody>
            </table>
            <form action="{{ route('place-order') }}" method="post">
                @csrf
                <div class="thuan2">
                    <button class="btn-lg"
                        style="width: 100px; height:50px; margin-top: 20px;background-color: rgb(159, 235, 159)"
                        type="submit">Place Order</button>
                </div>

            </form>
        @endif
    </div>
@endsection
