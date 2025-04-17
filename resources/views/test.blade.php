<h3>sliderProducts</h3>
@foreach ($sliderProducts as $sliderProduct)
    <p>
        {{ $sliderProduct->name }}
    </p>
@endforeach
<h3>secondSliderProducts</h3>
@foreach ($secondSliderProducts as $secondSliderProduct)
    <p>
        {{ $secondSliderProduct->name }}
    </p>
@endforeach
<h3>monthlyProducts</h3>
@foreach ($monthlyProducts as $monthlyProduct)
    <p>
        {{ $monthlyProduct->name }}
    </p>
@endforeach
<h3>regularProducts</h3>
@foreach ($regularProducts as $regularProduct)
    <p>
        {{ $regularProduct->name }}
    </p>
@endforeach
<h3>randomProducts</h3>
@foreach ($randomProducts as $randomProduct)
    <p>
        {{ $randomProduct->name }}
    </p>
@endforeach
<h3>categoryProducts</h3>
@foreach ($categoryProducts as $categoryProduct)
    <p>
        {{ $categoryProduct->name }}
    </p>
@endforeach
