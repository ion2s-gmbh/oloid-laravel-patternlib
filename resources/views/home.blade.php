@extends('workshop::layout')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Information</div>

                <div class="card-body">
                    @unless(is_null(config('laratomics.projectKey')))
                        Your project is linked with <a href="https://dev.laratomics.com/projects/{{ config('laratomics.projectKey') }}">Laratomics</a>.
                    @else
                        Your project is not yet linked with <a href="{{ config('laratomics.webappUrl') }}">Laratomics</a>.
                    @endunless
                </div>
            </div>
        </div>
        <div class="col-md-3">

            <div class="card">
                <div class="card-header">
                    Pattern management
                </div>

            </div>
        </div>
    </div>
@endsection