<?php
    $req_accompanying = $requirement->accompanying;
    $req_intermittent = $requirement->intermittent;
    $req_interrupting = $requirement->interrupting;
?>
@extends('layout')

@section('content')
    <h3>Requirement Details</h3>
    <hr/>


    <div class="bs-example" data-example-id="horizontal-dl">
        <dl class="dl-horizontal">
            <dt>Title: </dt>
            <dd>{{ $requirement->title }}</dd>
            <dt>Description: </dt>
            <dd>{{ $requirement->description }}</dd>
            <dt>Created On</dt>
            <dd>{{ $requirement->created_at }}</dd>
            <hr/>
            <dt>Ways of Interactions</dt>
            <dd>
                @if($req_accompanying)
                    Accompanying<br/>
                @endif
                @if($req_intermittent)
                    Intermittent<br/>
                @endif
                @if($req_interrupting)
                    Interrupting
                @endif
            </dd>
        </dl>
    </div>

    <div class="row">
        <div class="col-md-10">
            <h3>Context Scenarios</h3>
        </div>
    </div>

    <table class="table table-striped" width="100%">
        <thead>
        <tr>
            <th width="5%">#</th>
            <th width="20%">Context</th>
            <th width="30%">Scenario</th>
            <th width="20%">Ways of Interaction</th>
            <th width="25%">Remarks</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1; ?>
        @foreach($context as $row)
            <?php
                $conflict = false;
                $accompanying_value = "";
                $intermittent_value = "";
                $interrupting_value = "";
                if($row->accompanying) {
                    $accompanying_value = "<span class=''>Accompanying</span>";
                    if(($req_accompanying != $row->accompanying)){
                        $conflict = true;
                        $accompanying_value = "<span class='red'>Accompanying</span>";
                    }
                }
                if($row->intermittent) {
                    $intermittent_value = "<span class=''>Intermittent</span>";
                    if(($req_intermittent != $row->intermittent)){
                        $conflict = true;
                        $intermittent_value = "<span class='red'>Intermittent</span>";
                    }
                }
                if($row->interrupting) {
                    $interrupting_value = "<span class=''>Interrupting</span>";
                    if(($req_interrupting != $row->interrupting)){
                        $conflict = true;
                        $interrupting_value = "<span class='red'>Interrupting</span>";
                    }
                }
            ?>
            <tr>
                <th scope="row">{{ $i }}</th>
                <td>
                    {{ $row->context_name }} <br/>
                    <span class="small">Ratings:
                        <span id="avg_rating_{{ $row->id }}" class="average_rating">{{ number_format($row->avg_rating, 1) }}</span> / 5
                        by <span id="rating_count_{{ $row->id }}">{{ $row->rating_count }}</span> {{{ ($row->rating_count > 1) ? 'users' : 'user' }}}
                    </span>
                </td>
                <td>{{ $row->scenario }}</td>
                <td>
                    <div class="frm_ways_of_interaction">
                        @if(isset($accompanying_value))
                        <div class="form-group">
                            {!! $accompanying_value !!}
                        </div>
                        @endif
                        @if(isset($intermittent_value))
                        <div class="form-group">
                            {!! $intermittent_value !!}
                        </div>
                        @endif
                        @if(isset($interrupting_value))
                        <div class="form-group">
                            {!! $interrupting_value !!}
                        </div>
                        @endif
                    </div>
                </td>
                <td>
                    @if($conflict)
                        <form class="form_remarks_{{ $row->id }}" style="{{{ ($row->remarks != "") ? 'display: none;' : 'display: block;' }}}">
                            <input type="text" name="remarks_{{ $row->id }}" value="{{ $row->remarks }}" placeholder="Add remarks here!" class="form-control" required="required" />
                            <a href="javascript:;" class="add_remarks btn btn-sm btn-default" data-context-id="{{ $row->id }}" style="margin-top: 5px;">Add Remarks</a>
                        </form>

                        <span class="remarks_{{ $row->id }} remarks_holder" data-context-id="{{ $row->id }}" title="Double click to edit!!!">{{ $row->remarks }}</span>
                    @else
                        --
                    @endif
                </td>
            </tr>
            <?php $i++; ?>
        @endforeach
        </tbody>
    </table>

    <script type="text/javascript">
        $(document).ready(function(){
            $(".add_remarks").click(function(){
                var context_id = $(this).data('context-id');
                var remarks = $("input[name=remarks_"+ context_id +"]").val();
                if(remarks == ''){
                    return false;
                }
                $.blockUI();
                $.ajax({
                    type: "POST",
                    url: '<?php echo URL::to('save-remarks') ?>',
                    data: {'remarks': remarks, 'context_id': context_id, '_token': $('meta[name=csrf-token]').attr('content')},
                    success: function(data) {
                        if(data.status == 'success'){
                            $(".form_remarks_" + context_id).hide();
                            $(".remarks_" + context_id).html(remarks);
                            $(".remarks_" + context_id).show();
                        }
                        $.unblockUI();
                    }
                });
            });


            $(".remarks_holder").dblclick(function(){
                var context_id = $(this).data('context-id');
                $(this).hide();
                $(".form_remarks_" + context_id).show();
            });
        });
    </script>

@stop