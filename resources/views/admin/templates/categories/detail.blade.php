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
        <form action="{{ route('route_admin_category_update',['id'=>request()->route('id')]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" value="{{$items->name}}" class="form-control" id="exampleInputEmail1" placeholder="Enter Name" name="name">
            </div>
            <div class="form-group">
                <label for="Image">Image</label>
                <li class="list-inline-item">
                    <img alt="Avatar" class="img-fluid" src="{{asset('storage/'.$items->image)}}">
                </li>
                <input type="file" class="form-control" name="image">
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update Categories</button>
            </div>
        </form>
    </div>
@endsection
