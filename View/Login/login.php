<?php
if (isset($_SESSION['flash'])) {
    echo $_SESSION['flash'];
    $_SESSION['flash'] = '';
}
?>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <hr>
            <form  method="post" >
            <div class="form-group">
                <label for="name">Your Email</label>
                <input type="email" class="form-control" name="email" placeholder="Enter You Email" value="">
            </div>
                <input type="hidden" name="csrf" value="<?= $_SESSION['csrf']?>">
            <div class="form-group">
                <label for="email">Email password</label>
                <input type="password" class="form-control" name="password" placeholder="Enter You Password" value="">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form_group">
                       <button id = "loginSubmit" type="submit" name="submit" class="btn btn-default">Send</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
