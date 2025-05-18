<!-- Footer Start -->
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <script>
                    document.write(new Date().getFullYear())
                </script> &copy; {{ $website->name }}
            </div>
            <div class="col-md-6">
                <div class="text-md-end footer-links d-none d-sm-block">
                    <a href="{{ route('frontend.contact') }}">About Us</a>
                    <a href="{{ route('frontend.contact') }}">Help</a>
                    <a href="{{ route('frontend.contact') }}">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- end Footer -->
