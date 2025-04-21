@extends('client.master')

@section('title')
    Edit Address
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <h3>Edit Address</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('client.address.update', $address->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name', $address->name) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Phone Number</label>
                <input type="text" name="phoneNumber" value="{{ old('phoneNumber', $address->phoneNumber) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $address->email) }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Type</label>
                <input type="text" name="type" value="{{ old('type', $address->type) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Address</label>
                <textarea name="address" class="form-control" required>{{ old('address', $address->address) }}</textarea>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="principalAddress" value="1" class="form-check-input" id="principalAddress"
                    {{ old('principalAddress', $address->principalAddress) ? 'checked' : '' }}>
                <label class="form-check-label" for="principalAddress">Principal Address</label>
            </div>

            <button type="submit" class="btn btn-success">Save Changes</button>
        </form>
    </div>
</div>
@endsection
