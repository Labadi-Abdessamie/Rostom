@extends('client.master')

@section('title')
    Dashboard || Wishlist
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
            <div class="dashboard_content mt-2 mt-md-0">
                <h3><i class="far fa-heart"></i> Wishlist</h3>
                <div class="wsus__dashboard_wishlist">
                    <div class="row">
                        <div class="col-12">
                            <div class="wsus__cart_list wishlist">
                                <div class="table-responsive">
                                    <table>
                                        <tbody>
                                            @forelse ($wishlist as $key => $item)
                                                <tr class="d-flex">
                                                    <td class="wsus__pro_img">
                                                        <img src="{{ $item['product']['image'] }}" alt="product" class="img-fluid w-100">
                                                        <a href="#"><i class="far fa-times"></i></a>
                                                    </td>

                                                    <td class="wsus__pro_name">
                                                        <p>{{ $item['product']['name'] }}</p>
                                                    </td>

                                                    <td class="wsus__pro_status">
                                                        <p>{{ $item['product']['actual_quantity']>0 ? 'In stock' : 'Out of stock' }}</p>
                                                    </td>

                                                    <td class="wsus__pro_select">
                                                        <form class="select_number">
                                                            <input class="number_area" type="text" min="1" max="100" value="{{ $item['quantity'] }}" />
                                                        </form>
                                                    </td>

                                                    <td class="wsus__pro_tk">
                                                        <h6>${{ number_format($item['product']['price'], 2) }}</h6>
                                                    </td>

                                                    <td class="wsus__pro_icon">
                                                        <a class="common_btn" href="#">Add to Cart</a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">Your wishlist is empty.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="pagination">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Previous">
                                                <i class="fas fa-chevron-left"></i>
                                            </a>
                                        </li>
                                        <li class="page-item"><a class="page-link page_active" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Next">
                                                <i class="fas fa-chevron-right"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
