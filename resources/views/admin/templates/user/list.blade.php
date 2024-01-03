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
            <h3 class="card-title">User</h3>
        </div>
        <div class="card-body ">
            <table class="table table-striped projects">
                <thead>
                    <tr>
                        <th style="width: 1%">
                            #
                        </th>
                        <th style="width: 20%">
                            Name
                        </th>
                        <th style="width: 30%">
                           Role
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user as $item)
                        <tr id="{{ $item->id }}">
                            <td>
                                {{ $item->id }}
                            </td>
                            <td>
                                <a>
                                    {{ $item->name }}
                                </a>
                              
                            </td>
                         
                            <td class="project-actions text-right">
                                <a class="btn btn-info btn-sm"
                                    href="{{ route('route_admin_users_detail', ['id' => $item->id]) }}">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                    Edit
                                </a>
                                <button class="btn btn-danger btn-sm btn-del"
                                    data-user-id="{{ $item->id }}">Delete</button>
                                @csrf
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
<script>
    $(document).ready(function() {
        $('.btn-del').on('click', function() {
            var userId = $(this).data('user-id');

            if (confirm('Are you sure you want to delete this user?')) {
                $.ajax({
                    type: 'DELETE',
                    url: '/admin/user/delete/' + userId,
                    data: {
                        '_token': '{{ csrf_token() }}',
                    },
                    success: function(data) {
                        if (data.success) {
                            $(`#${userId}`).remove()
                            alert('Deleted Successfully ')
                        } else {
                            alert('Failed to delete user');
                        }
                    },
                    error: function(data) {
                        alert('Failed to delete user');
                    }
                });
            }
        });
    });
</script>
