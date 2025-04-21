@extends('client.master')

@section('title')
    Dashboard || Address
@endsection

@section('content')
<div class="row">
    <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
        <div class="dashboard_content">
            <h3><i class="fal fa-gift-card"></i> Address</h3>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @elseif(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="wsus__dashboard_add">
                <div class="row">
                    @foreach($addresses as $address)
                        <div class="col-xl-6">
                            <div class="wsus__dash_add_single">
                                <h4>Address <span>{{ $address->type }}</span></h4>
                                <ul>
                                    <li><span>Name:</span> {{ $address->name }}</li>
                                    <li><span>Phone:</span> {{ $address->phoneNumber }}</li>
                                    <li><span>Email:</span> {{ $address->email }}</li>
                                    <li><span>Address Type:</span> {{ $address->type }}</li>
                                    <li><span>Address:</span> {{ $address->address }}</li>
                                    <li><span>Principal Address:</span> {{ $address->principalAddress ? 'Yes' : 'No' }}</li>
                                </ul>
                                <div class="wsus__address_btn">
                                    <a href="{{ route('client.address.edit', $address->id) }}" class="edit">
                                        <i class="fal fa-edit"></i> Edit
                                    </a>
                                        <form action="{{ route('client.address.delete', $address->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="del btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this address?')">
                                                <i class="fal fa-trash-alt"></i> Delete
                                            </button>
                                        </form>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="col-12">
                        <a href="{{ route('client.address.add') }}" class="add_address_btn common_btn">
                            <i class="far fa-plus"></i> Add New Address
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
