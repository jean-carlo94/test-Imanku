<?php
    require 'includes/config/functions.php';
    $auth = estAuth();
    if(!$auth){
        header('Location: index.php');
    }
    include_once "includes/templates/header.php";
?>
        <main class="main-form">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Election</h3>
              </div>
                <form id="election">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="year">Year</label>
                            <input type="number" class="form-control" id="year" name="year" placeholder="Enter Year">
                        </div>
                        <div class="form-group">
                            <label for="party">Political Party</label>
                            <select class="form-control" id="party" name="party"></select>
                        </div>
                        <div class="form-group">
                            <label for="contry">Contry</label>
                            <select class="form-control" id="contry" name="contry"></select>
                        </div>
                        <div class="form-group">
                            <label for="votes">Vote count</label>
                            <input type="number" class="form-control" id="votes" name="votes" placeholder="Enter number">
                        </div>                        
                    </div>
                    <div class="izquierda">
                        <button type="submit" class="btn btn-primary enviar">Submit</button>
                    </div>
                </form>
            </div>
        </main>
<?php include_once "includes/templates/footer.php"; ?>
