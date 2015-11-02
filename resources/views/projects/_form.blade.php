<div class="form-group">
    {!! Form::label('title', 'Project Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('project_owner', 'Project Owner:') !!}
    {!! Form::select('project_owner', $owners, null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('project_members', 'Project Members:') !!}
    {!! Form::select('project_members[]', $members, isset($selected_members) ? $selected_members : null,
    ['class' => 'form-control', 'required' => 'required', 'multiple' => 'multiple']) !!}
</div>

<div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
    <a class="btn btn-default" onclick="history.go(-1)">Cancel</a>
</div>