<?php 
    session_start();
    include("Encryption/Encryption.php");
    $_SESSION['loginChecker'] = false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
            }
            .h-custom {
            height: calc(100% - 73px);
            }
            @media (max-width: 450px) {
            .h-custom {
            height: 100%;
            }
        }
        strong{
            font-size: 12.5px;
            color: red;
        }
    </style>
</head>
<body>
    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5 d-flex justify-content-center">
                    <img src="img/logo.jfif" class="img-fluid" alt="Sample image" style="max-width: 100%; height: auto;">
                </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                <form action="login/loginpro.php" method="post">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-auto">
                            <p class="lead fw-normal mb-0 me-3" style="font-size: 1.8rem;">Login</p>
                        </div>
                    </div>
                </div>

                <div class="divider d-flex align-items-center my-4">
                    <p class="text-center fw-bold mx-3 mb-0"></p>
                </div>

                <!-- Email input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="form3Example3">Username</label>
                    <input type="text" name="username" id="form3Example3" value = "<?php echo isset($_GET['username']) ? htmlspecialchars(decryptData($_GET['username'])) : '';  ?>" class="form-control form-control-lg"
                    placeholder="Enter Username" />
                </div>

                <!-- Password input -->
                <div data-mdb-input-init class="form-outline mb-3">
                    <label class="form-label" for="form3Example4">Password</label>
                    <input type="password" name="password" id="form3Example4" class="form-control form-control-lg"
                    placeholder="Enter password" />
                    <?php if(isset($_GET['login'])): ?>
                        <?php $logincon = $_GET['login'] ?> 
                        <?php if($logincon == "error") : ?>
                            <strong>Invalid Username or Password</strong>
                        <?php elseif($logincon == "Invalid") : ?>
                            <strong>Unable to login, This Account is not Active</strong>
                    <?php endif ?>
                <?php endif ?>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <!-- Checkbox -->
                    <div class="form-check mb-0">
                    <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                    <label class="form-check-label" for="form2Example3">
                        Remember me
                    </label>
                    </div>
                    <a href="#!" class="text-body">Forgot password?</a>
                </div>

                <div class="text-center text-lg-start mt-4 pt-2">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-auto">
                                <input type="Submit" value="Login" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">
                            </div>
                        </div>
                    </div>
                </div>

                </form>
            </div>
            </div>
        </div>
    </section>
</body>
</html>