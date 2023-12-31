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
            <h3 class="card-title">List Categories</h3>
            <div class="card-tools">
                <a class="btn btn-info btn-sm" href="{{ route('route_admin_category_add') }}">
                    Add new
                </a>
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
                            Team Members
                        </th>

                        <th style="width: 20%">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr id="{{ $item->id }}">
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
                                <ul class="list-inline">
                                    <li class="list-inline-item">
                                        <img alt="Avatar" class="img-fluid" width="50px"
                                            src="{{ asset('storage/' . $item->images) }}">
                                    </li>
                                </ul>
                            </td>

                            <td class="project-actions text-right">
                                <a class="btn btn-info btn-sm"
                                    href="{{ route('route_admin_category_detail', ['id' => $item->id]) }}">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                    Edit
                                </a>
                                <a onclick="return myFunction()" class="btn btn-danger btn-sm"
                                    href="{{ route('route_admin_category_delete', ['id' => $item->id]) }}">
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

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function myFunction() {
        if (!confirm("Are You Sure to delete this"))
            event.preventDefault();
    }
</script>
