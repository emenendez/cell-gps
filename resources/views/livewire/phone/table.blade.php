<div wire:poll.5000ms>
    <h2>Phones</h2>

    @if($phones->count())
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>Token</th>
            <th>Phone Number</th>
            <th>Created</th>
            <th>Updated</th>
            <th>Time Ago</th>
            <th>Locations</th>
        </tr>
        </thead>
        <tbody>
            @foreach($phones as $phone)
            <tr>
                <td><a href="{{ route('manage.phones.show', $phone) }}">{{ $phone->token }}</a></td>
                <td>{{ $phone->number }}</td>
                <td>{{ $phone->created_at->toDateTimeString() }}</td>
                <td>{{ $phone->updated_at->toDateTimeString() }}</td>
                <td>{{ $phone->updated_at->diffForHumans() }}</td>
                <td>{{ number_format($phone->locations()->count()) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>You have no phones setup.</p>
    @endif
</div>
