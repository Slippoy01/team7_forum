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
                    No Data
                @endforelse

                <nav>
                    {{ $topics->links() }}
                </nav>

            </div>
        </div>
    </div>
@endsection


