@extends('client.master')

@section('title')
    Dashboard || Add Address
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="dashboard_content mt-2 mt-md-0">
                <h3><i class="fal fa-gift-card"></i> Create Address</h3>
                <div class="wsus__dashboard_add wsus__add_address">
                    <form method="POST" action="{{ route('client.address.store') }}">
                        @csrf
                        <div class="row">
                            <!-- Name -->
                            <div class="col-xl-6 col-md-6">
                                <div class="wsus__add_address_single">
                                    <label>Name <b>*</b></label>
                                    <input type="text" name="name" placeholder="Name" value="{{ old('name') }}"
                                        required>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-xl-6 col-md-6">
                                <div class="wsus__add_address_single">
                                    <label>Email</label>
                                    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}"
                                        required>
                                </div>
                            </div>

                            <!-- Phone Number -->
                            <div class="col-xl-6 col-md-6">
                                <div class="wsus__add_address_single">
                                    <label>Phone <b>*</b></label>
                                    <input type="text" name="phoneNumber" placeholder="Phone"
                                        value="{{ old('phoneNumber') }}" maxlength="10" required>
                                </div>
                            </div>

                            <!-- Address Type (must match ENUM: billing, shipping) -->
                            <div class="col-xl-6 col-md-6">
                                <div class="wsus__add_address_single">
                                    <label for="addressType">Address Type <b>*</b></label>
                                    <select id="addressType" name="type" class="form-select" required>
                                        <option value="" disabled selected>Select Address Type</option>
                                        <option value="shipping" {{ old('type') == 'shipping' ? 'selected' : '' }}>Shipping
                                        </option>
                                        <option value="billing" {{ old('type') == 'billing' ? 'selected' : '' }}>Billing
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="col-xl-12">
                                <div class="wsus__add_address_single">
                                    <label>Address <b>*</b></label>
                                    <textarea name="address" rows="4" placeholder="Full Address" required>{{ old('address') }}</textarea>
                                </div>
                            </div>

                            <!-- Principal Address -->
                            <div class="col-xl-12">
                                <div class="wsus__add_address_single">
                                    <label>
                                        <input type="checkbox" name="principalAddress" value="1"
                                            {{ old('principalAddress') ? 'checked' : '' }}>
                                        Set as primary address
                                    </label>
                                </div>
                            </div>

                            <!-- Submit -->
                            <div class="col-xl-6">
                                <button type="submit" class="common_btn">Save Address</button>
                            </div>
                        </div>
                    </form>

                    <!-- Show validation errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger mt-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Flash messages -->
                    @if (session('success'))
                        <div class="alert alert-success mt-3">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger mt-3">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
