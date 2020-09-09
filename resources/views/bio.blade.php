@extends('layouts.app')

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
                                    <strong style="text-align: left">Bio</strong>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-outline-success float-right" data-toggle="modal" data-target="#basicExampleModal">
                                        Edit
                                    </button>
                                </div>
                                <div class="card-body">
                                    <h1> @if ($bio != null) {{$bio->content}} @endif </h1>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

                <!-- Modal -->
                <div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Create/Edit Your Bio ..</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="">
                                    <div class="form-group">
                                        <label for="bio" class="col-form-label">Bio:</label>
                                        <textarea id="bio" class="md-textarea form-control" rows="3"></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>

        </div>
    </div>

@endsection

