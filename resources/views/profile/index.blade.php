@extends('layout.main')

@section('title', 'Topik')

@section('content-header')
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Profile</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                            src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&color=0c488c&background=fff"
                            alt="User profile picture">
                    </div>

                    <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>

                    <p class="text-muted text-center">{{ Auth::user()->profil->umur }} Year</p>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">About Me</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <strong><i class="fas fa-envelope mr-1"></i> Email</strong>

                    <p class="text-muted">
                        {{ Auth::user()->profil->email }}
                    </p>

                    <hr>
                    
                    <strong><i class="fas fa-book mr-1"></i> Biodata</strong>

                    <p class="text-muted">
                        {{ Auth::user()->profil->biodata }}
                    </p>

                    <hr>

                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Address</strong>

                    <p class="text-muted">{{ Auth::user()->profil->alamat }}</p>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                        <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="activity">

                            @foreach ($topik as $item)
                                <!-- Post -->
                                <div class="post">
                                    <div class="user-block">
                                        <img class="img-circle img-bordered-sm"
                                            src="https://ui-avatars.com/api/?name={{ $item->user->name }}&color=0c488c&background=fff"
                                            alt="user image">
                                        <span class="username">
                                            <a href="#">{{ $item->user->name }}</a>
                                        </span>
                                        <span
                                            class="description">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($item->waktu_publikasi))->diffForHumans() }}</span>
                                    </div>
                                    <!-- /.user-block -->
                                    <a
                                        href="{{ route('topik.show', [$item->id, Str::slug($item->judul)]) }}">{{ $item->judul }}</a>

                                    <p>
                                        <a href="#" class="link-black text-sm mr-2"><i
                                                class="fas fa-tag mr-1"></i>{{ $item->kategori->nama }}</a>
                                        <a href="#" class="link-black text-sm">
                                            <i class="far fa-comments mr-1"></i> Comments
                                            ({{ count($item->jawaban) }})
                                        </a>
                                    </p>
                                </div>
                                <!-- /.post -->
                            @endforeach
                        </div>

                        <div class="tab-pane" id="settings">

                            @if ($errors->any())
                                <div class="alert alert-danger m-2">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li class="mb-0">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form class="form-horizontal" method="POST" action="{{ route('profile.update') }}">
                                @method('PUT')
                                @csrf
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Name" required value="{{ Auth::user()->name }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Email" required value="{{ Auth::user()->email }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="umur" class="col-sm-2 col-form-label">Age</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="umur" name="umur"
                                            placeholder="Umur" required value="{{ Auth::user()->profil->umur }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="biodata" class="col-sm-2 col-form-label">Biodata</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="biodata" name="biodata"
                                            placeholder="Biodata" required value="{{ Auth::user()->profil->biodata }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="alamat" class="col-sm-2 col-form-label">Address</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="alamat" name="alamat" required>{{ Auth::user()->profil->alamat }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="Password">
                                        <small>fill to change your password</small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-danger">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
@endsection
