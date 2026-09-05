@extends('admin.master')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title">Team Members</h4>
            <a href="{{ route('admin.team_members.create') }}" class="btn btn-primary btn-sm">
                <i class="mdi mdi-plus"></i> Add Member
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover table-bordered dt-responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Photo</th>
                                    <th>Name / Role</th>
                                    <th>Department</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($members as $m)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if($m->image)
                                                <img src="{{ asset('storage/' . $m->image) }}" alt="{{ $m->name }}" width="50" height="50" style="object-fit:cover; border-radius:6px;">
                                            @else
                                                <img src="{{ asset('frontend/images/No_Image.png') }}" alt="{{ $m->name }}" width="50" height="50" style="object-fit:cover; border-radius:6px;">
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $m->name }}</strong><br>
                                            <small class="text-muted">{{ $m->role }}</small>
                                        </td>
                                        <td>
                                            @foreach($m->allDepartments as $d)
                                                <span class="badge bg-info me-1">{{ $d }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if($m->status)
                                                <span class="badge bg-success">Visible</span>
                                            @else
                                                <span class="badge bg-secondary">Hidden</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.team_members.edit', $m->id) }}" class="btn btn-sm btn-warning" title="Edit"><i class="mdi mdi-pencil"></i></a>
                                            <form action="{{ route('admin.team_members.destroy', $m->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this member?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="mdi mdi-delete"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center text-muted py-4">No members. <a href="{{ route('admin.team_members.create') }}">Add one</a></td></tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $members->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
