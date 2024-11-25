@if (!$stack)
    <div class="text-center">
        Invalid stack selected.
    </div>
@else
    <div class="text-center">
        @if ($item->has_image)
            <div class="mb-1"><a href="{{ $item->url }}"><img src="{{ $item->imageUrl }}" class="img-fluid" alt="{{ $item->name }}" /></a></div>
        @endif
        <div @if (count($item->tags)) class="mb-1" @endif><a href="{{ $item->idUrl }}">{{ $item->name }}</a></div>
        @if (count($item->tags))
            <div>
                @foreach ($item->tags as $tag)
                    @if ($tag->is_active)
                        {!! $tag->displayTag !!}
                        @if ($tag->is_active && View::exists('world.tags._' . $tag->tag))
                            @include('world.tags._' . $tag->tag, ['tag' => $tag])
                        @endif
                    @endif
                @endforeach
            </div>
        @endif
    </div>

    <h5>Item Variations</h5>
    @if ($user && $user->hasPower('edit_inventories'))
        <p class="alert alert-warning my-2">Note: Your rank allows you to transfer account-bound items to another user.</p>
    @endif

    {!! Form::open(['url' => 'inventory/edit']) !!}
    <div class="card" style="border: 0px">
        <table class="table table-sm">
            <thead class="thead">
                <tr class="d-flex" style="display:block !important">
                    @if($user && !$readOnly &&  ($user->hasPower('edit_inventories') ||  $owner_id == $user->id))
                        <th class="col-1"><input id="toggle-checks" type="checkbox" onclick="toggleChecks(this)"></th>
                    @endif
                    @if($item->category->can_name)
                        <th class="col-2">Name</th>
                    @endif
                    <th class="col-5">Source</th>
                    <th class="col-3">Notes</th>
                    <th class="col-3">Quantity</th>
                    <th class="col-1"><i class="fas fa-lock invisible"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stack as $itemRow)
                    <tr id="itemRow{{ $itemRow->id }}" class="d-flex {{ $itemRow->isTransferrable ? '' : 'accountbound' }}" style="display:block !important">
                        @if($user && !$readOnly && ($user->hasPower('edit_inventories') ||  $owner_id == $user->id))
                            <td class="col-1">{!! Form::checkbox('ids[]', $itemRow->id, false, ['class' => 'item-check', 'onclick' => 'updateQuantities(this)']) !!}</td>
                            <td class="col-4">{!! array_key_exists('data', $itemRow->data) ? ($itemRow->data['data'] ? $itemRow->data['data'] : 'N/A') : 'N/A' !!}</td>
                        @endif
                        @if($item->category->can_name)
                            <td class="col-2">{!! htmlentities($itemRow->stack_name) ? : 'N/A' !!}</td> 
                        @endif
                        <td class="col-3">{!! array_key_exists('notes', $itemRow->data) ? ($itemRow->data['notes'] ? $itemRow->data['notes'] : 'N/A') : 'N/A' !!}</td>
                        @if($user && !$readOnly && 
                        ($user->hasPower('edit_inventories') ||  $owner_id == $user->id))
                            @if ($itemRow->availableQuantity)
                                <td class="col-3">{!! Form::selectRange('', 1, $itemRow->availableQuantity, 1, ['class' => 'quantity-select', 'type' => 'number', 'style' => 'min-width:40px;']) !!} /{{ $itemRow->availableQuantity }} 
                                    @if ($itemRow->getOthers()) {{ $itemRow->getOthers() }}
                                    @endif
                                </td>
                            @else
                                <td class="col-3">{!! Form::selectRange('', 0, 0, 0, ['class' => 'quantity-select', 'type' => 'number', 'style' => 'min-width:40px;', 'disabled']) !!} /{{ $itemRow->availableQuantity }} @if ($itemRow->getOthers())
                                        {{ $itemRow->getOthers() }}
                                    @endif
                                </td>
                            @endif
                        @else
                            <td class="col-3">{!! $itemRow->count !!}</td>
                        @endif
                        <td class="col-1">
                            @if (!$itemRow->isTransferrable || $user->hasPower('edit_inventories'))
                                <i class="fas fa-lock" data-toggle="tooltip" title="Account-bound items cannot be transferred{!! $item->is_deletable ? ', but can be deleted.' : '.' !!}"></i>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($user && !$readOnly && ($user->hasPower('edit_inventories') ||  $owner_id == $user->id))
        <div class="card mt-3">
            <ul class="list-group list-group-flush">

            @if (count($item->tags))
                    @foreach ($item->tags as $tag)
                        @if ($tag->is_active && View::exists('inventory._' . $tag->tag))
                            @include('inventory._' . $tag->tag, ['stack' => $stack, 'tag' => $tag])
                        @endif
                    @endforeach
                @endif


                <!--NAME-->
                @if($item->category->can_name)
                <li class="list-group-item">
                    <a class="card-title h5 collapse-title" data-toggle="collapse" href="#nameForm">
                       @if ($user->hasPower('edit_inventories') && $owner_id != $user -> id) 
                            [ADMIN] 
                            @endif 
                             Name Item</a>
                    <div id="nameForm" class="collapse">
                        <p>Enter a name to display for the selected stack(s)! Note that only one of the stacks' names will display on the inventory page and title of this panel, while other stacks' names will appear in the list above.</p>
                        {!! Form::open() !!}
                            <div class="form-group">
                                {!! Form::text('stack_name', null, ['class' => 'form-control stock-field', 'data-name' => 'stack_name']) !!}
                            </div>
                            <div class="text-right">
                                {!! Form::button('Submit', ['class' => 'btn btn-primary', 'name' => 'action', 'value' => 'name', 'type' => 'submit']) !!}
                            </div>
                        {!! Form::close() !!}
                </div>
                </li>
                @endif

                <!--DONATE-->
                @if($item->canDonate || $user->hasPower('edit_inventories'))
                    
                    <li class="list-group-item">
                        <a class="card-title h5 collapse-title" data-toggle="collapse" href="#donateForm">
                        @if ($user->hasPower('edit_inventories') && $owner_id != $user -> id) 
                            [ADMIN] 
                            @endif 
                            Donate Item</a>
                        <div id="donateForm" class="collapse">
                            <p>This will donate this item to the <a href="{{ url('shops/donation-shop') }}">Donation Shop</a>, where it will be available for other users to take. This action is not reversible. Are you sure you want to donate this item?</p>
                            <div class="text-right">
                                {!! Form::button('Donate', ['class' => 'btn btn-warning', 'name' => 'action', 'value' => 'donate', 'type' => 'submit']) !!}
                            </div>
                        </div>
                    </li>
                @endif

                <!--RESELL-->
                @if (isset($item->data['resell']) && App\Models\Currency\Currency::where('id', $item->resell->flip()->pop())->first() && config('lorekeeper.extensions.item_entry_expansion.resale_function'))
                    <li class="list-group-item">
                        <a class="card-title h5 collapse-title" data-toggle="collapse" href="#resellForm">
                            @if ($user->hasPower('edit_inventories') && $owner_id != $user -> id)
                                [ADMIN]
                            @endif 
                            Sell Item
                        </a>
                        <div id="resellForm" class="collapse">
                            <p>This item can be sold for <strong>{!! App\Models\Currency\Currency::find($item->resell->flip()->pop())->display($item->resell->pop()) !!}</strong>. This action is not reversible. Are you sure you want to sell this item?</p>
                            <div class="text-right">
                                {!! Form::button('Sell', ['class' => 'btn btn-danger', 'name' => 'action', 'value' => 'resell', 'type' => 'submit']) !!}
                            </div>
                        </div>
                    </li>
                @endif

                <!--CHARACTER TRANSFER-->
                    @if(isset($item->category) && $item->category->is_character_owned)
                    <li class="list-group-item">
                        <a class="card-title h5 collapse-title" data-toggle="collapse" href="#characterTransferForm">
                            @if ($user->hasPower('edit_inventories') && $owner_id != $user -> id) 
                            [ADMIN] 
                            @endif 
                            Transfer Item to Character</a>
                        <div id="characterTransferForm" class="collapse">
                            <p>This will transfer this stack or stacks to this character's inventory.</p>
                            <div class="form-group">
                                {!! Form::select('character_id', $characterOptions, null, ['class' => 'form-control mr-2 default character-select', 'placeholder' => 'Select Character']) !!}
                            </div>
                            <div class="text-right">
                                {!! Form::button('Transfer', ['class' => 'btn btn-primary', 'name' => 'action', 'value' => 'characterTransfer', 'type' => 'submit']) !!}
                            </div>
                        </div>
                    </li>

                    @endif

                <!--TRANSFER-->
                @if ($item->allow_transfer || $user->hasPower('edit_inventories'))
                <li class="list-group-item">
 
                <a class="card-title h5 collapse-title" data-toggle="collapse" href="#transferForm">
                            @if ($user->hasPower('edit_inventories') && $owner_id != $user -> id)
                            [ADMIN] 
                            @endif 
                            Transfer Item
                    </a>
                    <div id="transferForm" class="collapse">
                    <p>This will transfer this item back to this user's inventory.</p>
                        <div class="form-group">
                            {!! Form::label('user_id', 'Recipient') !!} {!! add_help('You can only transfer items to verified users.') !!}
                            {!! Form::select('user_id', $userOptions, null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="text-right">
                            {!! Form::button('Transfer', ['class' => 'btn btn-primary', 'name' => 'action', 'value' => 'transfer', 'type' => 'submit']) !!}
                        </div>
                    </div>
                </li>
                @endif
                <!--DELETE-->
                @if ($item->is_deletable || $user->hasPower('edit_inventories'))
                    <li class="list-group-item">
                        <a class="card-title h5 collapse-title" data-toggle="collapse" href="#deleteForm">
                        @if ($user->hasPower('edit_inventories') && $owner_id != $user -> id)
                            [ADMIN] 
                            @endif 
                            Delete Item
                        </a>
                        <div id="deleteForm" class="collapse">
                            <p>This action is not reversible. Are you sure you want to delete this item?</p>
                            <div class="text-right">
                                {!! Form::button('Delete', ['class' => 'btn btn-danger', 'name' => 'action', 'value' => 'delete', 'type' => 'submit']) !!}
                            </div>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    @endif
    {!! Form::close() !!}
@endif

<script>
    $(document).keydown(function(e) {
        var code = e.keyCode || e.which;
        if (code == 13)
            return false;
    });
    $('.default.character-select').selectize();

    function toggleChecks($toggle) {
        $.each($('.item-check'), function(index, checkbox) {
            $toggle.checked ? checkbox.setAttribute('checked', 'checked') : checkbox.removeAttribute('checked');
            updateQuantities(checkbox);
        });
    }

    function updateQuantities($checkbox) {
        var $rowId = "#itemRow" + $checkbox.value
        $($rowId).find('.quantity-select').prop('name', $checkbox.checked ? 'quantities[]' : '')
    }
</script>
