<?php
/**
 * @var array[] $variations @see {@link \Domain\Products\DTOs\VariationAdminDTO}
 */
?>
<div class="row">
    <button type="button" data-toggle="modal" data-target="#variation-new" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Добавить элемент</button>
</div>

<table class="table">
    <thead>
        <tr>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($variations as $variation)
            <tr>

            </tr>
        @endforeach
    </tbody>
</table>


