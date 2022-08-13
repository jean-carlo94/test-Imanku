<?php include_once "includes/templates/header.php"; ?>
    <main class="form-signin w-100 m-auto">
        <form id="login" class="form-center">
            <h1 class="h3 mb-3 fw-normal">TEST-ELECTIONS</h1>
            <div class="content-login">
                <p class="text-secondary fw-bold">Sign in to stat your session</p>
                <div class="input-group mb-3">
                    <label class="input-group-text text-secondary" id="basic-addon1"><i class="bi bi-envelope-fill"></i></label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" aria-describedby="basic-addon1" required>
                </div>
                <div class="input-group mb-3">
                    <label class="input-group-text text-secondary" id="basic-addon1"><i class="bi bi-lock-fill"></i></label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" aria-describedby="basic-addon1" required>
                </div>
                <div class="derecha">
                    <button class="btn btn-primary enviar" type="submit">Sign in</button>
                </div>
            </div>
        </form>
    </main>
<?php include_once "includes/templates/footer.php"; ?>


