

<div class="row justify-content-center">
    <img src="{{ (!isset($userPlot)) ? $userArea->area->plotImageUrl : $userPlot->plot->getStageImage($userPlot->stage) }}" style="max-width:100%;" alt="plot" />
</div>


@if(!isset($userPlot))
<div class="alert alert-warning" role="alert">
  This plot is not ready for cultivation yet. You will have to prepare it with a tool!
</div>
@endif
@if(isset($userPlot) && $userPlot->stage <= 1)
<div class="alert alert-success" role="alert">
  This plot is ready for cultivation! 
</div>
@endif
@if(isset($userPlot) && $userPlot->stage > 1)
<div class="alert alert-success" role="alert">
  This plot is actively cultivating something...make sure to check on it every day!
</div>
@endif

<div class="card mt-3">
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <a class="card-title h5 collapse-title" data-toggle="collapse" href="#prepareForm">Prepare Plot</a>
            <div id="prepareForm" class="collapse">
                <p>Prepare the plot by using a tool. You may also change the plot type by using a tool on an already prepared plot. However, you will lose its progress.</p>
                {!! Form::open(['url' => 'cultivation/plots/prepare/'.$plotNumber]) !!}
                <div class="row justify-content-center">
                    <div class="col-md-10 text-center">
                        <div class="form-group">
                            {!! Form::select('tool_id', $userTools, null, ['class' => 'form-control', 'placeholder' => 'Select Tool']) !!}
                            {!! Form::hidden('area_id', $userArea->id, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-2 text-center">
                        <div class="form-group">
                            {!! Form::submit('Prepare Plot', ['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </li>
        @if(isset($userPlot))
        @if($userPlot->stage > 1)
        <li class="list-group-item">
            <a class="card-title h5 collapse-title" data-toggle="collapse" href="#nameForm">Tend to plot</a>
            <div id="nameForm" class="collapse">
                <p>Tend to the plot to help its growth.</p>

            </div>
        </li>
        @endif
        <li class="list-group-item">
            <a class="card-title h5 collapse-title" data-toggle="collapse" href="#nameForm">Cultivate</a>
            <div id="nameForm" class="collapse">
                <p>Place an item to cultivate something. You may place an item even if there is already something cultivating here, but you will lose its progress.</p>
                {!! Form::open(['url' => 'cultivation/plots/cultivate/'.$plotNumber]) !!}
                <div class="row justify-content-center">
                    <div class="col-md-10 text-center">
                        <div class="form-group">
                            {!! Form::select('seed_id', $userSeeds, null, ['class' => 'form-control', 'placeholder' => 'Select Item']) !!}
                            {!! Form::hidden('area_id', $userArea->id, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-2 text-center">
                        <div class="form-group">
                            {!! Form::submit('Cultivate', ['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </li>
        @endif

    </ul>
</div>


