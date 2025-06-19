@extends('layouts.master')
@section('content')
<div class="app-title"> 
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item active"><a href="#">Persebaran Penduduk Miskin</a></li>
        </ul>
    </div>
    <div class="title">
      <h4>Peta Persebaran Penduduk Miskin</h4>
    </div>

    <div class="row">
        <div class="col-md-6">
          <div class="tile">
            <div class="tile-body">Peta</div>
            <div class="tile-footer">
              {{-- peta leaflet --}}
            </div>
          </div>
        </div>
      </div>
@endsection
