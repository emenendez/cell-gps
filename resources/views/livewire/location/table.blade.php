<div wire:poll.5000ms>
    <h2>Locations</h2>

    @if($phone->locations()->count())
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Created</th>
            <th>Time Ago</th>
            <th>Lat / Lon</th>
            <th>UTM</th>
            <th>Altitude (m)</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            @foreach($phone->locations()->orderBy('updated_at', 'desc')->get() as $location)
            <tr>
                <td>{{ $loop->remaining + 1 }}</td>
                <td>{{ $location->created_at->toDateTimeString() }}</td>
                <td>{{ $location->updated_at->diffForHumans() }}</td>
                <td>{{ $location->latitude }}, {{ $location->longitude }}</td>
                <td>{{ $location->utm }}</td>
                <td>{{ $location->altitude }}</td>
                <td><a href="{!! 'https://www.google.com/maps/@' . $location->latitude . ',' . $location->longitude . ',16z' !!}" target="_blank">map</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>This phone has no locations.</p>
    @endif
</div>
