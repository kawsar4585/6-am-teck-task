@extends('user.layouts.layout')
@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">File Upload</div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <form method="POST" action="{{ route('user.upload') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">Choose Files</label>
                            <input type="file" class="form-control" id="file" name="file[]" multiple required>
                            @error('file')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            @if($errors->has('file.*'))
                                <span class="text-danger">{{ $errors->first('file.*') }}</span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">My Uploaded Files</div>
                <div class="card-body">
                    @if($files->isEmpty())
                        <div class="alert alert-info">No files uploaded yet.</div>
                    @else
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Original</th>
                                <th>Thumbnail</th>
                                <th>Filename</th>
                                <th>Uploaded At</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($files as $file)
                            <tr>
                                <td><img src="{{ asset('storage/' . $file->path) }}" alt="Original" width="80"></td>
                                <td>
                                    @if($file->thumbnail_path)
                                        <img src="{{ asset('storage/' . $file->thumbnail_path) }}" alt="Thumbnail" width="80">
                                    @else
                                    <img src="{{ asset('storage/' . $file->path) }}" alt="Thumbnail" width="80">
                                    @endif
                                </td>
                                <td>{{ $file->filename }}</td>
                                <td>{{ $file->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $files->links('vendor.pagination.common_pagination') }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
