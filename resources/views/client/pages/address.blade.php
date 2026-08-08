@extends('client.master')

@section('title')
    My Addresses
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
            <div class="dashboard_content">
                <!-- Page Header -->
                <div class="dash-page-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                    <div>
                        <h1><i class="fas fa-map-marker-alt"></i>My Addresses</h1>
                        <p>Manage your delivery addresses</p>
                    </div>
                    <a href="{{ route('client.address.add') }}" class="dash-btn dash-btn-primary">
                        <i class="fas fa-plus"></i> Add New Address
                    </a>
                </div>

                <!-- Messages -->
                @if (session('success'))
                    <div class="dash-alert dash-alert-success">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @elseif(session('error'))
                    <div class="dash-alert dash-alert-error">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    </div>
                @endif

                <!-- Addresses Grid -->
                <div class="row">
                    @forelse ($addresses as $address)
                        <div class="col-lg-6 col-md-12 mb-4">
                            <div class="dash-card" style="padding: 24px; margin-bottom: 0; border-left: 4px solid {{ $address->principalAddress ? '#059669' : '#4f46e5' }};">
                                <!-- Type Badge -->
                                <div style="margin-bottom: 15px;">
                                    @if($address->principalAddress)
                                        <span class="dash-badge dash-badge-success" style="margin-right: 8px;">
                                            <i class="fas fa-star"></i> Primary Address
                                        </span>
                                    @endif
                                    <span class="dash-badge dash-badge-info">
                                        {{ ucfirst($address->type) }}
                                    </span>
                                </div>

                                <!-- Address Details -->
                                <h5 style="color: var(--dash-ink); font-weight: 700; margin-bottom: 15px;">{{ $address->name }}</h5>

                                <div style="color: var(--dash-ink); font-size: 14px; line-height: 1.8;">
                                    <p style="margin: 8px 0;">
                                        <strong style="color: var(--dash-primary);">Phone:</strong> {{ $address->phoneNumber }}
                                    </p>
                                    <p style="margin: 8px 0;">
                                        <strong style="color: var(--dash-primary);">Email:</strong> {{ $address->email }}
                                    </p>
                                    <p style="margin: 8px 0;">
                                        <strong style="color: var(--dash-primary);">Address:</strong><br>
                                        {{ $address->address }}
                                    </p>
                                </div>

                                <!-- Actions -->
                                <div style="display: flex; gap: 10px; margin-top: 20px; padding-top: 20px; border-top: 1px solid #f1f5f9;">
                                    <a href="{{ route('client.address.edit', $address->id) }}" class="dash-btn dash-btn-primary" style="flex: 1;">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('client.address.delete', $address->id) }}" method="POST" style="flex: 1;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this address?')" class="dash-btn dash-btn-danger dash-btn-block">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="dash-empty dash-card" style="margin-bottom: 0;">
                                <i class="fas fa-inbox"></i>
                                <h5>No addresses yet</h5>
                                <p style="color: var(--dash-muted); margin-bottom: 20px;">Add your first address to get started</p>
                                <a href="{{ route('client.address.add') }}" class="dash-btn dash-btn-primary">
                                    <i class="fas fa-plus"></i> Add New Address
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
