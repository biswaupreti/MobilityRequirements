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
            <h3>Context Analysis</h3>
        </div>
    </div>

    <table class="table table-striped" width="100%">
        <thead>
        <tr>
            <th width="5%">#</th>
            <th width="20%">Context</th>
            <th width="30%">Scene</th>
            <th width="20%">Ways of Interaction</th>
            <th width="25%">Remarks</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1; ?>
        @foreach($context as $row)
            <?php
            $row = (object) $row;

            // For Accompanying
            if(is_null($row->accompanying_count)){
                $row->accompanying_count = '0';
            }
            if($req_accompanying && $row->accompanying_count == '0') {
                $accompanying_conflict = true;
                $accompanying_count = "<span class='accompanying_count'>$row->accompanying_count</span>";
            } elseif(!$req_accompanying && $row->accompanying_count > 0){
                $accompanying_conflict = true;
                $accompanying_count = "<span class='accompanying_count'>$row->accompanying_count</span>";
            } else{
                $accompanying_conflict = false;
                $accompanying_count = "<span class='accompanying_count'>$row->accompanying_count</span>";
            }

            // For Intermittent
            if(is_null($row->intermittent_count)){
                $row->intermittent_count = '0';
            }
            if($req_intermittent && $row->intermittent_count == '0') {
                $intermittent_conflict = true;
                $intermittent_count = "<span class='intermittent_count'>$row->intermittent_count</span>";
            } elseif(!$req_intermittent && $row->intermittent_count > 0){
                $intermittent_conflict = true;
                $intermittent_count = "<span class='intermittent_count'>$row->intermittent_count</span>";
            } else{
                $intermittent_conflict = false;
                $intermittent_count = "<span class='intermittent_count'>$row->intermittent_count</span>";
            }

            // For Interrupting
            if(is_null($row->interrupting_count)){
                $row->interrupting_count = '0';
            }
            if($req_interrupting && $row->interrupting_count == '0') {
                $interrupting_conflict = true;
                $interrupting_count = "<span class='interrupting_count'>$row->interrupting_count</span>";
            } elseif(!$req_interrupting && $row->interrupting_count > 0){
                $interrupting_conflict = true;
                $interrupting_count = "<span class='interrupting_count'>$row->interrupting_count</span>";
            } else{
                $interrupting_conflict = false;
                $interrupting_count = "<span class='interrupting_count'>$row->interrupting_count</span>";
            }
            ?>
            <tr>
                <th scope="row">{{ $i }}</th>
                <td>
                    {{ $row->context_name }} 
                <br/>
                <small>( {{ $row->full_name }} )</small><br/>
                    <span class="small">Ratings:
                        <span id="avg_rating_{{ $row->id }}" class="average_rating">{{ number_format($row->avg_rating, 1) }}</span> / 5
                        by <span id="rating_count_{{ $row->id }}">{{ $row->rating_count }}</span> {{{ ($row->rating_count > 1) ? 'users' : 'user' }}}
                    </span>
                </td>
                <td>{{ $row->scenario }}</td>
                <td>
                    <div class="frm_ways_of_interaction">
                        <div class="form-group {{{ ($accompanying_conflict) ? 'red' : '' }}} ">
                            <span>Accompanying</span>
                            ( {!! $accompanying_count !!} )
                        </div>
                        <div class="form-group {{{ ($intermittent_conflict) ? 'red' : '' }}}">
                            <span>Intermittent</span>
                            ( {!! $intermittent_count !!} )
                        </div>
                        <div class="form-group {{{ ($interrupting_conflict) ? 'red' : '' }}}">
                            <span>Interrupting</span>
                            ( {!! $interrupting_count !!} )
                        </div>
                    </div>
                </td>
                <td>
                    @if($accompanying_conflict || $intermittent_conflict || $interrupting_conflict)
                        <form class="form_remarks_{{ $row->id }}" style="display: none;">
                            <textarea name="remarks_{{ $row->id }}" placeholder="Add remarks here!" class="form-control" required="required"></textarea>
                            <a href="javascript:;" class="add_remarks btn btn-sm btn-success" data-context-id="{{ $row->id }}" style="margin-top: 5px;">Save</a>
                            <a href="javascript:;" class="cancel_remarks_form btn btn-sm btn-default" data-context-id="{{ $row->id }}" style="margin-top: 5px;">Cancel</a>
                        </form>

                        <p><a href="javascript:;" class="show_remarks_form" data-context-id="{{ $row->id }}" >Add Remarks</a><p>
                        <p><a href="javascript:;" class="view_remarks" data-context-id="{{ $row->id }}" >View Remarks</a><p>
                    @else
                        <p>--</p>
                    @endif
                </td>
            </tr>
            <?php $i++; ?>
        @endforeach
        </tbody>
    </table>

    <!-- Modal -->
    <div class="remarks_container modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Remarks</h4>
                </div>
                <div class="modal-body">
                    <ol class="remarks-list">
                    </ol>
                    <p class="no-remarks" style="display: none;">No remarks added yet!</p>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            $(".add_remarks").click(function(){
                var context_id = $(this).data('context-id');
                var remarks = $("textarea[name=remarks_"+ context_id +"]").val();
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
                            $(".show_remarks_form").show();
                        }
                        $.unblockUI();
                    }
                });
            });


            $(".cancel_remarks_form").click(function(){
                var context_id = $(this).data('context-id');
                $(".form_remarks_" + context_id).hide();;
                $(".show_remarks_form").show();
            });

            $(".show_remarks_form").click(function(){
                var context_id = $(this).data('context-id');
                $(this).hide();
                $(".form_remarks_" + context_id).show();
            });


            $(".view_remarks").click(function(){
                var context_id = $(this).data('context-id');
                $.ajax({
                    type: "POST",
                    url: '<?php echo URL::to('remarks-list') ?>',
                    data: {'context_id': context_id, '_token': $('meta[name=csrf-token]').attr('content')},
                    success: function(data) {
                        if(data.status == 'success'){
                            //$(".remarks-list").html(data.remarks);
                            $(".no-remarks").hide();
                            $(".remarks-list").html("");
                            $.each(data.remarks, function(key, value) {
                                $(".remarks-list").append("<li>" + value.remarks + " - " + "<strong><i>" + value.name + "</i></strong>" + "</li>");
                            });
                        } else {
                            $(".remarks-list").html("");
                            $(".no-remarks").show();
                        }
                        $(".remarks_container").modal();
                    }
                });
            });
        });
    </script>

@stop