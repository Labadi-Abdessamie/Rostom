@extends('vendor.master')

@section('title', 'Vendor | Products')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('vendor/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .listing-tabs {
            display: inline-flex;
            background: #f4f6fb;
            border-radius: 10px;
            padding: 4px;
            gap: 4px;
        }
        .listing-tabs a {
            padding: 8px 18px;
            border-radius: 8px;
            color: #475569;
            font-weight: 600;
            font-size: .85rem;
            text-decoration: none;
            transition: background .2s, color .2s;
        }
        .listing-tabs a.active {
            background: #fff;
            color: #4f46e5;
            box-shadow: 0 2px 6px rgba(0,0,0,.05);
        }
        .listing-tabs a .badge-pill {
            margin-left: 6px;
            background: #e2e8f0;
            color: #475569;
            padding: 2px 8px;
            font-size: .7rem;
        }
        .listing-tabs a.active .badge-pill {
            background: #4f46e5;
            color: #fff;
        }
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: .7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .04em;
        }
        .status-pill.listed {
            background: #dcfce7;
            color: #166534;
        }
        .status-pill.unlisted {
            background: #fef3c7;
            color: #92400e;
        }
        .toggle-listing-btn {
            border: none;
            background: #f1f5f9;
            color: #475569;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: .75rem;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s, color .2s;
        }
        .toggle-listing-btn:hover { background: #e2e8f0; }
        .toggle-listing-btn.is-listed { background: #dcfce7; color: #166534; }
        .toggle-listing-btn.is-listed:hover { background: #bbf7d0; }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('vendor/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('vendor/modules/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('vendor/js/page/modules-datatables.js') }}"></script>

    <script>
        // Toggle listing status
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.toggle-listing-btn');
            if (!btn) return;
            e.preventDefault();

            const url = btn.dataset.url;
            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    // Update the button
                    btn.classList.toggle('is-listed', data.is_listed);
                    btn.innerHTML = data.is_listed
                        ? '<i class="fas fa-toggle-on"></i> Listed'
                        : '<i class="fas fa-toggle-off"></i> Unlisted';

                    // Update the status pill in the same row
                    const row = btn.closest('tr');
                    const pill = row.querySelector('.status-pill');
                    if (pill) {
                        pill.classList.toggle('listed', data.is_listed);
                        pill.classList.toggle('unlisted', !data.is_listed);
                        pill.innerHTML = data.is_listed
                            ? '<i class="fas fa-circle" style="font-size:.5rem"></i> Listed'
                            : '<i class="fas fa-circle" style="font-size:.5rem"></i> Unlisted';
                    }

                    // Update tab counts without full reload
                    location.reload();
                } else {
                    alert('Failed to update listing status.');
                    location.reload();
                }
            })
            .catch(() => {
                alert('Error updating listing status.');
                location.reload();
            });
        });
    </script>
@endsection

@section('content')
    @php
        $filter = request('filter', 'all');
        $listedCount = $products->where('is_listed', true)->count();
        $unlistedCount = $products->where('is_listed', false)->count();
    @endphp

    <section class="section">
        <div class="section-header">
            <h1>Products</h1>
            <div class="section-header-button">
                <a href="{{ route('vendor.add_product') }}" class="btn btn-primary">Add New</a>
            </div>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('vendor.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Products</div>
            </div>
        </div>


        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="background:#fff; border-bottom:1px solid #f1f5f9;">
                            <div class="listing-tabs">
                                <a href="{{ route('vendor.products', ['filter' => 'all']) }}"
                                    class="{{ $filter === 'all' ? 'active' : '' }}">
                                    All <span class="badge-pill">{{ $products->count() }}</span>
                                </a>
                                <a href="{{ route('vendor.products', ['filter' => 'listed']) }}"
                                    class="{{ $filter === 'listed' ? 'active' : '' }}">
                                    Listed <span class="badge-pill">{{ $listedCount }}</span>
                                </a>
                                <a href="{{ route('vendor.products', ['filter' => 'unlisted']) }}"
                                    class="{{ $filter === 'unlisted' ? 'active' : '' }}">
                                    Unlisted <span class="badge-pill">{{ $unlistedCount }}</span>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="overflow-x:auto;">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ID</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Status</th>
                                            <th>Average Rate</th>
                                            <th>Ordered Times</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($products->when($filter === 'listed', fn($q) => $q->where('is_listed', true))->when($filter === 'unlisted', fn($q) => $q->where('is_listed', false)) as $product)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                {{-- Enumeration --}}
                                                <td class="text-center">
                                                    @if ($product->principalImage)
                                                        <img src="{{ asset('storage/products_images/' . $product->id . '/' . $product->principalImage) }}"
                                                            alt="Product Image" width="50" height="50"
                                                            style="object-fit: cover;">
                                                    @else
                                                        <span class="text-muted">No Image</span>
                                                    @endif
                                                </td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ number_format($product->price, 2) }}</td>
                                                <td class="text-center">
                                                    {{ $product->actual_quantity ?? 0 }}</td>
                                                <td class="text-center">
                                                    @if ($product->is_listed)
                                                        <span class="status-pill listed">
                                                            <i class="fas fa-circle" style="font-size:.5rem"></i> Listed
                                                        </span>
                                                    @else
                                                        <span class="status-pill unlisted">
                                                            <i class="fas fa-circle" style="font-size:.5rem"></i> Unlisted
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if ($product->rate_average)
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= round($product->rate_average))
                                                                <i class="fas fa-star text-warning"></i>
                                                            @else
                                                                <i class="far fa-star text-warning"></i>
                                                            @endif
                                                        @endfor
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                    / {{ $product->rate_count ?? 0 }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $product->order_items_sum_quantity ?? 0 }}
                                                </td>
                                                <td class="text-center">
                                                    <button type="button"
                                                        class="toggle-listing-btn {{ $product->is_listed ? 'is-listed' : '' }}"
                                                        data-url="{{ route('vendor.toggle_product_listing', $product->id) }}"
                                                        title="Toggle listing">
                                                        @if ($product->is_listed)
                                                            <i class="fas fa-toggle-on"></i> Listed
                                                        @else
                                                            <i class="fas fa-toggle-off"></i> Unlisted
                                                        @endif
                                                    </button>

                                                    <a href="{{ route('frontend.product_details', $product->id) }}"
                                                        class="btn btn-info btn-sm mr-2" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    <a href="{{ route('vendor.edit_product', $product->id) }}"
                                                        class="btn btn-primary btn-sm mr-2" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <form action="{{ route('vendor.delete_product', $product->id) }}"
                                                        method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Are you sure you want to delete this product?')"
                                                            title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center text-muted">
                                                    No products found.
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
    </section>
@endsection
