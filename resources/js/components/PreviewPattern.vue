<template>

  <div class="row">
    <div class="col-sm-4">
      <h2>{{ patternName }}
        <span v-if="state === 'REVIEW'" class="badge badge-warning">REVIEW</span>
        <span v-if="state === 'DONE'" class="badge badge-success">DONE</span>
      </h2>
      <h2>Description</h2>
      <div class="code">
        <pre><code class="language-markdown">{{ description }}</code></pre>
      </div>
      <br>
      <h2>Usage
        <button id="copy" class="btn btn-secondary" data-clipboard-target="#pattern">
          <i class="far fa-clipboard"></i>
        </button>
      </h2>
      <div class="code">
        <pre><code class="language-html" id="pattern">{{ '@' }}{{ type }}('{{ usage }}', [])</code></pre>
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
            <pre><code class="language-html">{{ markup }}</code></pre>
          </div>
          <div class="tab-pane fade" id="html-view" role="tabpanel" aria-labelledby="html-view">
            <pre><code class="language-html">{{ html }}</code></pre>
          </div>
        </div>
      </div>
      <br>
      <h2>SASS/CSS</h2>
      <div class="code">
        <pre><code class="language-css">{{ style }}</code></pre>
      </div>
    </div>
    <div class="col-sm-8">
      <h2>Preview</h2>
      <div class="code">
        <div class="card-body">
          NO YET CONNECTED!
          <!--<iframe height="1500" width="1100"-->
                  <!--frameBorder="0"-->
                  <!--src="{{ route('get-preview', ['pattern' => $pattern]) }}"></iframe>-->
        </div>
      </div>
    </div>
  </div>

</template>

<script>
  export default {
    name: "PreviewPattern",
    data() {
      return {
        type: 'element',
        patternName: 'elements.tests.dummy',
        description: 'Description of the pattern',
        state: 'DONE',
        usage: 'tests.dummy',
        markup: '<h1>{{ $text }}</h1>',
        html: '<h1>Heading 1</h1>',
        style: 'h1 { color: red; }'
      }
    }
  }
</script>