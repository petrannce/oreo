@extends('layouts.backend.header')

@section('content')

<section class="content blog-page">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>New Post
                    <small>Welcome to Oreo</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{route('admin')}}"><i class="zmdi zmdi-home"></i> Oreo</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{route('blogs')}}">Blog</a></li>
                    <li class="breadcrumb-item active">New Post</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <form action="{{route('blogs.store')}}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="body">
                            <div class="mb-3">
                                <label for="blog_title" class="form-label">Blog Title</label>
                                <input type="text" class="form-control" name="title" placeholder="Enter Blog title" />
                            </div>
                            <div class="mb-3">
                                <label for="blog tag" class="form-label">Tag</label>
                                <select class="form-control show-tick" name="tag">
                                    <option value="">Select Tag --</option>
                                    @foreach ($tags as $tag)
                                        <option value="{{$tag->name}}">{{$tag->name}}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="blog_desc" class="form-label">Description</label>
                                <textarea rows="3" class="form-control no-resize" name="description"
                                    placeholder="Please type your description..."></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="blog_image" class="form-label">Image</label>
                                <div class="fallback">
                                    <input name="image" type="file" />
                                </div>
                            </div>
                        </div>

                        <div class="mb-3" align="center">
                            <button type="submit" class="btn btn-primary btn-round">Submit</button>
                            <button type="submit" class="btn btn-default btn-round btn-simple">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection