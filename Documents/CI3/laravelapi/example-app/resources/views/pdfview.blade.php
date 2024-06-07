<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Table</title>
</head>

<body>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod

        tempor incididunt ut labore et dolore magna aliqua.</p>
    <table class="table table-bordered">

        <tr>

            <th>ID</th>

            <th>Name</th>

            <th>Email</th>

        </tr>
        {{-- @foreach ($users as $user) --}}
        <tr>

            <td>1</td>

            <td>Shubham Amrutkar</td>

            <td>Shubh@gmail.com</td>

        </tr>

        {{-- @endforeach --}}

    </table>
</body>

</html>
