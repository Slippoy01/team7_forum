@extends('layout.main')

@section('title', 'Kategori')

@section('content-header')
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Categories</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="container">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">
                    Create New Category
                </button>
                <table class="table table-bordered" id="table-kategori">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_kategori as $key => $kategori)
                            <tr>
                                <td style="width: 20px">{{ $key + 1 }}</td>
                                <td>{{ $kategori->nama }}</td>
                                <td style="width: 150px">
                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $kategori->id }}">Edit</button>
                                    <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST"
                                        style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @include('kategori.edit', ['kategori' => $kategori])
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('kategori.create')

@endsection

@push('scripts-js')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.css" />
<script src="{{ asset('adminlte3/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('adminlte3/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>

    <script>
        $(document).ready(function() {

            $('#table-kategori').DataTable();
            $(document).on('click', "#edit-item", function() {
                $(this).addClass(
                    'edit-item-trigger-clicked');

                var options = {
                    'backdrop': 'static'
                };
                $('#edit-modal').modal(options)
            })

            $('#edit-modal').on('show.bs.modal', function() {
                var el = $(".edit-item-trigger-clicked");
                var row = el.closest(".data-row");
                var id = el.data('item-id');
                var name = row.children(".name").text();
                console.log(id);
                $("#modal-input-name").val(name);

            })

            $('#edit-modal').on('hide.bs.modal', function() {
                $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
                $("#edit-form").trigger("reset");
            })
        })
    </script>
@endpush
