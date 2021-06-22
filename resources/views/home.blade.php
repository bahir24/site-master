@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @foreach ($references as $reference)
                    <div class="card mb-3">
                        <div class="row no-gutters">
                        <div class="col-md-4">
                            <img src="{{ asset('img/1.png')}}" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                            <h5 class="card-title">{{ $reference->heading }}</h5>
                            <p class="card-text">{{ $reference->message }}</p>
                            <h6>{{ $reference->name }}</h6>
                            <p class="card-text"><small class="text-muted">{{ $reference->updated_at }}</small></p>
                            </div>
                        </div>
                        </div>
                    </div>

                @endforeach
                <div class="d-flex justify-content-center">
                    {{ $references->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
