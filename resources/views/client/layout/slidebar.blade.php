<div id="sidebar">
	<h3><a style="text-decoration: none; color: black" href="{{ route('show-cart') }}">Cart</a></h3>
    <h3>Search</h3>
    <div class="checklist">
        <form action="{{ route('product.search') }}" method="GET">
            <input type="text" name="keyword" placeholder="Input Keywords">
            <button type="submit">Search</button>
        </form>
    </div>
    <h3>CATEGORIES</h3>
    <div class="checklist colors">
    	<ul>
            @foreach ($itemsCategories as $item)
            <li><a href="{{ route('product.search.by.category', ['category' => $item->name]) }}"><span></span>{{$item->name}}</a></li>
            @endforeach
        	
        </ul>
    </div>
    
    <h3>COLORS</h3>
    <div class="checklist colors">
    	<ul>
            @foreach ($itemsColors as $item)
            <li><a href="{{ route('product.search.by.color', ['name' => $item->name]) }}"><span></span>{{$item->name}}</a></li>
            @endforeach
        </ul>
    </div>
    
    <h3>SIZES</h3>
    <div class="checklist sizes">
    	<ul>
            @foreach ($itemsSizes as $item)
            <li><a href=""><span></span>{{$item->name}}</a></li>
            @endforeach
        </ul>
    </div>
</div>