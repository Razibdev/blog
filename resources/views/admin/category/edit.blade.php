@extends('layouts.backend.app')

@section('title', 'Category')

@push('css')

@endpush

@section('content')
<div class="container-fluid">
    
    <!-- Vertical Layout | With Floating Label -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Edit Category
                    </h2>
                    
                </div>
                <div class="body">
                    <form action="{{route('admin.category.update', $category->id)}}" method="POST" enctype="multipart/form-data"> @csrf
                        @method('PUT')
                        <div class="form-group form-float">
                            <div class="form-line">
                            <input type="text" id="name" class="form-control" name="name" value="{{$category->name}}">
                                <label class="form-label">Category Name</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="file" name="image" id="image" class="form-control">
                        </div>

                        <a href="{{route('admin.category.index')}}" class="btn btn-warning m-t-15 waves-effect">Back</a>
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Vertical Layout | With Floating Label -->
</div>
@endsection


@push('js')
<script src="{{asset('assets/backend/js/admin.js')}}"></script>
@endpush