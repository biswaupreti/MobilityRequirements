<?php
    $role_attrib = ['class' => 'form-control', 'required' => 'required'];
    if($mode == 'edit'){
        $password_attrib = array('class' => 'form-control', 'required' => 'required', 'disabled' => 'disabled');
        if($authUser->role != '1'){
            $role_attrib = ['class' => 'form-control', 'readonly' => 'readonly'];
        }
    } else{
        $password_attrib = array('class' => 'form-control', 'required' => 'required');
    }
?>

<div class="form-group">
    {!! Form::label('name', 'Full Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>

@if($mode == 'edit')
<div class="form-group">
    {!! Form::label('change_password', 'Change Password:') !!}
    {!! Form::checkbox('change_password', '1') !!}
</div>
@endif

<div class="form-group">
    {!! Form::label('password', 'Password:') !!}
    {!! Form::password('password', $password_attrib) !!}
</div>

<div class="form-group">
    {!! Form::label('password_confirmation', 'Confirm Password:') !!}
    {!! Form::password('password_confirmation', $password_attrib) !!}
</div>

<div class="form-group">
    {!! Form::label('role', 'User Role:') !!}
    {!! Form::select('role',
     array('' => 'Select One' , '1' => 'Administrator', '2' => 'Project Manager', '3' => 'Developer/Designer'),
     null, $role_attrib) !!}
</div>

<div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
    <a class="btn btn-default" onclick="history.go(-1)">Cancel</a>
</div>

<script>
    $(document).ready(function(){
        $('#change_password').click(function(){
            if($(this).is(':checked')){
                $("#password").removeAttr('disabled');
                $("#password_confirmation").removeAttr('disabled');
            }else{
                $("#password").attr('disabled', 'disabled');
                $("#password_confirmation").attr('disabled', 'disabled');
            }
        });
    });
</script>