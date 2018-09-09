<div class="container">
    <?php foreach ($authors as $author) : ?>
        <ul class="list-group"><?=$author->getName() . ' '. $author->getSurname()?>
            <?php foreach ($author->getBooks() as $book) : ?>
                    <li class="list-group-item"><?=$book?> </li>
            <?php endforeach; ?>
        </ul>
    <?php endforeach; ?>
    <form  method="post" >
        <div class="row">
            <div class="col-sm-12">
                <div class="form_group">
                    <button id = "loginSubmit" type="submit" name="submit" class="btn btn-default"><a href="/language">Change language</a></button>
                </div>
            </div>
        </div>
    </form>

</div>