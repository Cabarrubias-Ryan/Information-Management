<?php
    include('../../../Encryption/Encryption.php');
    include('../../../Connection/Connection.php');

    if(decryptData($_GET['Userid']) == null)
    {
        header('Location: ../ListofOfficial.php');
        exit();
    }
    $AccountId = decryptData($_GET['Userid']);

    $query = $connection->prepare('select u.id, u.username, u.password, u.account_id as User_Id, u.gmail, u.account_role, o.* from fms.Users u left join fms.Barangay_Official o on u.account_id = o.official_id where u.account_id = ?');
    $query->bind_param('i',$AccountId);
    $query->execute();
    $result = $query->get_result();
    
    if($result->num_rows > 0){
        $Data = $result->fetch_assoc();

        $id = $Data['account_id'];
        $name = $Data['name'];
        $lastname = $Data['lastname'];
        $position = $Data['position'];
        $officialID = $Data['official_id'];
        $gmail = $Data['gmail'];
        $Username = $Data['username'];
        $AccountRole = $Data['account_role'];
        $status = $Data['status'];
    }
    else{
        $query = $connection->prepare('select * from fms.Barangay_Official where official_id = ?');
        $query->bind_param('i',$AccountId);
        $query->execute();
        $result = $query->get_result();
        $Data = $result->fetch_assoc();
        
        $id = $Data['account_id'];
        $name = $Data['name'];
        $lastname = $Data['lastname'];
        $position = $Data['position'];
        $officialID = $Data['official_id'];
        $status = $Data['status'];
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
            background: rgb(99, 39, 120);
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #BA68C8;
        }

        .profile-button {
            background: rgb(99, 39, 120);
            box-shadow: none;
            border: none;
        }

        .profile-button:hover {
            background: #682773;
        }

        .profile-button:focus {
            background: #682773;
            box-shadow: none;
        }

        .profile-button:active {
            background: #682773;
            box-shadow: none;
        }

        .back:hover {
            color: #682773;
            cursor: pointer;
        }

        .labels {
            font-size: 11px;
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
            border: solid 1px #BA68C8;
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
    <form action="UpdatePro.php" method="post">
        <div class="container rounded bg-white mt-5 mb-5">
            <div class="row">
                <div class="col-md-4 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="../../../img/person.jpg"><span class="font-weight-bold"><?= $name." ". $lastname?></span><span class="text-black-50"><?= $gmail ?></span><span> </span></div>
                </div>
                <div class="col-md-8 ">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Profile Settings</h4>
                        </div>
                        <div class="row mt-3">
                            <input type="hidden" name="HiddenId" value="<?= $officialID ?>">
                            <div class="col-md-12"><label class="form-label">Firstname</label><input type="text" class="form-control" name="name" value="<?= $name?>" ></div>
                            <div class="col-md-12"><label class="form-label">Lastname</label><input type="text" class="form-control" name="lastname" value="<?= $lastname ?>" ></div>
                            <div class="col-md-12"><label class="form-label">Position</label><input type="text" class="form-control" name="position"value="<?= $position ?>" ></div>
                            <div class="col-md-12">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control">
                                    <option value="<?= $status ?>" hidden><?= $status ?></option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="error">
                            <?php if(isset($_GET['Data'])): ?>
                                <?php if($_GET['Data'] == "Empty") : ?>
                                    <strong>Invalid Data, Empty Data is not accepted.</strong>
                                <?php elseif($_GET['Data'] == "invalidamount") : ?>
                                    <strong>Invalid Data.</strong>
                                <?php endif ?>
                            <?php endif ?>
                        </div>
                        <div class="mt-5 text-center"><input type="submit" class="btn btn-primary profile-button" value="Save Profile"></div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
