@extends('client.master')

@section('title')
    My Reviews
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
            <div class="dashboard_content">
                <!-- Page Header -->
                <div class="dash-page-header">
                    <h1><i class="fas fa-star" style="color: #f59e0b;"></i>My Reviews</h1>
                    <p>View and manage your product reviews</p>
                </div>

                @if ($reviews->count() > 0)
                    <div class="row">
                        @foreach ($reviews as $review)
                            <div class="col-lg-6 mb-4">
                                <div class="dash-card" style="padding: 0; overflow: hidden; margin-bottom: 0;">
                                    <!-- Product Image -->
                                    <div style="height: 200px; overflow: hidden; background: #f8f7ff;">
                                        <img src="{{ asset('storage/products_images/' . $review->product->id . '/' . $review->product->principalImage) }}"
                                            alt="product" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>

                                    <!-- Review Content -->
                                    <div style="padding: 20px;">
                                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                                            <h5 style="margin: 0; color: var(--dash-ink); font-weight: 600; font-size: 16px;">
                                                {{ $review->product->name ?? 'Product Deleted' }}
                                            </h5>
                                            <span style="color: var(--dash-muted); font-size: 12px;">{{ $review->created_at->format('d M Y') }}</span>
                                        </div>

                                        <!-- Rating -->
                                        <div style="margin-bottom: 12px;">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $review->rate)
                                                    <i class="fas fa-star" style="color: #f59e0b; font-size: 14px;"></i>
                                                @else
                                                    <i class="far fa-star" style="color: #cbd5e1; font-size: 14px;"></i>
                                                @endif
                                            @endfor
                                            <span style="margin-left: 8px; color: var(--dash-muted); font-size: 13px;">{{ $review->rate }}/5</span>
                                        </div>

                                        <!-- Review Text -->
                                        <p style="color: var(--dash-ink); font-size: 14px; margin-bottom: 16px; line-height: 1.6;">
                                            {{ $review->content }}
                                        </p>

                                        <!-- Actions -->
                                        <div style="display: flex; gap: 10px; border-top: 1px solid #f1f5f9; padding-top: 16px;">
                                            <button type="button" class="edit-review-btn dash-btn dash-btn-primary" data-review-id="{{ $review->id }}" style="flex: 1;">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button type="button" class="delete-review-btn dash-btn dash-btn-danger" data-review-id="{{ $review->id }}" style="flex: 1;">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </div>

                                        <!-- Edit Form (Hidden) -->
                                        <div id="editForm-{{ $review->id }}" style="display: none; margin-top: 16px; padding-top: 16px; border-top: 1px solid #f1f5f9;">
                                            <form action="{{ route('client.review.update', $review->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div style="margin-bottom: 12px;">
                                                    <label class="dash-label" style="font-size: 13px;">Rating</label>
                                                    <div style="display: flex; gap: 8px;">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <label style="cursor: pointer;">
                                                                <input type="radio" name="rate" value="{{ $i }}" {{ $review->rate == $i ? 'checked' : '' }} style="margin-right: 4px;">
                                                                <span style="color: #f59e0b; font-size: 16px;"><i class="fas fa-star"></i></span>
                                                            </label>
                                                        @endfor
                                                    </div>
                                                </div>

                                                <div style="margin-bottom: 12px;">
                                                    <label class="dash-label" style="font-size: 13px;">Your Review</label>
                                                    <textarea name="content" class="dash-textarea" rows="4">{{ $review->content }}</textarea>
                                                </div>

                                                <div style="display: flex; gap: 10px;">
                                                    <button type="submit" class="dash-btn dash-btn-primary" style="flex: 1;">Save Changes</button>
                                                    <button type="button" class="cancel-edit-btn dash-btn dash-btn-outline" data-review-id="{{ $review->id }}" style="flex: 1;">Cancel</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Form -->
                            <form id="delete-review-{{ $review->id }}"
                                action="{{ route('client.review.delete', $review->id) }}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endforeach
                    </div>
                @else
                    <div class="dash-empty dash-card">
                        <i class="fas fa-comments"></i>
                        <h5>No reviews yet</h5>
                        <p style="color: var(--dash-muted);">Start reviewing products to see them here.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.edit-review-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const reviewId = this.dataset.reviewId;
                document.getElementById('editForm-' + reviewId).style.display = 'block';
            });
        });

        document.querySelectorAll('.cancel-edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const reviewId = this.dataset.reviewId;
                document.getElementById('editForm-' + reviewId).style.display = 'none';
            });
        });

        document.querySelectorAll('.delete-review-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                if(confirm('Are you sure you want to delete this review?')) {
                    const reviewId = this.dataset.reviewId;
                    document.getElementById('delete-review-' + reviewId).submit();
                }
            });
        });
    </script>
@endsection
