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
                @if($requirement->accompanying)
                    Accompanying<br/>
                @endif
                @if($requirement->intermittent)
                    Intermittent<br/>
                @endif
                @if($requirement->interrupting)
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
            <?php $row = (object) $row; ?>
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
                        <div class="form-group">
                            <span>Accompanying</span>
                            ( <span class="interaction_count">{{{ ($row->accompanying_count) ? $row->accompanying_count : '0' }}}</span> )
                        </div>
                        <div class="form-group">
                            <span>Intermittent</span>
                            ( <span class="interaction_count">{{{ ($row->intermittent_count) ? $row->intermittent_count : '0' }}}</span> )
                        </div>
                        <div class="form-group">
                            <span>Interrupting</span>
                            ( <span class="interaction_count">{{{ ($row->interrupting_count) ? $row->interrupting_count : '0' }}}</span> )
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