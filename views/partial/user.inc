<?php if (!isset($data)): ?>
  </nav>
  <nav class="navbar-nav">
    <?php $link('Login', 'User', 'LogIn', cssClass: 'btn btn-warning'); ?>
  </nav>
<?php else: ?>
  <?php $link('New Product', 'Product', 'Edit', cssClass: 'nav-link'); ?>
  </nav>

  <?php $beginForm('User', 'LogOut', method: 'post', cssClass: 'form-inline'); ?>
    <span class="navbar-text me-2">Welcome, <strong class="text-warning"><?php $htmlOut($data->getUserName()); ?></strong>.</span>
    <button class="btn btn-outline-warning">Log out</button>
  <?php $endForm(); ?>
<?php endif; ?>