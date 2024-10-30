@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit admin</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin/admins.index') }}">Admin list</a></li>
                        <li class="breadcrumb-item active">Edit admin</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Creating admin</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="POST" action="{{ route('admin/admins.update', $admin->id) }}">
                        @method('patch')
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>Active status</label>
                                <input type="checkbox"
                                       class="switch"

                                       data-toggle="toggle"
                                       data-onstyle="success"
                                       name="active">
                            </div>
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" placeholder="Enter name" name="name"
                                       value="{{ $admin->name }}">
                            </div>
                            <div class="form-group">
                                <label>Email address</label>
                                <input type="email" class="form-control" placeholder="Enter email" name="email"
                                       value="{{ $admin->email }}">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" placeholder="Password" name="password"
                                       value="{{ old('password') }}">
                            </div>
                            @include('admin/components.images')
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            @if($admin->active)
            $(".switch").bootstrapSwitch('state', true);
            @else
            $(".switch").bootstrapSwitch('state', false);
            @endif
            @if(Auth::id() == $admin->id)
            $(".switch").bootstrapSwitch('disabled', true);
            @endif
        });
    </script>
@endpush
