@extends('layouts.app')

@php
$user = Auth::user();
@endphp

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ $user->name }} has
                    @if ($user->savefile != null)
                        a savefile
                    @else
                        no savefile
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
