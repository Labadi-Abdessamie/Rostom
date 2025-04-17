{{--
<div x-data="{ show: @entangle('show') }" x-show="show" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-y-4"
    x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform translate-y-4"
    class="alert alert-success alert-dismissible fade show position-fixed start-50 translate-middle shadow" role="alert"
    style="z-index: 9999;" @notification-triggered.window="show = true; setTimeout(() => show = false, 3000)">
    <div class="flex items-center gap-3">
        <div>
            <p class="font-semibold">✓ {{ $message }}!</p>
            <p class="text-sm">{{ $productName }}</p>
        </div>
    </div>
</div>
--}}
<div x-data="{ show: $wire.entangle('show') }" x-show="show" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-y-4"
    x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform translate-y-4"
    class="alert alert-primary alert-dismissible fade show position-fixed start-50 translate-middle shadow"
    style="z-index: 9999; display: none" x-init="setTimeout(() => show = false, 3000);
    $watch('show', value => {
        if (value) {
            setTimeout(() => show = false, 3000);
        }
    })">
    <div class="flex items-center gap-3">
        <div>
            <p class="font-semibold">✓ {{ $message }}!
                @if ($productName)
                    <span class="text-sm">{{ $productName }}</span>
                @endif
            </p>
        </div>
    </div>
</div>
