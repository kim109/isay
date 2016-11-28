@extends('layout')

@push('scripts')
<script src="{{ elixir('js/korea.js') }}"></script>
@endpush

@section('content')
<div id="tooltip-container"></div>
<div id="canvas-svg"></div>
@endsection