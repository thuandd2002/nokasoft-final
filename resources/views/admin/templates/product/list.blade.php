@extends('admin.layout.layout')
<meta name="csrf-token" content="{{ csrf_token() }}">
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
                <button id="deleteMultiple" class="btn btn-danger btn-sm" data-product-id="[]">Delete Mutiple</button>
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
                        <th style="width: auto">
                            Price
                        </th>
                        <th style="width:10%">
                            Color
                        </th>
                        <th>
                            Size
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>
                                <input type="checkbox" class="product-checkbox" name="product_ids[]"
                                    value="{{ $item->id }}">
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
                                <small>
                                    {{ $item->category->pluck('name')->implode(', ') }}
                                </small>
                            </td>
                            <td>

                                <small>
                                    {{ $item->price }}
                                </small>

                            </td>
                            <td>
                                @foreach ($item->color as $colors)
                                    <img alt="Avatar" class="table-avatar" src="{{ asset('storage/' . $colors->image) }}">
                                @endforeach
                            </td>
                            <td>
                                <small>
                                    {{ $item->size->pluck('name')->implode(', ') }}
                                </small>
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
                    {{ $items->links() }}
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

@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {
            $('#deleteMultiple').on('click', function() {
                var productIds = $('.product-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();
                console.log(productIds);
                if (productIds.length > 0) {
                    $.ajax({
                        url: '/admin/products/delete-multiple',
                        type: 'DELETE',
                        data: {
                            __tokens: '{{ csrf_token() }}',
                            product_ids: productIds
                        },
                        success: function(response) {
                            console.log(response.message);
                            location.reload();
                            alert('Đã xóa sản phẩm thành công.');
                        },
                        error: function(error) {
                            console.error('Xóa sản phẩm không thành công.', error);
                        }
                    });
                } else {
                    console.warn('Vui lòng chọn ít nhất một sản phẩm để xóa.');
                }
            });
        });
    </script>
@endsection
