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
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                </button>
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
                            Categories Name
                        </th>
                        <th style="width: 30%">
                            Color
                        </th>
                        <th>
                            Size
                        </th>
                        <th style="width: 8%" class="text-center">
                            Status
                        </th>
                        <th style="width: 20%">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>
                                {{ $item->id }}
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
                                @foreach ($colors as $colorsItems)
                                    <ul class="list-inline">
                                        @foreach ($colorsItems as $colorsItem)
                                            @if ($colorsItem->product_id == $item->id)
                                                <li class="list-inline-item">
                                                    <img alt="Avatar" class="table-avatar"
                                                        src="{{ asset('storage/' . $colorsItem->image) }}">
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endforeach
                            </td>
                            <td>
                                @foreach ($size as $sizeItems)
                                    @foreach ($sizeItems as $sizeItem)
                                        @if ($sizeItem->product_id == $item->id)
                                            <small>
                                                {{ $sizeItem->name }}
                                            </small>
                                        @endif
                                    @endforeach
                                @endforeach
                            </td>

                            <td class="project-state">
                                <span class="badge badge-success">Success</span>
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
