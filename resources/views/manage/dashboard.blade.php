@extends('site.layouts.app')

@section('content')
<livewire:phone.table />

<div class="row">
    <div class="col-sm-6">
        <div class="card mt-5">
            <div class="card-header">
                Request Tracking
            </div>
            <div class="card-body">
                <livewire:phone.create />
            </div>
        </div>
    </div>
</div>
@endsection
