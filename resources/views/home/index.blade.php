@extends('layout.main')

@section('title', 'Home')

@section('content-header')
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Home</h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            @auth
                <a href="{{ route('topik.create') }}" class="btn btn-success mb-3">Create New Topic</a>
            @endauth
            <div class="row">

                @forelse ($topics as $topic)
                    <div class="col-md-3 mb-3">
                        <div class="card" style="width: 15rem;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $topic->judul }}</h5>
                                <img src="image-topik/{{ $topic->gambar }}" class="card-img-top" alt="...">
                                <p class="card-text">{!! $topic->deskripsi !!}</p>
                                <a href="{{ route('topik.show', [$topic->id, $topic->slug]) }}" class="btn btn-primary">View</a>
                            </div>
                        </div>
                    </div>
                @empty
                    Gak ada apa apa dek
                @endforelse

                <nav>
                    {{ $topics->links() }}
                </nav>

            </div>
        </div>
    </div>
@endsection

{{-- @push('scripts-js')
    <script src="{{ asset('adminlte3/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('adminlte3/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
    <script>
        $(function() {
            var tableMain = '';

            tableMain = $('#main-table').DataTable({
                processing: true,
                serverSide: true,
                pagingType: 'numbers',
                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],
                columns: [{
                        "data": "judul",
                        render: function(data, type, row) {
                            return row.link_judul
                        },

                    },
                    {
                        "data": "kategori.nama",
                        render: function(data, type, row) {
                            return row.link_kategori
                        },
                    },
                    {
                        "data": "countjawaban.jml",
                        render: function(data, type, row) {
                            if(data){
                                return data;
                            }else{
                                return 0;
                            }
                        },
                        "className": 'text-center'
                    },
                    {
                        "data": "waktu_publikasi",
                        render: function(data, type, row) {
                            return moment(data, "YYYY-MM-DD HH:mm:ss").fromNow();
                        },
                        "className": 'text-center'
                    },
                ],
                order: [
                    [0, "asc"]
                ],
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        if (tableMain.hasOwnProperty('settings')) {
                            tableMain.settings()[0].jqXHR.abort();
                        }
                    },
                    url: "{{ url('home/data') }}",
                    method: 'POST'
                },
                oLanguage: {
                    "sLengthMenu": "_MENU_",
                    "sZeroRecords": "No Data!",
                    "sProcessing": "Please wait.",
                    "sInfo": "_START_ - _END_ / _TOTAL_",
                    "sInfoFiltered": "",
                    "sInfoEmpty": "0 - 0 / 0",
                    "infoFiltered": "(_MAX_)",
                }
            });
        });
    </script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.css" />
@endpush --}}
