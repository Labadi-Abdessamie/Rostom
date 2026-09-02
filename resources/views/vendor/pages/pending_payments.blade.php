@extends('vendor.master')

@section('title', 'Vendor | Pending Payments')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Pending Payment Confirmations</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('vendor.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Pending Payments</div>
        </div>
    </div>

    <div class="section-body">
        {{-- Summary card --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-warning d-flex align-items-center gap-3 mb-0" style="border-radius:14px;">
                    <i class="fas fa-clock fa-2x"></i>
                    <div>
                        <strong>Total Pending:</strong>
                        <span class="ms-2 fs-5 fw-bold">{{ number_format($totalPending) }} DZD</span>
                        <span class="text-muted ms-2">({{ $orders->count() }} order{{ $orders->count() === 1 ? '' : 's' }} waiting)</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive" style="overflow-x:auto;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer</th>
                                        <th>Date</th>
                                        <th>Items</th>
                                        <th>Your Earnings (DZD)</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                        @php
                                            $client = $order->user;
                                            $vendorMagasinId = Auth::user()->magasin ? Auth::user()->magasin->id : null;
                                            $vendorItems = $vendorMagasinId ? $order->orderItems->filter(fn($item) => $item->product->magasin_id === $vendorMagasinId) : collect();
                                            $vendorTotal = $vendorItems->sum(fn($item) => $item->product->price * $item->quantity);
                                        @endphp
                                        <tr>
                                            <td class="text-muted">#{{ $order->id }}</td>
                                            <td>
                                                <a href="javascript:void(0);" onclick="openClientModal({{ $client->id ?? $order->id }}); return false;" style="font-weight:600;">
                                                    {{ $order->user->name ?? 'N/A' }}
                                                    <i class="fas fa-user-circle text-info ms-1"></i>
                                                </a>
                                            </td>
                                            <td>{{ $order->created_at->format('d M Y') }}</td>
                                            <td>
                                                @foreach($vendorItems as $item)
                                                    <span class="badge bg-light text-dark me-1">{{ $item->product->name ?? 'Product' }} ({{ $item->quantity }})</span>
                                                @endforeach
                                            </td>
                                            <td class="fw-bold">{{ number_format($vendorTotal) }}</td>
                                            <td>
                                                <span class="badge badge-warning">Delivered</span>
                                                <span class="badge badge-secondary">Payment Pending</span>
                                            </td>
                                            <td>
                                                @if($vendorTotal > 0)
                                                    <form action="{{ route('vendor.order.confirm_payment', $order->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Confirm receipt of payment for this order?')">
                                                            <i class="fas fa-check me-1"></i> Confirm Payment
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-muted"><i class="fas fa-minus-circle me-1"></i> No items</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">
                                                <i class="fas fa-check-circle fa-2x mb-2 d-block opacity-50"></i>
                                                No pending payments — you're all caught up!
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

        {{-- Client Info Modals --}}
        @forelse($orders as $order)
            @php $client = $order->user; @endphp
            <div class="custom-modal" id="clientModal{{ $client->id ?? $order->id }}" style="display:none; position:fixed; inset:0; z-index:9999; align-items:center; justify-content:center;">
                <div class="custom-modal-backdrop" onclick="closeAllClientModals()" style="position:fixed; inset:0; background:rgba(0,0,0,.5); z-index:9998; pointer-events:auto;"></div>
                <div style="position:relative; z-index:9999; background:#fff; border-radius:16px; width:100%; max-width:380px; box-shadow:0 20px 60px rgba(0,0,0,.25); overflow:hidden; pointer-events:auto;">
                    <div style="background:linear-gradient(135deg,#6366f1,#8b5cf6); padding:18px 20px; display:flex; align-items:center; justify-content:space-between;">
                        <h5 style="margin:0; color:#fff; font-size:1rem;">Customer Info</h5>
                        <button onclick="closeAllClientModals()" style="background:none; border:none; color:#fff; font-size:1.4rem; cursor:pointer; line-height:1; opacity:.9;">&times;</button>
                    </div>
                    <div style="padding:24px;">
                        <div style="text-align:center; margin-bottom:18px;">
                            <i class="fas fa-user-circle" style="font-size:3.5rem; color:#6366f1; opacity:.8;"></i>
                        </div>
                        <h5 style="text-align:center; margin-bottom:4px;">{{ $client->name ?? 'N/A' }}</h5>
                        <p style="text-align:center; color:#64748b; margin-bottom:16px; font-size:.85rem;">Order #{{ $order->id }}</p>
                        <hr style="margin:14px 0;">
                        <div style="margin-bottom:12px;">
                            <small style="color:#94a3b8; font-size:.75rem; text-transform:uppercase; letter-spacing:.05em;">Email</small><br>
                            <strong style="font-size:.9rem;">{{ $client->email ?? '—' }}</strong>
                        </div>
                        <div style="margin-bottom:12px;">
                            <small style="color:#94a3b8; font-size:.75rem; text-transform:uppercase; letter-spacing:.05em;">Phone</small><br>
                            <strong style="font-size:.9rem;">{{ $client->phoneNumber ?? ($order->shippingAddress->phoneNumber ?? '—') }}</strong>
                        </div>
                        <div>
                            <small style="color:#94a3b8; font-size:.75rem; text-transform:uppercase; letter-spacing:.05em;">Address</small><br>
                            <strong style="font-size:.9rem;">{{ $order->shippingAddress->address ?? '—' }}</strong>
                        </div>
                        <div style="margin-top:20px; text-align:center;">
                            <button onclick="closeAllClientModals()" class="btn btn-outline-secondary btn-sm">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
        @endforelse

        <script>
        function openClientModal(id) {
            document.querySelectorAll('.custom-modal').forEach(function(m) { m.style.display = 'none'; });
            var modal = document.getElementById('clientModal' + id);
            if (modal) { modal.style.display = 'flex'; }
        }
        function closeAllClientModals() {
            document.querySelectorAll('.custom-modal').forEach(function(m) { m.style.display = 'none'; });
        }
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeAllClientModals();
        });
        </script>
    </section>
@endsection
