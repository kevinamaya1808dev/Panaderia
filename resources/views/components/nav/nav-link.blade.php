@props(['href' => '#', 'icon' => null, 'content' => ''])

<a class="nav-link" href="{{ $href }}">
    <div class="sb-nav-link-icon"><i class="{{$icon}}"></i></div>
    {{$content}}
</a>