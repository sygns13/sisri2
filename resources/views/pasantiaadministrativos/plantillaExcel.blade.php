<table>
    <thead>
        <tr>
            <th colspan="3" style="background-color: #0C73E8; border: 2px solid #575757;">
                Titulo de la Wea
            </th>
        </tr>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Prueba</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td><select name="cbuprueba" id="cbuprueba">
                <option value="1">primero</option>
                <option value="2">segundo</option>
                <option value="3">tercero</option>
                <option value="4">cuarto</option>
            
            </select></td>
        </tr>
    @endforeach
    </tbody>
</table>



