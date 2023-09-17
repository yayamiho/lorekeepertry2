<h3>Stages</h3>
<div class="row mt-3 mb-3">
    <div class="col">
        {!! Form::label('Stage 2 days') !!} {!! add_help('How many days does it take this seed to reach stage 2?') !!}
        {!! Form::number('stage_2_days', isset($tag->getData()['stage_2_days'])? $tag->getData()['stage_2_days'] : 2,  ['class' => 'form-control']) !!}  
    </div>
    <div class="col">
        {!! Form::label('Stage 3 days') !!} {!! add_help('How many days does it take this seed to reach stage 3?') !!}
        {!! Form::number('stage_3_days', isset($tag->getData()['stage_3_days'])? $tag->getData()['stage_3_days'] : 3,  ['class' => 'form-control']) !!}  
    </div>
    <div class="col">
        {!! Form::label('Stage 4 days') !!} {!! add_help('How many days does it take this seed to reach stage 4?') !!}
        {!! Form::number('stage_4_days', isset($tag->getData()['stage_4_days'])? $tag->getData()['stage_4_days'] : 4,  ['class' => 'form-control']) !!}  
    </div>
    <div class="col">
        {!! Form::label('Stage 5 days') !!} {!! add_help('How many days does it take this seed to reach stage 5?') !!}
        {!! Form::number('stage_5_days', isset($tag->getData()['stage_5_days'])? $tag->getData()['stage_5_days'] : 5,  ['class' => 'form-control']) !!}  
    </div>
</div>


<h3>Rewards</h3>

<p>These are the rewards that will be distributed to the user when they harvest from a stage 5 plot that had this seed planted.</p>

@include('widgets._loot_select', ['loots' => $tag->getData()['rewards'], 'showLootTables' => true, 'showRaffles' => true])

