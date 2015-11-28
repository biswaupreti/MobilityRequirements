<div class="row">
    <div class="col-md-10">
        <h3>Context Scenarios</h3>
    </div>
    <div class="col-md-2">
        <button class="btn btn-primary"  style="margin-top: 20px;">
            <a href="{{ url('context/create/?requirement='. $requirement->id) }}"  style="color: #ffffff;">Create New</a>
        </button>
    </div>
</div>

<table class="table table-striped" width="100%">
    <thead>
    <tr>
        <th width="5%">#</th>
        <th width="10%">Context</th>
        <th width="30%">Scenario</th>
        <th width="20%">User Interaction</th>
        <th width="10%">Added By</th>
        <th width="10%">Created On</th>
        <th width="15%">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php $i = 1; ?>
    @foreach($context as $row)
        <tr>
            <th scope="row">{{ $i }}</th>
            <td>{{ $row->context_name }}</td>
            <td>{{ $row->scenario }}</td>
            <td>
                {{ ($row->accompanying) ? 'Accompanying; ' : '' }}
                {{ ($row->intermittent) ? 'Intermittent; ' : '' }}
                {{ ($row->interrupting) ? 'Interrupting; ' : '' }}
            </td>
            <td>{{ $row->user_name }}</td>
            <td>{{ $row->created_at }}</td>
            <td>
                @if($row->user_id === $authUser->id)
                    <a href="{{ url('/context', [$row->id, 'edit']) }}" title="Edit!" class="btn btn-info btn-sm" style="float: left; margin-right: 5px;">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit
                    </a>
                    {!! Form::open(['method' => 'DELETE', 'route' => ['context.destroy', $row->id], 'onsubmit' => 'return confirm("Are you sure you want to delete?")']) !!}
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