@extends('master')

@section('content')
  @unless (empty($success))
    <div class="alert alert-success">{{ $success }}</div>
  @endunless
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <th>Email</th>
        <th>Location</th>
        <th>Accuracy (m)</th>
        <th>Altitude (m)</th>
        <th>Heading (deg)</th>
        <th>Speed (m/s)</th>
        <th>Time of location</th>
        <th>Time received</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($phones as $phone)
        <tr>
          <td>{{ link_to_route('phone', $phone->id, array($phone->id)) }}</td>
          <td>{{ link_to_route('phone', $phone->email, array($phone->id), array('title' => 'SMS sent ' . $phone->created_at )) }}</td>
          <td>{{ $phone->location->location != '' ? HTML::link('http://maps.google.com/maps?q=' . urlencode($phone->location->location), $phone->location->location) : '' }}</td>
          <td>{{ $phone->location->accuracy }}</td>
          <td>{{ $phone->location->altitude ? $phone->location->altitude . '&#xB1;' . $phone->location->altitudeAccuracy . 'm' : '' }}</td>
          <td>{{ $phone->location->heading }}</td>
          <td>{{ $phone->location->speed }}</td>
          <td>{{ $phone->location->location_time }}</td>
          <td>{{ $phone->location->created_at }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
@stop