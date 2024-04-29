@extends('layout.main')

@section('title', 'Topik Baru')

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
                <form method="POST" action="{{ route('topik.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="judul" class="form-label">Title</label>
                        <input type="text" id="judul" name="judul" value="{{ old('judul') }}" class="form-control"
                            required>
                        @error('judul')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="slug">Slug:</label>
                        <input type="text" id="slug" name="slug" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="tag" class="form-label">Tag</label>
                        <input type="text" id="tag" name="tag" value="{{ old('tag') }}" class="form-control"
                            required>
                        @error('tag')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Description</label>
                        <textarea id="deskripsi" name="deskripsi" class="form-control">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="gambar" class="form-label">Image</label>
                        <input type="file" id="gambar" name="gambar" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="publik" class="form-label">Public</label>
                        <select id="publik" name="publik" class="form-select">
                            <option value="Ya">Yes</option>
                            <option value="Tidak">No</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">Category</label>
                        <select id="kategori_id" name="kategori_id" class="form-select" required>
                            @foreach ($kategori as $kat)
                                <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                    <div class="mb-3">
                        <label for="stat_publikasi" class="form-label">Public Status</label>
                        <select id="stat_publikasi" name="stat_publikasi" class="form-select">
                            <option value="Ya">Yes</option>
                            <option value="Tidak">No</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts-js')
<script src="https://cdn.tiny.cloud/1/wxp6wxzy8utc61kokti6al0g26f012tziy5m0zncj8ibue3v/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        $(document).ready(function() {
            // Listen for changes in the 'Judul' field
            $('#judul').on('input', function() {
                var judul = $(this).val(); // Get the value of the 'Judul' field
                var slug = slugify(judul); // Convert the 'Judul' value to a slug
                $('#slug').val(slug); // Set the 'Slug' field value
            });

            // Function to convert string to slug
            function slugify(text) {
                return text.toString().toLowerCase()
                    .replace(/\s+/g, '-') // Replace spaces with -
                    .replace(/[^\w\-]+/g, '') // Remove all non-word chars
                    .replace(/\-\-+/g, '-') // Replace multiple - with single -
                    .replace(/^-+/, '') // Trim - from start of text
                    .replace(/-+$/, ''); // Trim - from end of text
            }

            tinymce.init({
    selector: 'textarea',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
  });
        });
    </script>
@endpush
