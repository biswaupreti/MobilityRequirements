<div class="row">
    <div class="col-md-10">
        <h3>Requirements</h3>
    </div>
    <div class="col-md-2">
        <a href="{{ url('requirements/create/?project='. $project->id) }}" class="btn btn-primary"  style=" margin-top: 20px; color: #ffffff;">Create New</a>
    </div>
</div>

<table class="table table-striped" width="100%">
    <thead>
    <tr>
        <th width="5%">#</th>
        <th width="20%">Title</th>
        <th width="40%">Description</th>
        <th width="10%">Created By</th>
        <th width="10%">Created On</th>
        <th width="15%">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php $i = 1; ?>
    @foreach($requirements as $req)
        <tr>
            <th scope="row">{{ $project->id . str_pad($req->id, 4, "0", STR_PAD_LEFT ) }}</th>
            <td><a href="{{ url('/requirements', [$req->id]) }}">{{ $req->title }}</a></td>
            <td>{{ $req->description }}</td>
            <td>{{ $req->created_by }}</td>
            <td>{{ $req->created_at }}</td>
            <td>
                @if($req->user_id === $authUser->id)
                    <a href="{{ url('/requirements', [$req->id, 'edit']) }}" title="Edit!" class="btn btn-info btn-sm" style="float: left; margin-right: 5px;">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit
                    </a>
                    {!! Form::open(['method' => 'DELETE', 'route' => ['requirements.destroy', $req->id], 'onsubmit' => 'return confirm("Are you sure you want to delete?")']) !!}
                    <button type="submit" class="btn btn-danger btn-sm">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete
                    </button>
                    {!! Form::close() !!}
                @else
                    <span>--</span>
                @endif
            </td>
        </tr>
        <?php $i++; ?>
    @endforeach
    </tbody>
</table>