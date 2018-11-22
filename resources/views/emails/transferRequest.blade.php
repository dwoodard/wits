<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Asset Transfer Requested</h1>

    <p>{{$transfers->first()->new_department->primary_contact_name}},</p>

    <p>You have been sent the following assets:</p>



    @foreach ($transfers->groupBy('old_department_id') as $transferDepartment)
        <div>
            <h2>{{$transferDepartment->first()->old_department->name}} ({{$transferDepartment->count()}})</h2>





            <ul>
                @foreach ($transferDepartment as $department)
                    <li>
                            @if($department->asset->media->count())
                                <img width="200" src="{{url('/').$department->asset->media[0]->path}}" alt=""> -
                            @endif

                            @if($department->asset->label)
                                {{$department->asset->label}}
                            @endif

                            @if($department->asset->weber_inventory_tag)
                                {{$department->asset->weber_inventory_tag}}
                            @endif
                    </li>
                @endforeach
            </ul>

        </div>

    @endforeach

    <p>
        Please sign in to <a href="{{url('/app/inventory')}}">WITS</a> and <b>Accept</b> or <b>Reject</b> each asset.
    </p>

</body>
</html>
