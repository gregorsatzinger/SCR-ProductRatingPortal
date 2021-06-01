<?php if ($data['products'] !== null) { ?>
    <?php if (sizeof($data['products']) > 0) { ?>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Producer</th>
                    <th>Creator</th>
                    <th>Rating</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['products'] as $product) { ?>
                    <tr>
                        <td><?php $htmlOut($product->getId()); ?></td>
                        <td>
                            <?php $beginForm('Rating', 'Index', ['p' => $product->getId()], 'get', 'form-inline'); ?>
                            <button class="button-link"><?php $htmlOut($product->getName()); ?></button>
                            <?php $endForm(); ?>
                        </td>
                        <td><?php $htmlOut($product->getProducer()); ?></td>
                        <td><?php $htmlOut($product->getCreatorName()); ?></td>
                        <td><?php $htmlOut($product->getAvgRating()); ?> <i>( <?php $htmlOut($product->getRatingCount()); ?> Ratings)</i></td>
                        <td>
                        <?php if($data['user'] != null && $data['user']->getUserName() === $product->getCreatorName()) { ?>
                        <?php $beginForm('Product', 'Edit', 
                        ['p' => $product->getId(), 'pn' => $product->getName(), 'pc' => $product->getProducer()], 
                        method: 'get'); ?>
                        <button class="btn btn-warning">Edit</button>
                        <?php $endForm(); ?>
                        <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>No products found.</p>
    <?php } ?>
<?php } ?>