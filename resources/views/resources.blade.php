<!-- GLOBAL RESOURCES -->
@inject('resources', 'Oloid\Services\ResourcesService')

@section('workshop.head')
    {!! $resources->getGlobals('head') !!}
@show

@section('workshop.scripts')
    {!! $resources->getGlobals('body') !!}
@endsection