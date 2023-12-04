<div class="card">
    <div class="card-header">
        <h3 class="text-center">Report Data</h3>
    </div>
    <div class="card-body">
        <table class="table">
            <tr>
                <th>Id</th>
                <th>Name</th>
            </tr>
            @foreach($data as $d)
            <tr>
                <td>{{$d->id}}</td>
                <td>{{$d->name}}</td>
            </tr>
            @endforeach
        </table>
    </div>
</div>