<h3>Trait</h3>

<p>This item can grant these traits to a design when added to the myo/design update submission.</p>


<div class="text-right mb-3">
    <a href="#" class="btn btn-outline-info" id="addTrait">Add traits</a>
</div>


<table class="table table-sm" id="traitTable">

    <tbody id="traitTableBody">
        <tr class="loot-row hide">
            <td class="loot-row-select">
                {!! Form::select('feature_id[]', $features, null, ['class' => 'form-control item-select', 'placeholder'
                => 'Select Trait']) !!}
            </td>
            <td class="text-right"><a href="#" class="btn btn-danger remove-trait-button">Remove</a></td>
        </tr>
        @if($tag->getData() != null && count($tag->getData()) > 0)
        @foreach($tag->getData() as $feature_id)
        <tr class="loot-row">
            <td class="loot-row-select">
                {!! Form::select('feature_id[]', $features, $feature_id, ['class' => 'form-control item-select',
                'placeholder' => 'Select Trait']) !!}

            </td>
            <td class="text-right"><a href="#" class="btn btn-danger remove-trait-button">Remove</a></td>
        </tr>
        @endforeach
        @endif

    </tbody>
</table>

<script>
$(document).ready(function() {
    var $traitTable = $('#traitTableBody');
    var $traitRow = $('#traitTableBody').find('.hide');

    $('#traitTableBody .selectize').selectize();
    attachRemoveListener($('#traitTableBody .remove-trait-button'));


    $('#addTrait').on('click', function(e) {
        e.preventDefault();
        var $clone = $traitRow.clone();
        $clone.removeClass('hide');

        $traitTable.append($clone);
        attachRemoveListener($clone.find('.remove-trait-button'));
    });

    function attachRemoveListener(node) {
        node.on('click', function(e) {
            e.preventDefault();
            $(this).parent().parent().remove();
        });
    }
});
</script>