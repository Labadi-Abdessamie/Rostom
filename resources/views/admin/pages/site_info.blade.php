@extends('admin.master')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title">Site Statistics</h4>
            <a href="{{ route('admin.site_info.create') }}" class="btn btn-primary btn-sm">
                <i class="mdi mdi-plus"></i> Add Statistic
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
                                    <th>Order</th>
                                    <th>Key</th>
                                    <th>Value</th>
                                    <th>Label</th>
                                    <th>Icon</th>
                                    <th>Visible</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($infos as $info)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $info->sort_order }}</td>
                                        <td><code>{{ $info->key }}</code></td>
                                        <td><strong>{{ $info->value }}</strong></td>
                                        <td>{{ $info->label }}</td>
                                        <td>
                                            @if($info->icon)
                                                <i class="{{ $info->icon }}"></i>
                                                <small class="text-muted d-block">{{ $info->icon }}</small>
                                            @else — @endif
                                        </td>
                                        <td>
                                            @if($info->is_visible)
                                                <span class="badge bg-success">Yes</span>
                                            @else
                                                <span class="badge bg-secondary">No</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.site_info.edit', $info->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="mdi mdi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.site_info.destroy', $info->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this statistic?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                    <i class="mdi mdi-delete"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">
                                            No statistics found. <a href="{{ route('admin.site_info.create') }}">Add one</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $infos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
