<?php $render('partial/header', $data); ?>

<div class="container border p-4">
    <?php if($data['productName'] == '') { ?>
        <h1>Create new Products</h1>
    <?php } else { ?>
        <h1>Edit Products</h1>
    <?php } ?>
    <?php $beginForm('Product', 'Send', ['p' => $data['productId']], method: 'post'); ?>
    <div class="row">
        <div class="col-8">
            <label for="name">Product Name:</label>
            <input class="form-control" id="name" name="pn" value="<?php $htmlOut($data['productName']); ?>">
        </div>
        <div class="col">
            <label for="producer">Producer:</label>
            <input class="form-control" id="producer" name="pc" value="<?php $htmlOut($data['producerName']); ?>">
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-1">
            <button class="btn btn-warning">Send</button>
        </div>
    </div>
</div>

<?php $render('partial/footer', $data); ?>