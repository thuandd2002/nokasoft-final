@extends('client.layout.layout')
@section('content')
    <div id="grid">
        <div id="success-message" style="display: none; color: green;">
            @if(session('success'))
                <p>{{ session('success') }}</p>
            @endif
        </div>
        @foreach ($itemsProdcuts as $product)
            <div class="product">
                <div class="make3D">
                    <div class="product-front">
                        <div class="shadow"></div>
                        <img src="{{ asset('storage/' . $product->image) }}" alt="" />
                        <div class="image_overlay"></div>
                        <div class="add_to_cart"><a href="{{ route('add-to-cart', ['id' => $product->id]) }}"
                                class="thuan">Add to cart</a></div>
                        <div class="view_gallery">View gallery</div>
                        <div class="stats">
                            <div class="stats-container">
                                <span class="product_price">${{ $product->price }}</span>
                                <span class="product_name">{{ $product->name }}</span>
                                <p>{{ $product->description }}</p>
                                <div class="product-options">
                                    <strong>SIZES</strong>
                                    @foreach ($product->size as $size)
                                        <span>{{ $size->name }}</span>
                                    @endforeach
                                    <strong>COLORS</strong>
                                    @foreach ($product->color as $color)
                                        <div class="colors">
                                            <div class=""><span><img src="{{ asset('storage/' . $color->image) }}"
                                                        alt=""></span></div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product-back">
                        <div class="shadow"></div>
                        <div class="carousel">
                            <ul class="carousel-container">
                                <li><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/8.jpg" alt="" />
                                </li>
                                <li><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/7.jpg" alt="" />
                                </li>
                            </ul>
                            <div class="arrows-perspective">
                                <div class="carouselPrev">
                                    <div class="y"></div>
                                    <div class="x"></div>
                                </div>
                                <div class="carouselNext">
                                    <div class="y"></div>
                                    <div class="x"></div>
                                </div>
                            </div>
                        </div>
                        <div class="flip-back">
                            <div class="cy"></div>
                            <div class="cx"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach 
        {{ $itemsProdcuts->links() }}
    </div>
@endsection
<script>
    // Hiển thị thông báo xanh và tự động ẩn sau 7 giây
    document.addEventListener('DOMContentLoaded', function () {
        var successMessage = document.getElementById('success-message');
        
        if (successMessage) {
            successMessage.style.display = 'block';

            setTimeout(function () {
                successMessage.style.display = 'none';
            }, 7000);
        }
    });
</script>
