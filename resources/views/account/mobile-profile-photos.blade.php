@if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
<div class="shrink-0 mr-3">
    <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
        alt="{{ Auth::user()->name }}" />
</div>
@endif