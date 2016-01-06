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
            <th width="40%">Scenario</th>
            <th width="25%">Ways of Interaction</th>
            <th width="10%">Added By</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1; ?>
        @foreach($context as $row)
            <?php
                $row = (object) $row;

                // show conflicted ways of interaction in red color
                //$accompanying_count = 0;
                //$intermittent_count = 0;
                //$interrupting_count = 0;

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
                    {{ $row->context_name }} <br/>
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
                <td>{{ $row->user_name }}</td>
            </tr>
            <?php $i++; ?>
        @endforeach
        </tbody>
    </table>
@stop