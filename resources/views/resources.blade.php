<!-- GLOBAL RESOURCES -->
@inject('dependencies', 'Oloid\Services\DependenciesService')

@section('workshop.head')
    {!! $dependencies->getGlobals('head') !!}
@show

@section('workshop.scripts')
    {!! $dependencies->getGlobals('body') !!}
@endsection