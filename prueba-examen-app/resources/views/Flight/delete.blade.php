<form action="{{ route('Flights.destroy', $flight) }}" method="post">
    @method('DELETE')
    @csrf
    <button type="submit">Delete</button>
</form>