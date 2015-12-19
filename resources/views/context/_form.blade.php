<div class="form-group">
    {!! Form::label('context_id', 'Context:') !!}
    {!! Form::select('context_id', $context_ideal_way, null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
</div>

<div class="form-group">
    {!! Form::label('scenario', 'Scenario:') !!}
    {!! Form::text('scenario', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>

{{--<div class="form-group">--}}
    {{--{!! Form::checkbox('accompanying', '1') !!}--}}
    {{--{!! Form::label('accompanying', 'Is Accompanying?') !!}--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::checkbox('intermittent', '1') !!}--}}
    {{--{!! Form::label('intermittent', 'Is Intermittent?') !!}--}}
{{--</div>--}}

{{--<div class="form-group">--}}
    {{--{!! Form::checkbox('interrupting', '1') !!}--}}
    {{--{!! Form::label('interrupting', 'Is Interrupting?') !!}--}}
{{--</div>--}}

<div class="form-group">
    {!! Form::hidden('user_id', isset($authUser->id) ? $authUser->id : '') !!}
    {!! Form::hidden('requirement_id', isset($requirement_id) ? $requirement_id : '') !!}
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
    <a class="btn btn-default" onclick="history.go(-1)">Cancel</a>
</div>