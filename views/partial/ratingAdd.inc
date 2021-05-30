<?php if ($data['product'] !== null && $data['ratings'] !== null && $data['user'] !== null) { ?>

<?php $beginForm('Rating', 'Create', ['p' => $data['product']->getId()], method: 'post'); ?>
<div class="container border p-4">
    <h2>Add rating</h2>
    <div class="row">
        <div class="col-1">
        <label for="rating" class="form-label">Rating</label>
        <select class="form-control" name="rt" id="rating">
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
        </select>
        </div>
        <div class="col">
        <label for="comment" class="form-label">Comment</label>
        <textarea class="form-control" id="comment" name="ct" value="" rows="5"></textarea>
        </div>
    </div>
    <button class="btn btn-warning">Save</button>

</div>
  
<?php $endForm(); ?>
    
<?php } ?>