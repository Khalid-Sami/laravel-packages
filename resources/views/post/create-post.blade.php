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
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong style="text-align: left">Create New Post</strong>
                            </div>
                            <div class="card-body">
                                <form action="{{ url('posts') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <textarea class="form-control" id="body" rows="3" placeholder="What's on your mind?" name="body" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Post</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

