@extends('layout.main')

@section('title', 'Topik')

@section('content-header')
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">{{ $data->judul }}</h1>
                    <div class="mt-2">
                        <a href="#?cat=laravel" class="mr-3">
                            <i class="fa fa-circle fa-xs text-primary"></i>
                            {{ $data->kategori->nama }}
                        </a>

                        @php
                            $arrTag = strpos($data->tag, ',') !== false ? explode(',', $data->tag) : $data->tag;
                            if (is_array($arrTag)) {
                                foreach ($arrTag as $value) {
                                    echo '<a href="#?tag=' .
                                        trim($value) .
                                        '"><span class="badge badge-secondary m-1">' .
                                        trim($value) .
                                        '</span></a>';
                                }
                            } else {
                                echo '<a href="#?tag=' .
                                    trim($arrTag) .
                                    '"><span class="badge badge-secondary m-1">' .
                                    trim($arrTag) .
                                    '</span></a>';
                            }
                        @endphp
                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('content')
    <div class="card card-widget widget-user-2">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="bg-secondary widget-user-header">
            <div class="widget-user-image">
                <img class="img-circle elevation-2"
                    src="https://ui-avatars.com/api/?name={{ $data->user->name }}&color=0c488c&background=fff"
                    alt="User Avatar">
            </div>
            <!-- /.widget-user-image -->
            <h3 class="widget-user-username">{{ $data->user->name }}</h3>
            <h5 class="widget-user-desc">{{ $data->user->profil->biodata }}</h5>
        </div>

        <div class="card-body">
            @if ($data->gambar)
                <img src="{{ asset('image-topik/' . $data->gambar) }}" class="img-fluid">
            @endif
            {!! $data->deskripsi !!}
        </div>

        <div class="card-footer">
            @auth

                @if ($errors->any())
                    <div class="alert alert-danger m-2">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="form_komentar" method="POST" action="{{ route('komentar.store') }}"
                    class="form-horizontal text-right">
                    @csrf
                    <input type="hidden" name="pertanyaan_id" value="{{ $data->id }}">
                    <textarea class="form-control mb-2" placeholder="Reply" rows="2" name="deskripsi"></textarea>
                    <button type="submit" class="btn btn-sm btn-primary">
                        Reply
                    </button>
                </form>
            @endauth
            @guest
                Please <a href="{{ route('login') }}">Login</a> to give commentary
            @endguest
        </div>
    </div>

    <h4>Comment</h4>
    <div class="card">
        <div class="card-body">
            @forelse ($data->jawaban as $item)
                <!-- Post -->
                <div class="post clearfix">
                    <div class="user-block">
                        <img class="img-circle img-bordered-sm"
                            src="https://ui-avatars.com/api/?name={{ $item->nama_user }}&color=0c488c&background=fff"
                            alt="User Image">
                        <span class="username">
                            <a href="#">{{ $item->nama_user }}</a>
                            @auth
                                @if (Auth::user()->id == $item->user_id)
                                    <a href="javascript:void(0);" class="float-right btn-tool text-danger delete-comment"
                                        data-id="{{ $item->id }}"><i class="fas fa-trash"></i></a>
                                    <a href="javascript:void(0);" class="float-right btn-tool text-info" data-toggle="modal"
                                        data-target="#jawabanModal" data-jawabanid="{{ $item->id }}"
                                        data-jawaban="{{ $item->deskripsi }}"><i class="fas fa-edit"></i></a>
                                @endif
                            @endauth
                        </span>
                        <span
                            class="description">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($item->created_at))->diffForHumans() }}</span>
                    </div>
                    <!-- /.user-block -->
                    <p>
                        {!! nl2br($item->deskripsi) !!}
                    </p>
                    @auth
                        <p>
                            <a href="javascript:void(0);" class="link-black text-sm likedislike" data-id="{{ $item->id }}"
                                data-attr="Up"><i class="far fa-thumbs-up mr-1"></i> {{ $item->vote_up }}</a>
                            <a href="javascript:void(0);" class="link-black text-sm ml-2 likedislike"
                                data-id="{{ $item->id }}" data-attr="Down"><i class="fas fa-thumbs-down mr-1"></i>
                                {{ $item->vote_down }}</a>
                        </p>
                    @endauth
                    @guest
                        <p>
                            <a href="javascript:void(0);" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i>
                                {{ $item->vote_up }}</a>
                            <a href="javascript:void(0);" class="link-black text-sm ml-2"><i
                                    class="fas fa-thumbs-down mr-1"></i> {{ $item->vote_down }}</a>
                        </p>
                    @endguest

                    @foreach ($tanggapan as $itemTanggapan)
                        @if ($itemTanggapan->main_id == $item->id)
                            <div class="ml-4">
                                <div class="post clearfix">
                                    <div class="user-block">
                                        <img class="img-circle img-bordered-sm"
                                            src="https://ui-avatars.com/api/?name={{ $itemTanggapan->user->name }}&color=0c488c&background=fff"
                                            alt="User Image">
                                        <span class="username">
                                            <a href="#">{{ $itemTanggapan->user->name }}</a>
                                            @auth
                                                @if (Auth::user()->id == $itemTanggapan->user_id)
                                                    <a href="javascript:void(0);"
                                                        class="float-right btn-tool text-danger delete-comment"
                                                        data-id="{{ $itemTanggapan->id }}"><i class="fas fa-trash"></i></a>
                                                    <a href="javascript:void(0);" class="float-right btn-tool text-info"
                                                        data-toggle="modal" data-target="#jawabanModal"
                                                        data-jawabanmainid="{{ $item->id }}"
                                                        data-jawabanid="{{ $itemTanggapan->id }}"
                                                        data-jawaban="{{ $itemTanggapan->deskripsi }}"><i
                                                            class="fas fa-edit"></i></a>
                                                @endif
                                            @endauth
                                        </span>
                                        <span
                                            class="description">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($itemTanggapan->created_at))->diffForHumans() }}</span>
                                    </div>
                                    <!-- /.user-block -->
                                    <p>
                                        {!! nl2br($itemTanggapan->deskripsi) !!}
                                    </p>
                                    @auth
                                        <p>
                                            <a href="javascript:void(0);" class="link-black text-sm likedislike"
                                                data-id="{{ $itemTanggapan->id }}" data-attr="Up"><i
                                                    class="far fa-thumbs-up mr-1"></i> {{ $itemTanggapan->vote_up }}</a>
                                            <a href="javascript:void(0);" class="link-black text-sm ml-2 likedislike"
                                                data-id="{{ $itemTanggapan->id }}" data-attr="Down"><i
                                                    class="fas fa-thumbs-down mr-1"></i> {{ $itemTanggapan->vote_down }}</a>
                                        </p>
                                    @endauth
                                    @guest
                                        <p>
                                            <a href="javascript:void(0);" class="link-black text-sm"><i
                                                    class="far fa-thumbs-up mr-1"></i> {{ $itemTanggapan->vote_up }}</a>
                                            <a href="javascript:void(0);" class="link-black text-sm ml-2"><i
                                                    class="fas fa-thumbs-down mr-1"></i> {{ $itemTanggapan->vote_down }}</a>
                                        </p>
                                    @endguest
                                </div>
                            </div>
                        @endif
                    @endforeach

                    @auth
                        <form method="POST" action="{{ route('komentar-tanggapan.store') }}"
                            class="form-horizontal text-right">
                            @csrf
                            <input type="hidden" name="main_id" value="{{ $item->id }}">
                            <input type="hidden" name="pertanyaan_id" value="{{ $data->id }}">
                            <textarea class="form-control mb-2" placeholder="Reply" rows="2" name="deskripsi"></textarea>
                            <button type="submit" class="btn btn-sm btn-primary">
                                Reply
                            </button>
                        </form>
                    @endauth
                </div>
                <!-- /.post -->
            @empty
                <div class="text-center">
                    No one still not give a comment.
                </div>
            @endforelse
        </div><!-- /.card-body -->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="jawabanModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="jawabanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jawabanModalLabel">Edit Reply</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_komentar" method="POST" action="{{ route('komentar.update', [$data->id]) }}"
                        class="form-horizontal text-right">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="id" id="jawaban_id" value="">
                        <input type="hidden" name="main_id" id="jawaban_main_id" value="">
                        <input type="hidden" name="pertanyaan_id" value="{{ $data->id }}">
                        <textarea class="form-control mb-2" placeholder="Reply" rows="2" name="deskripsi" id="deskripsi_edit"></textarea>
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-sm btn-primary">
                            Reply
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts-js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#jawabanModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var jawaban_main_id = button.data('jawabanmainid')
                var jawaban_id = button.data('jawabanid')
                var jawaban = button.data('jawaban')
                $('#jawaban_main_id').val(jawaban_main_id);
                $('#jawaban_id').val(jawaban_id);
                $('#deskripsi_edit').val(jawaban);
            })

            $('.delete-comment').on('click', function() {
                var id = $(this).attr('data-id');
                deleteJawaban(id);
            });

            $('.likedislike').on('click', function() {
                var id = $(this).attr('data-id');
                var vote = $(this).attr('data-attr');
                likedislike(id, vote);
            });

            function likedislike(id, vote) {
                let data = {
                    "id": id,
                    "vote": vote,
                    '_token': $('meta[name="csrf-token"]').attr('content')
                };
                return fetch('/komentar/vote', {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify(data),
                    }).then(response => {
                        location.reload();
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }

            function deleteJawaban(id) {
                Swal.fire({
                    title: "Delete this comment ?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#c9302c",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    showLoaderOnConfirm: true,
                    preConfirm: (value) => {
                        let data = {
                            "id": id,
                            '_token': $('meta[name="csrf-token"]').attr('content')
                        };
                        return fetch('/komentar/' + id, {
                                method: "DELETE",
                                headers: {
                                    "Content-Type": "application/json",
                                },
                                body: JSON.stringify(data),
                            }).then(response => {

                            })
                            .catch(error => {
                                console.log(error);
                            });
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed == true) {
                        location.reload();
                    }
                });
            }
        });
    </script>
@endpush
