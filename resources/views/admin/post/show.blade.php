@extends('layouts.backend.app')

@section('title', 'Post')

@push('css')
<!-- Multi Select Css -->
{{-- <link href="{{asset('assets/backend/plugins/multi-select/css/multi-select.css')}}" rel="stylesheet"> --}}
<!-- Bootstrap Select Css -->
<link href="{{asset('assets/backend/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />

<style>
    .bootstrap-select.btn-group .dropdown-menu li {
    position: relative;
    left: 20px;
    width: 328px;
}
</style>

@endpush

@section('content')
<div class="container-fluid">
<a href="{{route('admin.post.index')}}" class="btn btn-warning waves-effect"> Back</a>

@if ($post->is_approved == false)
    <button type="button" class="btn btn-success pull-right waves-effect" onclick="approvalpost({{$post->id}});">
        <i class="material-icons"> done</i>
        <span>Approve</span>
    </button>
<form action="{{route('admin.post.approve', $post->id)}}" method="POST" id="approval-form" style="display: none;"> @csrf @method('PUT')
        
    </form>
@else
    <button type="button" class="btn btn-success pull-right" disabled>
        <i class="material-icons"> done</i>
        <span>Approved</span>
    </button>
@endif
<br><br>
    <!-- Vertical Layout | With Floating Label -->
    <div class="row clearfix">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        {{$post->title}}
                        <small>Posted By: <strong><a href="#">{{$post->user->name}}</a></strong> on {{$post->created_at->toFormattedDateString()}}</small>
                    </h2>
                    
                </div>
                <div class="body">
                    {!! $post->body !!}
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="card">
                <div class="header bg-cyan">
                    <h2>
                       Categories
                    </h2>
                    
                </div>
                <div class="body">
                    
                       @foreach ($post->categories as $category)
                        <span class="label bg-cyan">{{$category->name}}</span>
                       @endforeach
                   
                </div>
            </div>


            <div class="card">
                <div class="header bg-green">
                    <h2>
                       Tags
                    </h2>
                    
                </div>
                <div class="body">
                    
                       @foreach ($post->tags as $tag)
                        <span class="label bg-green">{{$tag->name}}</span>
                       @endforeach
                   
                </div>
            </div>


            <div class="card">
                <div class="header bg-amber">
                    <h2>
                       Featured Image 
                    </h2>
                    
                </div>
                <div class="body">
                    
                    <img class="img-responsive thumbnail" src="{{url('storage/post/'.$post->image)}}" alt="">
                   
                </div>
            </div>
        </div>
    </div>

</div>
@endsection


@push('js')

<!-- Select Plugin Js -->
<script src="{{asset('assets/backend/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>
 <!-- Multi Select Plugin Js -->
 {{-- <script src="{{asset('assets/backend/plugins/multi-select/js/jquery.multi-select.js')}}"></script> --}}

<!-- TinyMCE --><script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script type="text/javascript">
        function approvalpost(id){
            const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You went to approve this post!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Approve it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
            }).then((result) => {
            if (result.value) {
               event.preventDefault();
               document.getElementById('approval-form').submit();
               swalWithBootstrapButtons.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
                )
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                'Cancelled',
                'The Post remain pending :)',
                'info'
                )
            }
            })
        }
    </script>
@endpush