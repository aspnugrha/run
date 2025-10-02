@extends('layouts.app')

@section('content')
<div class="conatiner bg-light p-3">
    <div class="card p-3">
        <h4 class="mb-4">Live Results</h4>
        
        <div class="row">
            @foreach ($events as $item)
            <div class="col-12 col-md-4 mb-4">
                <div class="card card-custom shadow-sm">
                    <img src="https://placehold.co/600x400?text=Hello+World" class="card-img-top" alt="Gambar contoh">
                    <div class="card-body">
                        <h5 class="card-title">{{ $item['name'] }}</h5>
                        <p class="card-text">{{ date('d F Y', strtotime($item['date'])) }}</p>
                        <a href="/result/{{ $item['id'] }}" class="btn btn-outline-dark btn-sm">Result</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection