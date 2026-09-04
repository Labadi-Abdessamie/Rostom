@extends('admin.master')

@section('title', 'Admin || Variant Types')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Variant Types</h4>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.variant_type_create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Type
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Display Name</th>
                                        <th>Type</th>
                                        <th>Required</th>
                                        <th>Options</th>
                                        <th>Position</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($variantTypes as $vt)
                                        <tr>
                                            <td>{{ $vt->id }}</td>
                                            <td><strong>{{ $vt->name }}</strong></td>
                                            <td>{{ $vt->display_name }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ $vt->type }}</span>
                                            </td>
                                            <td>
                                                @if($vt->required)
                                                    <span class="badge bg-success">Yes</span>
                                                @else
                                                    <span class="badge bg-secondary">No</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($vt->options && count($vt->options) > 0)
                                                    <span class="text-muted small">
                                                        {{ implode(', ', array_slice($vt->options, 0, 3)) }}
                                                        @if(count($vt->options) > 3)
                                                            ...
                                                        @endif
                                                    </span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>{{ $vt->position }}</td>
                                            <td>
                                                <a href="{{ route('admin.variant_type_edit', $vt->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.variant_type_destroy', $vt->id) }}" method="POST" class="d-inline"
                                                    onsubmit="return confirm('Delete this variant type?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">No variant types yet.
                                                <a href="{{ route('admin.variant_type_create') }}">Create one</a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
