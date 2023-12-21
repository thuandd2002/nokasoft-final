@extends('admin.layout.layout')
@section('col')
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <strong>{{ Session::get('success') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
        </div>
    @endif
    <?php //Hiển thị thông báo lỗi
    ?>
    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <strong>{{ Session::get('error') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
        </div>
    @endif
    <div class="col-md-6">
        <form action="{{ route('route_admin_products_update', ['id' => request()->route('id')]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="">Name</label>
                <input type="text" value="{{ $items->name }}" class="form-control" placeholder="Enter Name"
                    name="name">
            </div>
            <div class="form-group">
                <label for="name">Price</label>
                <input type="text" class="form-control" value="{{ $items->price }}" name="price">
            </div>
            <div class="form-group">
                <label for="categories">Categories</label>
                <select class="form-control" name="categorie[]" multiple>
                    @foreach ($categories as $cate)
                        <option value="{{ $cate->id }}"
                            {{ in_array($cate->id, $selectedCategories) ? 'selected' : '' }}>
                            {{ $cate->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="size">Size</label>
                <select class="form-control" name="size[]" multiple>
                    @foreach ($sizes as $size)
                        <option value="{{ $size->id }}" {{ in_array($size->id, $selectedSizes) ? 'selected' : '' }}>
                            {{ $size->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Color</label>
                <select class="form-control" name="color[]" multiple>
                    @foreach ($colors as $color)
                        <option value="{{ $color->id }}" {{ in_array($color->id, $selectedColors) ? 'selected' : '' }}>
                            {{ $color->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="Image">Image</label>
                <img alt="Avatar" class="img-fluid" width="50px" src="{{asset('storage/'.$items->image)}}">
                <input type="file" class="form-control" name="image">
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update Categories</button>
            </div>
        </form>
    </div>
@endsection
