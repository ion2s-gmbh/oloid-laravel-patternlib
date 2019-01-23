<!-- GLOBALS -->
@inject('dependencies', 'Oloid\Services\DependenciesService')

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