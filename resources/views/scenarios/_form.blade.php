<div class="form-group">
    {!! Form::label('scene', 'Scene:') !!}
    {!! Form::text('scene', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('context_id', 'Situational Context:') !!}
    {!! Form::select('context_id', $context_ideal_way, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('user_group', 'User Group:') !!}
    {!! Form::text('user_group', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('action_info', 'Action Info:') !!}
    {!! Form::text('action_info', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::hidden('project_id', isset($project_id) ? $project_id : '') !!}
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
    <a class="btn btn-default" onclick="history.go(-1)">Cancel</a>
</div>