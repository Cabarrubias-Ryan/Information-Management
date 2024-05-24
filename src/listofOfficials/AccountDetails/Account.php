<?php
    include('../../../Encryption/Encryption.php');
    include('../../../Connection/Connection.php');

    if(decryptData($_GET['Userid']) == null)
    {
        header('Location: ../ListofOfficial.php');
        exit();
    }
    $id = decryptData($_GET['Userid']);
    $id2 = decryptData($_GET['Userid']);
    $query = $connection->prepare('select u.id, u.username, u.password, u.account_id as User_Id, u.gmail, u.account_role, o.* from fms.Users u left join fms.Barangay_Official o on u.account_id = o.official_id where u.account_id = ?');
    $query->bind_param('i',$id);
    $query->execute();
    $result = $query->get_result();
    
    if($result->num_rows > 0){
        $Data = $result->fetch_assoc();

        $UsernameId = $Data['id'];
        $id = $Data['account_id'];
        $name = $Data['name'];
        $lastname = $Data['lastname'];
        $position = $Data['position'];
        $officialID = $Data['official_id'];
        $gmail = $Data['gmail'];
        $Username = $Data['username'];
        $AccountRole = $Data['account_role'];
    }
    else{
        $UsernameId = " ";
        $id = " ";
        $name = " ";
        $lastname = " ";
        $position = " ";
        $officialID = " ";
        $gmail = " ";
        $Username = " ";
        $AccountRole = " ";
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: rgb(99, 39, 120)
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #BA68C8
        }

        .profile-button {
            background: rgb(99, 39, 120);
            box-shadow: none;
            border: none
        }

        .profile-button:hover {
            background: #682773
        }

        .profile-button:focus {
            background: #682773;
            box-shadow: none
        }

        .profile-button:active {
            background: #682773;
            box-shadow: none
        }

        .back:hover {
            color: #682773;
            cursor: pointer
        }

        .labels {
            font-size: 11px
        }
        .back-link {
            color: #fff;
            text-decoration: none;
            margin-top: 20px;
            margin-left: 20px;
            position: absolute;
            top: 0;
            left: 0;
        }
        .add-experience:hover {
            background: #BA68C8;
            color: #fff;
            cursor: pointer;
            border: solid 1px #BA68C8
        }
        strong{
            color: red;
            font-size: 12px;
        }
        .container .error{
            padding: 0 10px 10px 0;
        }
    </style>
</head>
<body>
    <a href="../ListofOfficial.php" class="back-link">Back</a>
    <form action="AccountPro.php" method="post">
        <div class="container rounded bg-white mt-5 mb-5">
            <div class="row">
                <div class="col-md-4 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="../../../img/person.jpg"><span class="font-weight-bold"><?= $name ." ". $lastname ?></span><span class="text-black-50"><?= $gmail ?></span><span> </span></div>
                </div>
                <div class="col-md-8">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Account Settings</h4>
                        </div>
                        <div class="row mt-3">
                            <input type="hidden" name="UsernameId" value="<?= $UsernameId ?>">
                            <input type="hidden" name="id" value="<?= $id2 ?>">
                            <div class="col-md-12"><label class="form-label">Username</label><input type="text" class="form-control" name="name" value="<?= $Username ?>" <?= $Username == " "?'readonly':" "; ?> ></div>
                            <div class="error">
                                <?php if(isset($_GET['user'])): ?>
                                    <?php if($_GET['user'] == "Duplicate") : ?>
                                        <strong>Username already use.</strong>
                                    <?php endif ?>
                                <?php endif ?>
                            </div>
                            <div class="col-md-12"><label class="form-label">Password</label><input type="password" class="form-control"  name="password"  <?= $Username ?>" <?= $Username == " "?'readonly':" "; ?>></div>
                            <div class="error">
                                <?php if(isset($_GET['passwordcondition'])): ?>
                                    <?php $invalidpasswordChecker = $_GET['passwordcondition'] ?>
                                        <?php if($invalidpasswordChecker == "invalid") : ?>
                                            <strong>Password must have at least 8 characters.</strong>
                                        <?php elseif($invalidpasswordChecker == "UpperCase") : ?>
                                            <strong>Password must have at least one Upper Case.</strong>
                                        <?php elseif($invalidpasswordChecker == "LowerCase") : ?>
                                            <strong>Password must have at least one Lower Case.</strong>
                                        <?php elseif($invalidpasswordChecker == "Number") : ?>
                                            <strong>Password must have at least one number.</strong>
                                        <?php elseif($invalidpasswordChecker == "SpecialCharacter") : ?>
                                            <strong>Password must have at least one special Character.</strong>
                                    <?php endif ?>
                                <?php endif ?>     
                            </div>
                            <div class="col-md-12"><label class="form-label">Retype Password</label><input type="password" class="form-control"  name="password1" <?= $Username ?>" <?= $Username == " "?'readonly':" "; ?>></div>
                            <div class="error">
                                <?php if(isset($_GET['password'])): ?>
                                    <?php if($_GET['password'] == "notmatch") : ?>
                                        <strong>Password not match.</strong>
                                    <?php endif ?>
                                <?php endif ?>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Account Role</label>
                                <select class="form-control" name="AccountRole" <?= $AccountRole ?> <?= $AccountRole == " "?'readonly':" "; ?>>
                                    <option value="<?= $AccountRole?>" hidden><?= $AccountRole?></option>
                                    <option value="Administrator">Administrator</option>
                                    <option value="User">User</option>
                                </select>
                            </div>
                            <div class="col-md-12"><label class="form-label">Gmail</label><input type="gmail" class="form-control" name="gmail" value="<?= $gmail ?>"  <?= $Username == " "?'readonly':" "; ?>></div>
                        </div>
                        <div class="error">
                            <?php if(isset($_GET['signup'])): ?>
                                <?php if($_GET['signup'] == "empty") : ?>
                                    <strong>You should not enter a empty data</strong>
                                <?php endif ?>
                            <?php endif ?>
                        </div>
                        <div class="mt-5 text-center"><input type="<?= $Username == " "?'button':'submit'; ?>" class="btn btn-primary profile-button" value="<?= $Username == " "?'Unable to Edit':'Save Profile'; ?>" <?= $Username == " "?'readonly':" "; ?> ></div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
