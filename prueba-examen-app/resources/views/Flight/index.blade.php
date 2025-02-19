
<table>
@foreach ($flight_all as $flight )
<tr>
    <td>{{ $flight->id }}</td>
    <td>{{ $flight->name }}</td>
    <td>{{ $flight->airline }}</td>
    <td>{{ $flight->type }}</td>
    <td>{{ $flight->created_at }}</td>
    <td>{{ $flight->updated_at }}</td>
</tr>
@endforeach
</table>
{{ $flight_all->links() }}