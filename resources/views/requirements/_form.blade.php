<div class="form-group">
    {!! Form::label('scenario_id', 'Select Scenario:') !!}
    {!! Form::select('scenario_id', $scenarios, isset($scenario_id) ? $scenario_id : null,
    ['class' => 'form-control', 'required' => 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
{!! Form::checkbox('accompanying', '1') !!}
{!! Form::label('accompanying', 'Is Accompanying?') !!}
</div>

<div class="form-group">
{!! Form::checkbox('intermittent', '1') !!}
{!! Form::label('intermittent', 'Is Intermittent?') !!}
</div>

<div class="form-group">
{!! Form::checkbox('interrupting', '1') !!}
{!! Form::label('interrupting', 'Is Interrupting?') !!}
</div>

<div class="form-group">
    {!! Form::hidden('project_id', isset($project_id) ? $project_id : '') !!}
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
    <a class="btn btn-default" onclick="history.go(-1)">Cancel</a>
</div>