<?php if ($data['product'] !== null && $data['ratings'] !== null && $data['user'] !== null) { ?>

<?php $beginForm('Rating', 'Send', ['p' => $data['product']->getId()], method: 'post'); ?>
<div class="container border p-4">
    <h2>Your rating: </h2>
    <div class="row pb-4">
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

    <button class="btn btn-warning">Send</button>
    
    <label for="date">Last update:</label>
    <input type="text" type="date" id="date" value="<?php if($data['rating']) $htmlOut($data['rating']->getDate()) ?>" disabled>
</div>
  
<?php $endForm(); ?>
    
<?php } ?>