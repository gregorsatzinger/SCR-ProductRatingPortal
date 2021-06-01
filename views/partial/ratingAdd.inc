<?php if ($data['product'] !== null && $data['ratings'] !== null && $data['user'] !== null) { ?>

<div class="container border p-4">
    <h2>Your rating: </h2>
    <?php $beginForm('Rating', 'Send', ['p' => $data['product']->getId()], method: 'post'); ?>
    <div class="row">
        <div class="col-1">
        <label for="rating" class="form-label">Rating</label>
        <select class="form-control" name="rt" id="rating" value="3">
            <option <?php if($data['rating'] && $data['rating']->getRating() == 1) echo "selected" ?>>1</option>
            <option <?php if($data['rating'] && $data['rating']->getRating() == 2) echo "selected" ?>>2</option>
            <option <?php if($data['rating'] && $data['rating']->getRating() == 3) echo "selected" ?>>3</option>
            <option <?php if($data['rating'] && $data['rating']->getRating() == 4) echo "selected" ?>>4</option>
            <option <?php if($data['rating'] && $data['rating']->getRating() == 5) echo "selected" ?>>5</option>
        </select>
        </div>
        <div class="col">
        <label for="comment" class="form-label">Comment</label>
        <textarea class="form-control" id="comment" name="ct" value="" rows="5"><?php if($data['rating']) $htmlOut($data['rating']->getComment())?></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-2">
            <label for="date">Last update:</label>
            <input type="text" type="date" id="date" value="<?php if($data['rating']) $htmlOut($data['rating']->getDate()) ?>" disabled>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-1">
            <button class="btn btn-warning">Send</button>
        </div>
        <div class="col-1">
            <?php $endForm(); ?>
            <?php if($data['rating'] !== null) { ?>
                <?php $beginForm('Rating', 'Delete', ['p' => $data['product']->getId()], method: 'post'); ?>
                <button class="btn btn-danger">Delete</button>
                <?php $endForm(); ?>
            <?php } ?>
        </div>
    </div>
</div>
  
    
<?php } ?>