@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Admin list</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Admin list</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="container">
        <div class="row">
            <div class="col-md-10">&nbsp;</div>
            <div class="col-md-2">
                <a class="form-control btn btn-success" href="{{ route('admin/admins.create') }}">Create</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('admin/admins.index') }}" method="GET">
                    <div class="row form-group">
                        <div class="col-md-4">
                            <label> Name</label>
                            <input class="form-control" type="text" name="name" placeholder="Enter name"
                                   value="{{ $query['name'] ?? '' }}">
                        </div>
                        <div class="col-md-4">
                            <label>Email</label>
                            <input class="form-control" type="text" name="email" placeholder="Enter email"
                                   value="{{ $query['email'] ?? '' }}">
                        </div>
                        <div class="col-md-2">
                            <label>Status</label>
                            <select name="active" class="form-control">
                                <option value="">&mdash;</option>
                                <option value="0"
                                        @if(isset($query['active']) && $query['active'] == 0)selected="selected" @endif>
                                    Disabled
                                </option>
                                <option value="1"
                                        @if(isset($query['active']) && $query['active'] == 1)selected="selected" @endif>
                                    Active
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>&nbsp;</label>
                            <button type="submit" class="form-control btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Created</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($admins as $admin)
                                <tr>
                                    <th>
                                        <a href="{{ route('admin/admins.edit', $admin->id) }}" class="btn btn-xs text-muted">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                        @if($admin->id !== Auth::id())
                                            <form action="{{ route('admin/admins.destroy', $admin->id) }}"
                                                  method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn text-muted btn-xs">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </th>
                                    <td>{{ $admin->id }}</td>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>
                                        @if($admin->active)
                                            <div class="text-center bg-success">Active</div>
                                        @else
                                            <div class="text-center bg-danger">Disabled</div>
                                        @endif
                                    </td>
                                    <td>{{ $admin->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                {{ $admins->render('admin/components.pagination') }}
                <!-- /.card -->
            </div>
        </div>
    </div>
@endsection
