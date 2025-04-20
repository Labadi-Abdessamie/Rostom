@extends('client.master')

@section('title')
    Dashboard || Reviews
@endsection

@section('content')
<div class="row">
    <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
        <div class="dashboard_content mt-2 mt-md-0">
            <h3><i class="far fa-star"></i> Reviews</h3>
            <div class="wsus__dashboard_review">
                <div class="row">
                    @foreach($reviews as $review)
                        <div class="col-xl-6 mb-4">
                            <div class="wsus__dashboard_review_item">
                                <div class="wsus__dash_rev_img">
                                    <img src="{{ asset($review->product->principalImage ?? 'images/default.jpg') }}" alt="product" class="img-fluid w-100">
                                </div>
                                <div class="wsus__dash_rev_text">
                                    <h5>{{ $review->product->name ?? 'Product Deleted' }} <span>{{ $review->created_at->format('d-m-Y') }}</span></h5>
                                    <p class="wsus__dash_review">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rate)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </p>
                                    <p>{{ $review->content }}</p>
                                    <ul>
                                        <li>
                                            <a href="#" data-bs-toggle="collapse" data-bs-target="#editReview{{ $review->id }}">
                                                <i class="fal fa-edit"></i> edit
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('client.review.delete', $review->id) }}" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this review?')) document.getElementById('delete-review-{{ $review->id }}').submit();">
                                                <i class="far fa-minus-circle"></i> delete
                                            </a>
                                            <form id="delete-review-{{ $review->id }}" action="{{ route('client.review.delete', $review->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </li>
                                    </ul>
                                    <div class="accordion accordion-flush" id="accordionFlush{{ $review->id }}">
                                        <div class="accordion-item">
                                            <div id="editReview{{ $review->id }}" class="accordion-collapse collapse">
                                                <div class="accordion-body">
                                                    <form action="{{ route('client.review.update', $review->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="wsus__riv_edit_single">
                                                            <i class="fas fa-star"></i>
                                                            <select name="rate" class="select_2">
                                                                @for($i = 1; $i <= 5; $i++)
                                                                    <option value="{{ $i }}" {{ $review->rate == $i ? 'selected' : '' }}>
                                                                        {{ $i }}
                                                                    </option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                        <div class="wsus__riv_edit_single text_area">
                                                            <i class="far fa-edit"></i>
                                                            <textarea name="content" cols="3" rows="3">{{ $review->content }}</textarea>
                                                        </div>
                                                        <button type="submit" class="common_btn">Submit</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if($reviews->isEmpty())
                        <p class="text-center">You haven't posted any reviews yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
