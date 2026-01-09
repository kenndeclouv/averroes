@extends('layouts.app')

@section('title', 'Edit Admin')

@section('page-script')
    <script>
        $('.select2').select2();
    </script>
@endsection

@section('content')
    <form action="{{ route('superadmin.admin.update', $admin->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="container-xxl flex-grow-1 container-p-y">
            <h5 class="fw-bold py-3 mb-4">
                <span class="text-muted fw-light"><a href="{{ route('superadmin.admin.index') }}">Daftar Admin</a> /
                </span>
                Edit Admin
            </h5>
            <div class="row">
                <div class="col-xxl">
                    <div class="card mb-4">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">Admin</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="roles">Role</label>
                                <select class="form-select select2 @error('roles') is-invalid @enderror" id="roles"
                                    name="roles[]" multiple required>
                                    @foreach ($adminRoles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ in_array($role->id, old('roles', $admin->roles->pluck('id')->toArray())) ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @errorFeedback('roles')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="name">Nama</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $admin->name) }}" required>
                                @errorFeedback('name')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="username">Username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                    id="username" name="username" value="{{ old('username', $admin->username) }}" required>
                                @errorFeedback('username')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email', $admin->email) }}" required>
                                @errorFeedback('email')
                            </div>
                            <button type="submit" class="btn btn-warning">Edit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
