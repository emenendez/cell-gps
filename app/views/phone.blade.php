@extends('master')

@section('content')
  <h2>Details for {{ $email }}</h2>
  <p>Time sent: {{ $phone_time }}</p>
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>Time of location</th>
        <th>Time received</th>
        <th>Location</th>
        <th>Accuracy (m)</th>
        <th>Altitude (m)</th>
        <th>Heading (deg)</th>
        <th>Speed (m/s)</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($locations as $location)
        <tr>
          <td>{{ $location->location_time }}</td>
          <td>{{ $location->created_at }}</td>
          <td>{{ HTML::link('http://maps.google.com/maps?q=' . urlencode($location->location), $location->location) }}</td>
          <td>{{ $location->accuracy }}</td>
          <td>{{ $location->altitude ? $location->altitude . '&#xB1;' . $location->altitudeAccuracy . 'm' : '' }}</td>
          <td>{{ $location->heading }}</td>
          <td>{{ $location->speed }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
@stop