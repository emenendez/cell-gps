@extends('master')

@section('content')
  @unless ($success == '')
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
          <td>{{ link_to_route('phone', $phone->id, array($phone->id), array('title' => 'Token: ' . $phone->token)) }}</td>
          <td>{{ link_to_route('phone', $phone->number_pretty, array($phone->id), array('title' => 'SMS sent ' . $phone->created_at )) }}</td>
          <td>{{ $phone->last_location->location != '' ? HTML::link('http://maps.google.com/maps?q=' . urlencode($phone->last_location->location), $phone->last_location->location, array('target' => '_blank')) : '' }}</td>
          <td>{{ $phone->last_location->accuracy }}</td>
          <td>{{ $phone->last_location->altitude ? $phone->last_location->altitude . '&#xB1;' . $phone->last_location->altitudeAccuracy . 'm' : '' }}</td>
          <td>{{ $phone->last_location->heading }}</td>
          <td>{{ $phone->last_location->speed }}</td>
          <td>{{ $phone->last_location->location_time }}</td>
          <td>{{ $phone->last_location->created_at }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
@stop