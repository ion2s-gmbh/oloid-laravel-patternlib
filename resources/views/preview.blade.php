@extends('workshop::layout')

@section('content')
    <div class="row">
        <div class="col-sm-4">
            <h2>{{ $pattern }}
                @if($state == 'REVIEW')
                    <span class="badge badge-warning">REVIEW</span>
                @elseif($state == 'DONE')
                    <span class="badge badge-success">DONE</span>
                @endif
            </h2>
            <h2>Description</h2>
            <div class="code">
                <pre><code class="language-markdown">{{ $metadata->body() }}</code></pre>
            </div>
            <br>
            <h2>Usage
                <button id="copy" class="btn btn-secondary" data-clipboard-target="#pattern">
                    <i class="far fa-clipboard"></i>
                </button>
            </h2>
            <div class="code">
                <pre><code class="language-html" id="pattern">{{ '@' }}{{ $type }}('{{ $patternUsage }}', [])</code></pre>
            </div>
            <br>
            <h2>Markup/HTML</h2>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#markup-view" role="tab"
                       aria-controls="markup-view" aria-selected="true">Markup</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#html-view" role="tab"
                       aria-controls="html-view" aria-selected="false">HTML</a>
                </li>
            </ul>
            <div class="code">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="markup-view" role="tabpanel"
                         aria-labelledby="markup-view">
                        <pre><code class="language-html">{{ $html }}</code></pre>
                    </div>
                    <div class="tab-pane fade" id="html-view" role="tabpanel" aria-labelledby="html-view">
                        <pre><code class="language-html">{{ $preview }}</code></pre>
                    </div>
                </div>
            </div>
            <br>
            <h2>SASS/CSS</h2>
            <div class="code">
                <pre><code class="language-css">{{ $style }}</code></pre>
            </div>
        </div>
        <div class="col-sm-8">
            <h2>Preview</h2>
            <div class="code">
                <div class="card-body">
                    <iframe height="1500" width="1100"
                            frameBorder="0"
                            src="{{ route('get-preview', ['pattern' => $pattern]) }}"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.5.0/prism.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.1/clipboard.js"></script>
<script>
  new ClipboardJS('#copy');
</script>
