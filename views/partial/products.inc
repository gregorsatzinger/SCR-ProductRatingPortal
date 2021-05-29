<?php if ($data['products'] !== null) { ?>
    <?php if (sizeof($data['products']) > 0) { ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Producer</th>
                    <th>Creator</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['products'] as $product) { ?>
                    <tr>
                        <td><?php $htmlOut($product->getId()); ?></td>
                        <td><?php $htmlOut($product->getName()); ?></td>
                        <td><?php $htmlOut($product->getProducer()); ?></td>
                        <td><?php $htmlOut($product->getCreatorName()); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>No products found.</p>
    <?php } ?>
<?php } ?>