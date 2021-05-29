<?php $render('partial/header', $data); ?>

<container>
    <div class="row align-items-start p-5">
        <div class="col">
            <h1>Login</h1>
            <?php $beginForm('User', 'LogIn', method: 'post'); ?>
            <div class="mb-3">
                <label for="lUserName" class="form-label">User name</label>
                <input class="form-control" id="lUserName" name="un" value="<?php $htmlOut($data['userName']); ?>">
            </div>
            <div class="mb-3">
                <label for="lPassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="lPassword" name="pwd">
            </div>
            <button class="btn btn-primary">Log in</button>
            <?php $endForm(); ?>
        </div>
        <div class="col">
            <h1>No account yet?</h1>
            <h2>Register here:</h2>
            <?php $beginForm('User', 'Register', method: 'post'); ?>
            <div class="mb-3">
                <label for="rUserName" class="form-label">User name</label>
                <input class="form-control" id="rUserName" name="un">
            </div>
            <div class="mb-3">
                <label for="rPassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="rPassword" name="pwd">
            </div>
            <button class="btn btn-primary">Register</button>
            <?php $endForm(); ?>
        </div>
    </div>
</container>

<?php $render('partial/footer', $data); ?>