<?php
    require 'includes/config/functions.php';
    $auth = estAuth();
    if(!$auth){
        header('Location: index.php');
    }
    $db = conectarDB();
    $county = "SELECT id, codeCounty, county FROM countty";
    $county = (mysqli_query($db, $county));

    $party = "SELECT DISTINCT poloticalParty FROM election";
    $party = (mysqli_query($db, $party));

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
                            <div class="izquierda">
                                <label class="black" for="year">Year</label>
                            </div>
                            <input type="number" class="form-control" id="year" name="year" placeholder="Enter Year">
                        </div>
                        <div class="form-group">
                            <div class="izquierda">
                                <label class="black" for="party">Political Party</label>
                            </div>
                            <select class="form-control" id="party" name="party">
                            <option value="">--Seleccione--</option>
                                <?php while($row = mysqli_fetch_assoc($party)):?>
                                    <option value="<?php echo $row['poloticalParty']; ?>"><?php echo $row['poloticalParty']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="izquierda">
                                <label class="black" for="contry">County</label>
                            </div>
                            <select class="form-control" id="contry" name="contry">
                            <option value="">--Seleccione--</option>
                            <?php while($row = mysqli_fetch_assoc($county)):?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['codeCounty']." ".$row['county']; ?></option>
                            <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="izquierda">
                                <label class="black" for="votes">Vote count</label>
                            </div>
                            <input type="number" class="form-control" id="votes" name="votes" placeholder="Enter number">
                        </div>                        
                    </div>
                    <div class="izquierda">
                        <button type="submit" class="btn btn-primary enviar">Submit</button>
                        <a href="form-upload.php" class="btn btn-success">Upload</a>
                    </div>
                </form>
            </div>
        </main>
<?php include_once "includes/templates/footer.php"; ?>
