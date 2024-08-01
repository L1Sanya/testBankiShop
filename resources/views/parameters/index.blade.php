<!DOCTYPE html>
<html>
<head>
    <title>Parameters</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .icon img {
            width: 50px;
            height: auto;
        }
        .actions form {
            display: inline-block;
            margin: 0;
        }
        .actions button {
            margin-top: 4px;
        }
    </style>
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
        <th>
            <a href="?sort_field=id&sort_order={{ $sortField == 'id' && $sortOrder == 'asc' ? 'desc' : 'asc' }}">
                ID
            </a>
        </th>
        <th>
            <a href="?sort_field=title&sort_order={{ $sortField == 'title' && $sortOrder == 'asc' ? 'desc' : 'asc' }}">
                Title
            </a>
        </th>
        <th>Type</th>
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
            <td>{{ $parameter->type }}</td>
            <td class="icon">
                @if ($parameter->icon)
                    <img src="{{ asset('storage/' . $parameter->icon) }}" alt="Icon">
                @endif
            </td>
            <td class="icon">
                @if ($parameter->type == 1)
                    <span>Недоступно</span>
                @else
                    @if ($parameter->icon_gray)
                        <img src="{{ asset('storage/' . $parameter->icon_gray) }}" alt="Icon Gray">
                    @endif
                @endif
            </td>
            <td class="actions">
                <form action="{{ url('/parameters/' . $parameter->id . '/upload-images') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="icon">
                    @if ($parameter->type == 2)
                        <input type="file" name="icon_gray">
                    @endif
                    <button type="submit">Upload</button>
                </form>
                <form action="{{ url('/parameters/' . $parameter->id . '/delete-image/icon') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete Icon</button>
                </form>
                @if ($parameter->type == 2)
                    <form action="{{ url('/parameters/' . $parameter->id . '/delete-image/icon_gray') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete Icon Gray</button>
                    </form>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
