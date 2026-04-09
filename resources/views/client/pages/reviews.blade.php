@extends('client.master')

@section('title')
    My Reviews
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
            <div class="dashboard_content">
                <!-- Page Header -->
                <div style="margin-bottom: 30px;">
                    <h1 style="font-size: 26px; font-weight: 700; color: #1a237e; margin-bottom: 8px;">
                        <i class="fas fa-star" style="margin-right: 10px; color: #f39c12;"></i>My Reviews
                    </h1>
                    <p style="color: #7f8c8d; margin: 0;">View and manage your product reviews</p>
                </div>

                @if ($reviews->count() > 0)
                    <div class="row">
                        @foreach ($reviews as $review)
                            <div class="col-lg-6 mb-4">
                                <div style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08); transition: all 0.3s ease;">
                                    <!-- Product Image -->
                                    <div style="height: 200px; overflow: hidden; background: #f8f9fa;">
                                        <img src="{{ asset('storage/products_images/' . $review->product->id . '/' . $review->product->principalImage) }}"
                                            alt="product" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>

                                    <!-- Review Content -->
                                    <div style="padding: 20px;">
                                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                                            <h5 style="margin: 0; color: #1a237e; font-weight: 600; font-size: 16px;">
                                                {{ $review->product->name ?? 'Product Deleted' }}
                                            </h5>
                                            <span style="color: #95a5a6; font-size: 12px;">{{ $review->created_at->format('d M Y') }}</span>
                                        </div>

                                        <!-- Rating -->
                                        <div style="margin-bottom: 12px;">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $review->rate)
                                                    <i class="fas fa-star" style="color: #f39c12; font-size: 14px;"></i>
                                                @else
                                                    <i class="far fa-star" style="color: #bdc3c7; font-size: 14px;"></i>
                                                @endif
                                            @endfor
                                            <span style="margin-left: 8px; color: #7f8c8d; font-size: 13px;">{{ $review->rate }}/5</span>
                                        </div>

                                        <!-- Review Text -->
                                        <p style="color: #2c3e50; font-size: 14px; margin-bottom: 16px; line-height: 1.6;">
                                            {{ $review->content }}
                                        </p>

                                        <!-- Actions -->
                                        <div style="display: flex; gap: 10px; border-top: 1px solid #e0e0e0; padding-top: 16px;">
                                            <button type="button" class="edit-review-btn" data-review-id="{{ $review->id }}" style="flex: 1; background: #3498db; color: white; border: none; padding: 10px; border-radius: 5px; cursor: pointer; font-weight: 600; transition: all 0.3s;">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button type="button" class="delete-review-btn" data-review-id="{{ $review->id }}" style="flex: 1; background: #e74c3c; color: white; border: none; padding: 10px; border-radius: 5px; cursor: pointer; font-weight: 600; transition: all 0.3s;">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </div>

                                        <!-- Edit Form (Hidden) -->
                                        <div id="editForm-{{ $review->id }}" style="display: none; margin-top: 16px; padding-top: 16px; border-top: 1px solid #e0e0e0;">
                                            <form action="{{ route('client.review.update', $review->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div style="margin-bottom: 12px;">
                                                    <label style="display: block; margin-bottom: 6px; color: #1a237e; font-weight: 600; font-size: 13px;">Rating</label>
                                                    <div style="display: flex; gap: 8px;">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <label style="cursor: pointer;">
                                                                <input type="radio" name="rate" value="{{ $i }}" {{ $review->rate == $i ? 'checked' : '' }} style="margin-right: 4px;">
                                                                <span style="color: #f39c12; font-size: 16px;"><i class="fas fa-star"></i></span>
                                                            </label>
                                                        @endfor
                                                    </div>
                                                </div>

                                                <div style="margin-bottom: 12px;">
                                                    <label style="display: block; margin-bottom: 6px; color: #1a237e; font-weight: 600; font-size: 13px;">Your Review</label>
                                                    <textarea name="content" style="width: 100%; padding: 10px; border: 1px solid #bdc3c7; border-radius: 5px; font-family: inherit; box-sizing: border-box;" rows="4">{{ $review->content }}</textarea>
                                                </div>

                                                <div style="display: flex; gap: 10px;">
                                                    <button type="submit" style="flex: 1; background: #16a085; color: white; border: none; padding: 10px; border-radius: 5px; cursor: pointer; font-weight: 600;">Save Changes</button>
                                                    <button type="button" class="cancel-edit-btn" data-review-id="{{ $review->id }}" style="flex: 1; background: #95a5a6; color: white; border: none; padding: 10px; border-radius: 5px; cursor: pointer; font-weight: 600;">Cancel</button>
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
                    <div style="background: white; border-radius: 10px; padding: 60px 20px; text-align: center;">
                        <i class="fas fa-comments" style="font-size: 48px; color: #bdc3c7; margin-bottom: 15px; display: block;"></i>
                        <h5 style="color: #7f8c8d; margin-bottom: 10px;">No reviews yet</h5>
                        <p style="color: #95a5a6;">Start reviewing products to see them here.</p>
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
