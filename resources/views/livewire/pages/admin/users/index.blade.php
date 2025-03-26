@extends('livewire.layout.template')

@section('title', 'User Management')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">User List</h1>

    <table id="myTable" class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#myTable').DataTable({
            responsive: true,
            language: {
                paginate: {
                    previous: '‹',
                    next: '›'
                }
            }
        });
    });
</script>
@endsection
