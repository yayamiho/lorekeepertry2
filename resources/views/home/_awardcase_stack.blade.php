@if(!$stack)
    <div class="text-center">Invalid stack selected.</div>
@else
    <div class="text-center">
        @if($award->has_image)
            <div class="mb-1"><a href="{{ $award->url }}"><img src="{{ $award->imageUrl }}" alt="{{ $award->name }}"/></a></div>
        @endif
    </div>

    <h5>Award Variations</h5>

    {!! Form::open(['url' => 'inventory/edit']) !!}
    <div class="card" style="border: 0px">
        <table class="table table-sm">
            <thead class="thead">
                <tr class="d-flex">
                    @if($user && !$readOnly && ($stack->first()->user_id == $user->id || $user->hasPower('edit_awardcases')))
                        <th class="col-1"><input id="toggle-checks" type="checkbox" onclick="toggleChecks(this)"></th>
                        <th class="col-4">Source</th>
                    @else
                        <th class="col-5">Source</th>
                    @endif
                    <th class="col-3">Notes</th>
                    <th class="col-3">Quantity</th>
                    <th class="col-1"><i class="fas fa-lock invisible"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach($stack as $awardRow)
                    <tr id ="awardRow{{ $awardRow->id }}" class="d-flex {{ $awardRow->isTransferrable ? '' : 'accountbound' }}">
                        @if($user && !$readOnly && ($stack->first()->user_id == $user->id || $user->hasPower('edit_awardcases')))
                            <td class="col-1">{!! Form::checkbox('ids[]', $awardRow->id, false, ['class' => 'award-check', 'onclick' => 'updateQuantities(this)']) !!}</td>
                            <td class="col-4">{!! array_key_exists('data', $awardRow->data) ? ($awardRow->data['data'] ? $awardRow->data['data'] : 'N/A') : 'N/A' !!}</td>
                        @else
                            <td class="col-5">{!! array_key_exists('data', $awardRow->data) ? ($awardRow->data['data'] ? $awardRow->data['data'] : 'N/A') : 'N/A' !!}</td>
                        @endif
                        <td class="col-3">{!! array_key_exists('notes', $awardRow->data) ? ($awardRow->data['notes'] ? $awardRow->data['notes'] : 'N/A') : 'N/A' !!}</td>
                        @if($user && !$readOnly && ($stack->first()->user_id == $user->id || $user->hasPower('edit_awardcases')))
                            @if($awardRow->availableQuantity)
                                <td class="col-3">{!! Form::selectRange('', 1, $awardRow->availableQuantity, 1, ['class' => 'quantity-select', 'type' => 'number', 'style' => 'min-width:40px;']) !!} /{{ $awardRow->availableQuantity }} @if($awardRow->getOthers()) {{ $awardRow->getOthers() }} @endif</td>
                            @else
                                <td class="col-3">{!! Form::selectRange('', 0, 0, 0, ['class' => 'quantity-select', 'type' => 'number', 'style' => 'min-width:40px;', 'disabled']) !!} /{{ $awardRow->availableQuantity }} @if($awardRow->getOthers()) {{ $awardRow->getOthers() }} @endif</td>
                            @endif
                        @else
                            <td class="col-3">{!! $awardRow->count !!}</td>
                        @endif
                        <td class="col-1">
                            @if(!$awardRow->isTransferrable)
                                <i class="fas fa-lock" data-toggle="tooltip" title="Account-bound awards cannot be transferred but can be deleted."></i>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($user && !$readOnly && ($stack->first()->user_id == $user->id || $user->hasPower('edit_awardcases')))
        <div class="card mt-3 p-3">

            @if(isset($award->category) && $award->category->is_character_owned)
                <a class="card-title h5 collapse-title" data-toggle="collapse" href="#characterTransferForm">@if($stack->first()->user_id != $user->id) [ADMIN] @endif Transfer Award to Character</a>
                <div id="characterTransferForm" class="collapse">
                    <p>This will transfer this stack or stacks to this character's inventory.</p>
                    <div class="form-group">
                        {!! Form::select('character_id', $characterOptions, null, ['class' => 'form-control mr-2 default character-select', 'placeholder' => 'Select Character']) !!}
                    </div>
                    <div class="text-right">
                        {!! Form::button('Transfer', ['class' => 'btn btn-primary', 'name' => 'action', 'value' => 'characterTransfer', 'type' => 'submit']) !!}
                    </div>
                </div>
            @endif
            @if(config('lorekeeper.extensions.awards.allow_transfers', '0') || ($user && $user->hasPower('edit_awardcases')))
                @if($user && $user->hasPower('edit_awardcases'))
                    <p class="alert alert-warning my-2">Note: Your rank allows you to transfer account-bound awards to another user.</p>
                @endif
                <h5 class="card-title collapse-title">
                    <a class="h5 awardcase-collapse-toggle collapse-toggle collapsed" href="#transferForm" data-toggle="collapse">@if($stack->first()->user_id != $user->id) [ADMIN] @endif Transfer Award</a></h3>
                </h5>
                <div id="transferForm" class="collapse">
                    <div class="form-group">
                        {!! Form::label('user_id', 'Recipient') !!} {!! add_help('You can only transfer awards to verified users.') !!}
                        {!! Form::select('user_id', $userOptions, null, ['class'=>'form-control']) !!}
                    </div>
                    <div class="text-right">
                        {!! Form::button('Transfer', ['class' => 'btn btn-primary', 'name' => 'action', 'value' => 'transfer', 'type' => 'submit']) !!}
                    </div>
                </div>
            @endif

            <h5 class="card-title collapse-title">
                <a class="h5 awardcase-collapse-toggle collapse-toggle collapsed" href="#deleteForm" data-toggle="collapse">@if($stack->first()->user_id != $user->id) [ADMIN] @endif Delete Award</a></h3>
            </h5>
            <div id="deleteForm" class="collapse">
                <p>This action is not reversible. Are you sure you want to delete this award?</p>
                <div class="text-right">
                    {!! Form::button('Delete', ['class' => 'btn btn-danger', 'name' => 'action', 'value' => 'delete', 'type' => 'submit']) !!}
                </div>
            </div>

        </div>
    @endif
    {!! Form::close() !!}
@endif

<script>
    $(document).keydown(function(e) {
    var code = e.keyCode || e.which;
    if(code == 13)
        return false;
    });
    $('.default.character-select').selectize();
    function toggleChecks($toggle) {
        $.each($('.award-check'), function(index, checkbox) {
            $toggle.checked ? checkbox.setAttribute('checked', 'checked') : checkbox.removeAttribute('checked');
            updateQuantities(checkbox);
        });
    }
    function updateQuantities($checkbox) {
        var $rowId = "#awardRow" + $checkbox.value
        $($rowId).find('.quantity-select').prop('name', $checkbox.checked ? 'quantities[]' : '')
    }
</script>

