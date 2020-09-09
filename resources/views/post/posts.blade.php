@extends('layouts.app')

@section('styles')
    <style>

    </style>
@endsection
@section('content')

    <div class="container">
        <div class="col-md-10">

            @if(session('msg'))
                <div class="alert alert-success" role="alert">
                    {{ session('msg') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6 float-right">
                            <a class="btn btn-outline-success" href="{{ url('/posts/create') }}">new post</a>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    @foreach($posts as $post)
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="alert alert-success post-container">
                                    <div class="panel-body">
                                        <div class="post-body">
                                            <b>{{ $post->body }}</b>
                                        </div>
                                        <br>
                                        <div class="post-methods">
                                            <a href="#" data-toggle="modal" data-target="#editPostModal"
                                               data-id="{{ $post->id }}">Edit</a>
                                            <a href="#" id="delete-post" data-id="{{ $post->id }}">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Modal -->
                <div class="modal fade" id="editPostModal" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Post ..</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="" id="edit-post-form">
                                    @method('PUT')
                                    @csrf
                                    <div class="form-group">
                                        <textarea id="edit-post-body" class="md-textarea form-control" rows="3" name="edit-post-body"></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="edit-post-btn">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('scripts')
    <script>
        var postID;
        $(document).ready(function () {
            $('#editPostModal').on('show.bs.modal', function (event) {
                var link = $(event.relatedTarget)
                postID = link.data('id')
                var body = link.closest('.post-container').find('.post-body').find('b').text()
                $('#edit-post-body').val(body)
            })

            $('#edit-post-btn').on('click', function () {
                var url = '{{ route('posts.update', ':post') }}'
                url = url.replace(':post', postID);
                $('#edit-post-form').attr('action', url).submit()
            })

            $(document).on('click', '#delete-post', function(e) {
                e.preventDefault()
                var id = $(this).data('id')
                var url = '{{ route('posts.destroy', ':post') }}'
                url = url.replace(':post',id)
                $.ajax({
                    url:  url,
                    type: 'DELETE',  // post.destroy
                    data: {'_token': '{{ csrf_token() }}'},
                    success: function(result) {
                        // console.log(result['msg'])
                        location.reload()
                    }
                });
            });
            
        })
    </script>
@endsection
