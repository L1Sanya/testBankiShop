<!-- resources/views/parameters/index.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parameters</title>
</head>
<body>
<h1>Parameters</h1>
<form method="GET" action="{{ url('/parameters') }}">
    <input type="text" name="search" placeholder="Search by ID or Title">
    <button type="submit">Search</button>
</form>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Icon</th>
        <th>Icon Gray</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($parameters as $parameter)
        <tr>
            <td>{{ $parameter->id }}</td>
            <td>{{ $parameter->title }}</td>
            <td>
                @if ($parameter->icon)
                    <img src="{{ asset('storage/' . $parameter->icon) }}" alt="Icon" width="50">
                @endif
            </td>
            <td>
                @if ($parameter->icon_gray)
                    <img src="{{ asset('storage/' . $parameter->icon_gray) }}" alt="Icon Gray" width="50">
                @endif
            </td>
            <td>
                <form action="{{ url('/parameters/' . $parameter->id . '/upload-images') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="icon">
                    <input type="file" name="icon_gray">
                    <button type="submit">Upload</button>
                </form>
                <form action="{{ url('/parameters/' . $parameter->id . '/delete-image/icon') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete Icon</button>
                </form>
                <form action="{{ url('/parameters/' . $parameter->id . '/delete-image/icon_gray') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete Icon Gray</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
