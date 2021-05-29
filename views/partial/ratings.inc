<?php if ($data['ratings'] !== null) { ?>
    <h1><?php $htmlOut($data['product']->getName()); ?></h1>
    <h2>
    Ratings: (&Oslash;<?php $htmlOut($data['product']->getAvgRating());?>)
    </h2>
                
    <?php if (sizeof($data['ratings']) > 0) { ?>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Creator</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['ratings'] as $product) { ?>
                    <tr>
                        <td><?php $htmlOut($product->getId()); ?></td>
                        <td><?php $htmlOut($product->getCreatorName()); ?></td>
                        <td><?php $htmlOut($product->getRating()); ?></td>
                        <td><?php $htmlOut($product->getComment()); ?></td>
                        <td><?php $htmlOut($product->getDate()); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>No ratings found.</p>
    <?php } ?>
<?php } ?>