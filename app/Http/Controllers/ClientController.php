<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function dashboard()
    {
        return view('client.index');
    }
    public function orders()
    {
        return view('client.pages.orders');
    }
    public function wishlist()
    {
        return view('client.pages.wishlist');
    }
    public function reviews()
    {
        return view('client.pages.reviews');
    }
    public function profile()
    {
        return view('client.pages.profile');
    }
    public function address()
    {
        return view('client.pages.address');
    }
    public function addAddress()
    {
        return view('client.pages.add_address');
    }
    public function updateProfile() {}
    public function updatePassword() {}


    /*
    public function chat()
    {
        return view('client.pages.chat');
    }
    public function download()
    {
        return view('client.pages.downloads');
    }
    public function invoice()
    {
        return view('client.pages.order_invoice');
    }
    */
}
