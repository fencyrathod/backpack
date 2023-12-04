<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment Detail</title>
</head>
<body>
     <div class="container">
        <div class="row shadow-lg p-3 mb-5 bg-body rounded">
            <div class="col">
                <label>Customer Name:</label>
                {{$print["c_name"]}}
            </div>

            <div class="col">
                <label>Assignee:</label>
                {{$print["Assign_user"]}}
            </div>
        </div>
    </div>   
</body>
</html>