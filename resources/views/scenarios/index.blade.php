<div class="row">
    <div class="col-md-10">
        <h3>Scenarios</h3>
    </div>
    <div class="col-md-2">
        <a href="{{ url('/scenarios/create?project='. $project->id) }}" class="btn btn-primary"  style=" margin-top: 20px; color: #ffffff;">Create New</a>
    </div>
</div>

<table class="table table-striped" width="100%">
    <thead>
    <tr>
        <th width="26%">Scene</th>
        <th width="22%">Context</th>
        <th width="10%">User Group</th>
        <th width="15%">Action Info</th>
        <th width="12%">Added By</th>
        <th width="15%">Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($scenarios as $sce)
        <tr>
            <td><a href="{{ url('/scenarios', [$sce->id]) }}">{{ $sce->scene }}</a></td>
            <td>{{ $sce->context_name . ': ' . $sce->full_name }}</td>
            <td>{{ $sce->user_group }}</td>
            <td>{{ $sce->action_info }}</td>
            <td>{{ $sce->created_by }}</td>
            <td>
                @if($sce->user_id === $authUser->id)
                    <a href="{{ url('/scenarios', [$sce->id, 'edit']) }}" title="Edit!" class="btn btn-info btn-sm" style="float: left; margin-right: 5px;">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit
                    </a>
                    {!! Form::open(['method' => 'DELETE', 'route' => ['scenarios.destroy', $sce->id], 'onsubmit' => 'return confirm("Are you sure you want to delete?")']) !!}
                    <button type="submit" class="btn btn-danger btn-sm">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete
                    </button>
                    {!! Form::close() !!}
                @else
                    <span>--</span>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>