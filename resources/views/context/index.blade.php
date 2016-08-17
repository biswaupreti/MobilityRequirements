<?php
    $project_team = explode(',', $project->project_members);
    array_push($project_team, $project->project_owner);
    $voting_arr = array();
    foreach($context_arr as $item) {
        $voting_arr[$item->id] = ($item->rating > 0) ? $item->rating : 0;
    }
    $voting_json = json_encode($voting_arr);
?>
<div class="row">
    <div class="col-md-10">
        <h3>Context Voting</h3>
    </div>
    <div class="col-md-2">
        @if($project->status == "0")
            <a href="{{ url("/review/$requirement->id") }}" class="btn btn-success pull-right">Review Requirement</a>
            <div class="hide-overlay"></div>
        @else
            <a href="javascript:;" style="display:none;" class="btn btn-success pull-right submit_rating">Submit Context Rating</a>
            <input type="hidden" name="hid_voting_json" class="hid_voting_json" value="{{ $voting_json }}" />
        @endif
    </div>
</div>

<table class="table table-striped" width="100%">
    <thead>
    <tr>
        <th width="5%">#</th>
        <th width="20%">Context</th>
        <th width="45%">Scene</th>
        <th width="20%">Ways of Interaction</th>
        <!--<th width="10%">Added By</th>-->
        <th width="10%">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php $i = 1; ?>
    @foreach($context_arr as $row)
        <tr>
            <th scope="row">{{ $i }}</th>
            <td>
                {{ $row->context_name }} 
                <br/>
                <small>( {{ $row->full_name }} )</small>
                <br/>
                <select class="context-rating" name="rating">
                    <option value=""></option>
                    <option value="1" data-html="{{ $row->id }}" {{{ ($row->rating == 1) ? "selected='selected'" : '' }}}>1</option>
                    <option value="2" data-html="{{ $row->id }}" {{{ ($row->rating == 2) ? "selected='selected'" : '' }}}>2</option>
                    <option value="3" data-html="{{ $row->id }}" {{{ ($row->rating == 3) ? "selected='selected'" : '' }}}>3</option>
                    <option value="4" data-html="{{ $row->id }}" {{{ ($row->rating == 4) ? "selected='selected'" : '' }}}>4</option>
                    <option value="5" data-html="{{ $row->id }}" {{{ ($row->rating == 5) ? "selected='selected'" : '' }}}>5</option>
                </select>
                <span class="small">Ratings:
                    <span id="avg_rating_{{ $row->id }}" class="average_rating">{{ number_format($row->avg_rating, 1) }}</span> / 5
                    by <span id="rating_count_{{ $row->id }}">{{ $row->rating_count }}</span> {{{ ($row->rating_count > 1) ? 'users' : 'user' }}}
                </span>
            </td>
            <td>
                @if($row->scenes)
                    <ul>
                    @foreach($row->scenes as $item)
                        <li>
                            @if($item['context_scene_user'] == $authUser->id)
                                <span style="color: #00AA00;">{!! $item['scene'] .'<br/>' !!}</span>
                            @else
                                {!! $item['scene']. ' - <strong><i>' . $item['user_name'] .'</i></strong><br/>' !!}
                            @endif
                        </li>
                    @endforeach
                    </ul>
                @endif

            </td>
            <td>
                <form action="#" class="frm_ways_of_interaction">
                    <div class="form-group">
                        {!! Form::checkbox('accompanying', '1', ($row->accompanying == '1') ? 'checked' : '', array('data-context-id' => $row->id, 'class' => 'interaction' )) !!}
                        <span>Accompanying</span>
                    </div>
                    <div class="form-group">
                        {!! Form::checkbox('intermittent', '2', ($row->intermittent == '1') ? 'checked' : '', array('data-context-id' => $row->id, 'class' => 'interaction' )) !!}
                        <span>Intermittent</span>
                    </div>
                    <div class="form-group">
                        {!! Form::checkbox('interrupting', '3', ($row->interrupting == '1') ? 'checked' : '', array('data-context-id' => $row->id, 'class' => 'interaction' )) !!}
                        <span>Interrupting</span>
                    </div>
                </form>
            </td>
            <td>
                @if(in_array($authUser->id, $project_team))
                    <a href="{{ url('/context', [$row->id, 'edit']) }}" title="Edit!" class="btn btn-info btn-sm" style="float: left; margin-right: 5px;">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit
                    </a>
                @else
                    <span>--</span>
                @endif
            </td>
        </tr>
        <?php $i++; ?>
    @endforeach
    </tbody>
</table>
<script type="text/javascript">
    $(document).ready(function(){

        // jQuery Bar Rating - bootstrap stars
        $(".context-rating").barrating({
            theme: 'bootstrap-stars',
            onSelect:function(value, text) {

                $(".submit_rating").show();
                var voting_json = $(".hid_voting_json").val();
                var arr = $.parseJSON(voting_json);
                arr[text] = value;
                voting_json = JSON.stringify(arr);
                $(".hid_voting_json").val('');
                $(".hid_voting_json").val(voting_json);
            }
        });

        $(".submit_rating").click(function(){
            $.blockUI();
            var voting_vals = $(".hid_voting_json").val();
            $.ajax({
                type: "POST",
                url: '<?php echo URL::to('save-context-ratings') ?>',
                data: {'ratings': voting_vals, '_token': $('meta[name=csrf-token]').attr('content')},
                success: function(data) {
                    if(data.status == 'success') {
                        $.unblockUI();
                        location.reload();
                    }
                }
            });
        });

        $(".interaction").click(function(){
            var context_id = $(this).data('context-id');
            var interaction = $(this).val();
            var interaction_val;

            if($(this).is(':checked')){
                interaction_val = "1";
            }else{
                interaction_val = "0";
            }
            
            $.blockUI();
            $.ajax({
                type: "POST",
                url: '<?php echo URL::to('save-ways-of-interaction-voting') ?>',
                data: {'interaction': interaction, 'interaction_val': interaction_val, 'context_id': context_id, '_token': $('meta[name=csrf-token]').attr('content')},
                success: function(data) {
                    $.unblockUI();
                }
            });
        });


    });
</script>