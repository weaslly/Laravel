<!doctype html>
<html lang="en">
<head>
    <title>db</title>
</head>
<body>
    <table border="1">
        <tr>
            <th>role</th>
            <th>created_at</th>
            <th>updated_at</th>
        </tr>

    @foreach($db as $key => $data)
        <tr>
            <td>{{$data->name}}</td>
            <td>{{$data->created_at}}</td>
            <td>{{$data->updated_at}}</td>
        </tr>

    @endforeach
    </table>
</body>
</html>