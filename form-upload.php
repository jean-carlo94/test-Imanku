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
                <h3 class="card-title">Upload Files</h3>
              </div>
                <form id="upload" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="input-group mb-3">
                            <button id="excel_accion" class="btn btn-outline-secondary" type="button">Upload Excel</button>
                            <input type="file" class="form-control" id="excel" name="excel" aria-describedby="excel_accion" aria-label="Upload" accept=".xls,.xlsx">
                        </div>
                        <div class="input-group mb-3">
                            <button id="json_accion" class="btn btn-outline-secondary" type="button">Upload Json</button>
                            <input type="file" class="form-control" id="json" name="json" aria-describedby="json_accion" aria-label="Upload" accept=".json">
                        </div>                      
                    </div>
                </form>
            </div>
        </main>
<?php include_once "includes/templates/footer.php"; ?>
