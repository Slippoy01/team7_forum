@extends('layout.main')

@section('title', 'Topik Saya')

@section('content-header')
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">New Discussion Topic</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="container">
                <div class="mb-2">
                    <a href="{{ route('topik.create') }}" class="btn btn-primary">New Topic</a>
                </div>
                <table id="topik-table" class="responsive table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Tag</th>
                            <th>Public</th>
                            <th>Publication</th>
                            <th>Category</th>
                            <th>Action</th>
                            <!-- Add more table headers for other attributes -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($userTopik as $key => $topik)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $topik->judul }}</td>
                                <td>{{ $topik->tag }}</td>
                                <td>{{ $topik->publik }}</td>
                                <td>{{ $topik->stat_publikasi }}</td>
                                <td>{{ $topik->kategori->nama }}</td>
                                <td>
                                    <a href="{{ route('topik.show', [$topik->id, Str::slug($topik->judul)]) }}" target="_blank" class="btn btn-sm btn-secondary">Detail</a>
                                    <a href="{{ route('topik.edit', [$topik->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('topik.delete', [$topik->id]) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                                <!-- Add more table cells for other attributes -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('scripts-js')
    <script src="{{ asset('adminlte3/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('adminlte3/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#topik-table').DataTable();
        });
    </script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.css" />
@endpush
