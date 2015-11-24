@extends('layout')

@section('content')

<div class="row">
    <div class="col-md-12">
        <h3>Ideal Way of Interaction for Situational Context</h3>
    </div>
</div>

<table class="table table-striped" width="100%">
    <thead>
    <tr>
        <th width="5%">#</th>
        <th width="20%">Situational Context</th>
        <th width="45%">Typical Scenario</th>
        <th width="30%">Ideal Ways</th>
    </tr>
    </thead>
    <tbody>
    <?php $i = 1; ?>
    @foreach($context as $row)
        <tr>
            <th scope="row">{{ $i }}</th>
            <td>{{ $row->context_name }}</td>
            <td>{{ $row->typical_scenario }}</td>
            <td>
                {{ ($row->accompanying) ? 'Accompanying; ' : '' }}
                {{ ($row->intermittent) ? 'Intermittent; ' : '' }}
                {{ ($row->interrupting) ? 'Interrupting; ' : '' }}
            </td>
        </tr>
        <?php $i++; ?>
    @endforeach
    </tbody>
</table>

@stop