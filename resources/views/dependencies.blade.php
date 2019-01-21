<!-- GLOBALS -->
@inject('dependencies', 'Laratomics\Services\DependenciesService')

@section('workshop.fonts')
    <!-- Fonts -->
    @foreach($dependencies->getGlobals('fonts') as $font)
        <link rel="stylesheet"
              href="{{ $font['src'] }}"
              integrity="{{ $font['integrity'] }}"
              crossorigin="{{ $font['crossorigin'] }}" />
    @endforeach
@show

@section('workshop.styles')
    <!-- CSS -->
    @foreach($dependencies->getGlobals('styles') as $style)
        <link rel="stylesheet"
              href="{{ $style['src'] }}"
              integrity="{{ $style['integrity'] }}"
              crossorigin="{{ $style['crossorigin'] }}" />
    @endforeach
@show

@section('workshop.scripts')
    <!-- JavaScript -->
    @foreach($dependencies->getGlobals('scripts') as $js)
        <script src="{{ $js['src'] }}"
                integrity="{{ $js['integrity'] }}"
                crossorigin="{{ $js['crossorigin'] }}"></script>
    @endforeach
@endsection