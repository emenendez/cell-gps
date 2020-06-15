@extends('site.layouts.app')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('manage.dashboard') }}">&lt; back to devices</a></li>
    </ol>
</nav>

<livewire:location.table :phone="$phone"/>

<div class="row mt-5">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">Device: {{ $phone->token }}</div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Token</dt>
                    <dd class="col-sm-9">{{ $phone->token }}</dd>

                    <dt class="col-sm-3">Number</dt>
                    <dd class="col-sm-9">{{ $phone->number }}</dd>

                    <dt class="col-sm-3">Updated</dt>
                    <dd class="col-sm-9">{{ $phone->updated_at->toDateTimeString() }}</dd>

                    <dt class="col-sm-3 text-truncate">User Agent</dt>
                    <dd class="col-sm-9">{{ $phone->user_agent }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
