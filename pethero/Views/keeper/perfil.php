<?php
require_once(VIEWS_PATH . 'nav.php');
?>
<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">My Perfil</h2>
            <form action="<?= FRONT_ROOT ?>Keeper/Update" method="post" class="bg-light-alpha p-5">
            
                <?php if (isset($_SESSION['error'])) { ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>¡Error!</strong> <?= $_SESSION['error'] ?>
                    </div>
                <?php } ?>

                <?php if (isset($_SESSION['success'])) { ?>
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>¡Success!</strong> <?= $_SESSION['success'] ?>
                    </div>
                <?php } ?>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Name <strong class="text-danger">*</strong></label>
                            <input type="text" name="name" value="<?= $keeper->getName() ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Lastname <strong class="text-danger">*</strong></label>
                            <input type="text" name="lastname" value="<?= $keeper->getLastname() ?>" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="">Address <strong class="text-danger">*</strong></label>
                            <input type="text" name="address" value="<?= $keeper->getAddress() ?>" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Start Date <strong class="text-danger">*</strong></label>
                            <input type="date" name="startDate" max="<?= $keeper->getEndDate()?>" min="<?= date('Y-m-d') ?>" value="<?= $keeper->getStartdate() ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">End Date <strong class="text-danger">*</strong></label>
                                <?php
                                if ($keeper->getStartDate()!=null) {
                                ?>
                                    <input type="date" name="endDate" min="<?=$keeper->getStartdate()?>" value="<?= $keeper->getEndDate() ?>" class="form-control" required>
                                <?php
                                } else {
                                ?>
                                    <input type="date" name="endDate" min="<?= date('Y-m-d') ?>" value="<?= $keeper->getEndDate() ?>" class="form-control" required>
                                <?php
                                }
                                ?>
                            
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="">Days (Optional)</label>
                            <input type="text" name="days" value="<?= $keeper->getDays() ?>" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Price <strong class="text-danger">*</strong></label>
                            <input type="number" name="price" step="0.01" min="0" value="<?= $keeper->getPrice() ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Size pet</label><br>
                            <div class="form-control">
                                <?php
                                if ($keeper->checkSizePet('Small')) {
                                ?>
                                    <input class="ml-2" type="checkbox" name="small" value="Small" checked> Small
                                <?php
                                } else {
                                ?>
                                    <input class="ml-2" type="checkbox" name="small" value="Small"> Small
                                <?php
                                }
                                ?>

                                <?php
                                if ($keeper->checkSizePet('Medium')) {
                                ?>
                                    <input class="ml-2" type="checkbox" name="medium" checked> Medium
                                <?php
                                } else {
                                ?>
                                    <input class="ml-2" type="checkbox" name="medium"> Medium
                                <?php
                                }
                                ?>

                                <?php
                                if ($keeper->checkSizePet('Big')) {
                                ?>
                                    <input class="ml-2" type="checkbox" name="big" checked> Big
                                <?php
                                } else {
                                ?>
                                    <input class="ml-2" type="checkbox" name="big"> Big
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                /*
                               $date1=date_create($keeper->getStartDate());
                                $date2=date_create($keeper->getEndDate());
                                if ($diff=date_diff($date1,$date2)==false) {
                                    $keeper->setEndDate($keeper->getStartDate());
                                }
                                */
                                ?>
                <button type="submit" class="btn btn-dark ml-auto d-block">Update</button>

            </form>

            
        </div>
    </section>
</main>