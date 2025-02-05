<?php
require_once(VIEWS_PATH . 'nav.php');
?>
<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">Create a account</h2>
            <form action="<?= FRONT_ROOT ?>User/Register" method="post" class="bg-light-alpha p-5">

                <?php if (isset($_SESSION['error'])) { ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>¡Error!</strong> <?= $_SESSION['error'] ?>
                    </div>
                <?php } ?>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Name <strong class="text-danger">*</strong></label>
                            <input type="text" name="name" value="" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Lastname <strong class="text-danger">*</strong></label>
                            <input type="text" name="lastname" value="" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="">Address <strong class="text-danger">*</strong></label>
                            <input type="text" name="address" value="" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Username <strong class="text-danger">*</strong></label>
                            <input type="text" name="username" value="" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Password <strong class="text-danger">*</strong></label>
                            <input type="password" name="password" value="" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">User type <strong class="text-danger">*</strong></label>
                            <select name="usertype" class="form-control" required>
                                <?php
                                foreach ($usertypes as $item) {
                                    if ($item->getType() != 'Admin') {
                                ?>
                                        <option value="<?= $item->getId() ?>"><?= $item ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-dark ml-auto d-block">Register</button>
            </form>


        </div>
    </section>
</main>