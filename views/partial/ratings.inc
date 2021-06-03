<?php if ($data['ratings'] !== null) { ?>
    <h1><?php $htmlOut($data['product']->getName()); ?></h1>
    <h2>
    Customer ratings: (&Oslash;<?php $htmlOut($data['product']->getAvgRating());?>)
    </h2>
                
    <?php if (sizeof($data['ratings']) > 0) { ?>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Creator</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['ratings'] as $rating) { ?>
                    <tr>
                        <td class="col-1"><?php $htmlOut($rating->getCreatorName()); ?></td>
                        <td class="col-1"><?php $htmlOut($rating->getRating()); ?></td>
                        <td><?php $htmlOut($rating->getComment()); ?></td>
                        <td class="col-1"><?php $htmlOut($rating->getDate()); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>No ratings found.</p>
    <?php } ?>
<?php } ?>