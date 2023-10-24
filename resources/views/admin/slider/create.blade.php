@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(session('message'))
                <div class="alert alert-success">{{session('message')}}</div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h4>Add Slider</h4>
                    <a href="{{url('admin/sliders')}}" class="btn btn-primary btn-sm text-white float-end">BACK</a>
                </div>
                <div class="card-body">
                    <form action="{{url('admin/sliders/create')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputName1">Title</label>
                            <input type="text" class="form-control" id="exampleInputName1" placeholder="Title" name="title">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail3">Description</label>
                            <textarea class="form-control" id="exampleInputEmail3" placeholder="Description" name="description" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInput">Image</label>
                            <input type="file" class="form-control" name="image">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <input type="checkbox" name="status"  class="form-control" style="width: 30px">
                        </div>

                        <button type="submit" class="btn btn-primary me-2">Submit</button>
                        <button class="btn btn-light">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


