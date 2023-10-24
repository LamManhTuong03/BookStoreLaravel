@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Category</h4>
                    <a href="{{url('admin/category')}}" class="btn btn-primary btn-sm text-white float-end">BACK</a>
                </div>
                <div class="card-body">
                    <form action="{{url('admin/category/'.$category->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="exampleInputName1">Name</label>
                            <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" name="name" value="{{$category->name}}">
                            @error('name')<small class="text-danger">{{$message}}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail3">Slug</label>
                            <input type="text" class="form-control" id="exampleInputEmail3" placeholder="Slug" name="slug" value="{{$category->slug}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword4">Description</label>
                            <input type="text" class="form-control" id="exampleInputPassword4" placeholder="Description" name="description" value="{{$category->description}}">
                        </div>

                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="image" class="form-control">
                            <img src="{{asset('upload/category/'.$category->image)}}" width="60px" height="60px" />
                        </div>
                        <div class="form-group">
                            <label for="exampleInputCity1">Status</label>
                            <input type="checkbox" name="status" value="{{$category->status == '1' ? 'checked' : ''}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword4">Meta Title</label>
                            <input type="text" class="form-control" id="exampleInputPassword4" placeholder="Meta Title" name="meta_title" value="{{$category->meta_title}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword4">Meta Keyword</label>
                            <textarea class="form-control" id="exampleInputPassword4" placeholder="Meta Keyword" name="meta_keyword" rows="3">{{$category->meta_keyword}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword4">Meta Description</label>
                            <textarea class="form-control" id="exampleInputPassword4" placeholder="Meta Description" name="meta_description" rows="3">{{$category->meta_description}}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary me-2">Submit</button>
                        <button class="btn btn-light">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


