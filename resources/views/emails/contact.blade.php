<h2>New Contact Form Submission</h2>
<div class="row text-center">
<p class="col-4"><strong>Name:</strong> {{ $name }}</p>
<p class="col-4"><strong>Email:</strong> {{ $email }}</p>
<p class="col-4"><strong>Phone:</strong> {{ $phone }}</p>
<p><strong>Subject:</strong> {{ $subject }}</p>
<p><strong>Message:</strong> {{ $message }}</p>
</div>

<hr>

<h3>From:</h3>
<p><strong>Name:</strong> {{ $name }}</p>
<p><strong>Email:</strong> {{ $email }}</p>
<p><strong>Phone:</strong> {{ $phone }}</p>

<h3>Message:</h3>
<p>{{ $message }}</p>
</div>
</body>
</html>