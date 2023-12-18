<div id="sidebar">
	<h3>CART</h3>
    <div id="cart">
    	<span class="empty">No items in cart.</span>       
    </div>
  
    <h3>CATEGORIES</h3>
    <div class="checklist categories">
    	<ul>
            @foreach ($itemsCategories as $item)
            <li><a href=""><span></span>{{$item->name}}</a></li>
            @endforeach
        	
        </ul>
    </div>
    
    <h3>COLORS</h3>
    <div class="checklist colors">
    	<ul>
            @foreach ($itemsColors as $item)
            <li><a href=""><span></span>{{$item->name}}</a></li>
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
    
     <h3>PRICE RANGE</h3>
     <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/price-range.png" alt="" />
</div>