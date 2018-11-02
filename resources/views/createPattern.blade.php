@extends('laratomics-workshop::layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create a new pattern</div>

                    <div class="card-body">
                        <form method="post" action="{{ route('store-pattern') }}">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input id="name" class="form-control" type="text" name="name"
                                       aria-describedby="nameHelp"
                                       placeholder="nested.pattern.name"/>
                                <small id="nameHelp" class="form-text text-muted">E.g. atoms.buttons.button</small>
                            </div>

                            @unless(is_null(config('laratomics.projectKey')))
                                <div class="form-group">
                                    <label for="design">Design</label>
                                    <input id="design" class="form-control" type="text" name="design"
                                           aria-describedby="designHelp" placeholder="php7Y2CLV"/>
                                    <small id="designHelp" class="form-text text-muted">You can get a design file from
                                        <a
                                                href="{{ config('laratomics.webappUrl') }}/designs/{{ config('laratomics.projectKey') }}">{{ config('laratomics.webappUrl') }}</a>
                                    </small>
                                </div>
                            @endunless

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="description" class="form-control" name="description"
                                          placeholder="Describe your pattern ..."></textarea>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-pen-alt"></i>
                                    SAVE
                                </button>
                                <a href="{{ route('workshop') }}">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
