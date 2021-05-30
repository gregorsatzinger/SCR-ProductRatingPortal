<?php $render('partial/header', $data); ?>

<h1>Search</h1>

<div class="my-3">
    <?php $beginForm('Product', 'Search') ?>
    <div class="row g-3">
        <div class="col-auto">
            <input class="form-control" name="f" value="<?php $htmlOut($data['filter']) ?>"></input>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary">Search</button>
        </div>
    </div>
    <?php $endForm(); ?>
</div>

<?php $render('partial/products', $data); ?>

<?php $render('partial/footer', $data); ?>