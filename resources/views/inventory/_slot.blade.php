<li class="list-group-item">
    <a class="card-title h5 collapse-title"  data-toggle="collapse" href="#openSlotForm"> Use Slot</a>
    {!! Form::open(['url' => 'inventory/act/'
    
    .'/'.$tag->
    tag, 
    'id' => 'openSlotForm', 
    'class' => 'collapse']) !!}
        <p>This action is not reversible. Are you sure you want to open this box?</p>
        <div class="text-right">
            {!! Form::submit('Open', ['class' => 'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}
</li>
