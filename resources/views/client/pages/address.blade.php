@extends('client.master')

@section('title')
    My Addresses
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
            <div class="dashboard_content">
                <!-- Page Header -->
                <div style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                    <div>
                        <h1 style="font-size: 26px; font-weight: 700; color: #1a237e; margin-bottom: 8px;">
                            <i class="fas fa-map-marker-alt" style="margin-right: 10px; color: #16a085;"></i>My Addresses
                        </h1>
                        <p style="color: #7f8c8d; margin: 0;">Manage your delivery addresses</p>
                    </div>
                    <a href="{{ route('client.address.add') }}" style="background: #16a085; color: white; padding: 12px 25px; border-radius: 5px; text-decoration: none; font-weight: 600; transition: all 0.3s;">
                        <i class="fas fa-plus"></i> Add New Address
                    </a>
                </div>

                <!-- Messages -->
                @if (session('success'))
                    <div style="background: #d4edda; border: 1px solid #c3e6cb; border-radius: 8px; padding: 15px; margin-bottom: 20px; color: #155724;">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @elseif(session('error'))
                    <div style="background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 8px; padding: 15px; margin-bottom: 20px; color: #721c24;">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    </div>
                @endif

                <!-- Addresses Grid -->
                <div class="row">
                    @forelse ($addresses as $address)
                        <div class="col-lg-6 col-md-12 mb-4">
                            <div style="background: white; border-radius: 10px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); border-left: 4px solid {{ $address->principalAddress ? '#16a085' : '#3498db' }}; transition: all 0.3s;">
                                <!-- Type Badge -->
                                <div style="margin-bottom: 15px;">
                                    @if($address->principalAddress)
                                        <span style="background: #d4edda; color: #155724; padding: 6px 12px; border-radius: 5px; font-size: 12px; font-weight: 600; display: inline-block; margin-right: 8px;">
                                            <i class="fas fa-star"></i> Primary Address
                                        </span>
                                    @endif
                                    <span style="background: #cfe2ff; color: #084298; padding: 6px 12px; border-radius: 5px; font-size: 12px; font-weight: 600; display: inline-block;">
                                        {{ ucfirst($address->type) }}
                                    </span>
                                </div>

                                <!-- Address Details -->
                                <h5 style="color: #1a237e; font-weight: 700; margin-bottom: 15px;">{{ $address->name }}</h5>

                                <div style="color: #2c3e50; font-size: 14px; line-height: 1.8;">
                                    <p style="margin: 8px 0;">
                                        <strong style="color: #1a237e;">Phone:</strong> {{ $address->phoneNumber }}
                                    </p>
                                    <p style="margin: 8px 0;">
                                        <strong style="color: #1a237e;">Email:</strong> {{ $address->email }}
                                    </p>
                                    <p style="margin: 8px 0;">
                                        <strong style="color: #1a237e;">Address:</strong><br>
                                        {{ $address->address }}
                                    </p>
                                </div>

                                <!-- Actions -->
                                <div style="display: flex; gap: 10px; margin-top: 20px; padding-top: 20px; border-top: 1px solid #e0e0e0;">
                                    <a href="{{ route('client.address.edit', $address->id) }}" style="flex: 1; background: #3498db; color: white; padding: 10px; border-radius: 5px; text-align: center; text-decoration: none; font-weight: 600; transition: all 0.3s;">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('client.address.delete', $address->id) }}" method="POST" style="flex: 1;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this address?')" style="width: 100%; background: #e74c3c; color: white; padding: 10px; border-radius: 5px; border: none; cursor: pointer; font-weight: 600; transition: all 0.3s;">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div style="background: white; border-radius: 10px; padding: 60px 20px; text-align: center;">
                                <i class="fas fa-inbox" style="font-size: 48px; color: #bdc3c7; margin-bottom: 15px; display: block;"></i>
                                <h5 style="color: #7f8c8d; margin-bottom: 10px;">No addresses yet</h5>
                                <p style="color: #95a5a6; margin-bottom: 20px;">Add your first address to get started</p>
                                <a href="{{ route('client.address.add') }}" style="display: inline-block; background: #16a085; color: white; padding: 12px 25px; border-radius: 5px; text-decoration: none; font-weight: 600;">
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
