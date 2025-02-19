<form action="{{ route('Flights.store') }}" method="post">

    @csrf

    <label for="name">Nom</label>
    <input type="text" name="name"/>
    <label for="airline">Aerolinia</label>
    <input type="text" name="airline"/>
    <label for="type">Tipus: 'Lowcost', 'Economic' o 'Business'</label>
    <input type="text" name="type"/>
    <input type="submit" name="Crear"/>
</form>