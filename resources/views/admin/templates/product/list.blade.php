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
    <div class="">
        <div class="card-header">
            <h3 class="card-title">Projects</h3>
            <div class="card-tools">
                <a class="btn btn-info btn-sm" href="{{ route('route_admin_products_add') }}">
                    Add new
                </a>
                <button id="deleteMultiple" class="btn btn-danger btn-sm btn-del" data-product-id="">Delete Mutiple</button>
            </div>
        </div>
        <div class="card-body ">
            <table class="table table-striped projects">
                <thead>
                    <tr>
                        <th style="width: 1%">
                            #
                        </th>
                        <th style="width: 20%">
                            Product Name
                        </th>
                        <th style="width: 20%">
                            Image
                        </th>
                        <th style="width: 20%">
                            Categories Name
                        </th>
                        <th style="width: 20%">
                            Color
                        </th>
                        <th>
                            Size
                        </th>
                        <th style="width: 20%">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>
                                <input type="checkbox" class="deleteCheckbox" name="selectedProducts[]" data-product-id="{{ $item->id }}">
                            </td>
                            <td>
                                <a>
                                    {{ $item->name }}
                                </a>
                                <br />
                                <small>
                                    {{ $item->created_at }}
                                </small>
                            </td>
                            <td>
                                <ul class="list-inline">
                                    <li class="list-inline-item">
                                        <img alt="Avatar" class="img-fluid" width="50px" height="50px"
                                            src="{{ asset('storage/' . $item->image) }}">
                                    </li>
                                </ul>
                            </td>
                            <td>
                                @foreach ($item->category as $cate)
                                    <small>
                                        {{ $cate->name }}
                                    </small>
                                @endforeach
                            </td>

                            <td>
                                @foreach ($item->color as $colors)
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <img alt="Avatar" class="table-avatar"
                                                src="{{ asset('storage/' . $colors->image) }}">
                                        </li>
                                    </ul>
                                @endforeach
                            </td>
                            <td>
                                @foreach ($item->size as $size)
                                    <small>
                                        {{ $size->name . ',' }}
                                    </small>
                                @endforeach
                            </td>

                            <td class="project-state">

                            </td>
                            <td class="project-actions text-right">
                                <a class="btn btn-info btn-sm"
                                    href="{{ route('route_admin_products_detail', ['id' => $item->id]) }}">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                    Edit
                                </a>
                                <a onclick="return myFunction()" class="btn btn-danger btn-sm"
                                    href="{{ route('route_admin_products_delete', ['id' => $item->id]) }}">
                                    <i class="fas fa-trash">
                                    </i>
                                    Delete
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

<script>
    function myFunction() {
        if (!confirm("Are You Sure to delete this"))
            event.preventDefault();
    }
</script>
<script>
     $(document).ready(function () {
        $.('.btn-del').on('click', function(){
            console.log(123);
        })
     })
</script>
