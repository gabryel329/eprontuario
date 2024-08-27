@extends('layouts.app')
@section('content')
<main class="app-content">
    @if(session('success'))
      <div class="alert alert-success">
          {{ session('success') }}
      </div>
    @endif
    @if(session('error'))
      <div class="alert alert-warning">
        {!! session('error') !!}
      </div>
    @endif
    <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title">Guia - Tiss</h3>
            <div class="tile-body">
                
            </div>
          </div>
        </div>
      </div>
    </main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
@endsection