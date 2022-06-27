<!DOCTYPE html>

<head></head>

<body>
    <!-- {{ $driver }} -->
    <h2>{{ $driver->person->firstName }} {{ $driver->person->lastName }}</h2>
    @foreach($report_data as $route)
    <h3>{{ $route->name }}</h3>

    <table>
        <thead>
            <td>id</td>
            <td>First Name</td>
            <td>Last Name</td>
            <td>Address</td>
            <td>Email Address</td>
            <td>Home Phone</td>
            <td>Cell Phone</td>
            <td>Num. Meals</td>
            <td>Notes</td>
        </thead>
        <tbody>
            @foreach($route->recipients as $recipient)
            <tr>
                <td>{{ $recipient->id }}</td>
                <td>{{ $recipient->person->firstName }}</td>
                <td>{{ $recipient->person->lastName }}</td>
                <td>{{ $recipient->address }}</td>
                <td>{{ $recipient->person->email }}</td>
                <td>{{ $recipient->person->phoneHome }}</td>
                <td>{{ $recipient->person->phoneCell }}</td>
                <td>{{ $recipient->numMeals }}</td>
                <td>{{ $recipient->person->notes }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endforeach
</body>

</html>