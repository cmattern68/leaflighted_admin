<?php

require_once('Lib.func.php');

function makeChanges(&$current_user)
{
    if (isset($_FILES['editAvatar'])) {
        if (!empty($_FILES['editAvatar']['name']))
            if (!checkFiles($current_user))
                return;

    }
    if (isset($_POST['editEmail'])) {
        $email = Lib::Sanitize($_POST['editEmail']);
        if (!empty($email))
            checkEmail($email, $current_user);
    }
}

function checkFiles(&$current_user)
{
    $errors = array();
    $name = Lib::Sanitize($_FILES['editAvatar']['name']);
    $typeArr = explode("/", Lib::Sanitize($_FILES['editAvatar']['type']));
    $type = $typeArr[count($typeArr) - 1];
    $error = Lib::Sanitize($_FILES['editAvatar']['error']);
    $size = Lib::Sanitize($_FILES['editAvatar']['size']);
    $acceptedType = array("png", "jpg", "jpeg", "gif", "PNG", "JPG", "JPEG", "GIT");
    if (!empty($name) && !empty($type)) {
        if (!in_array($type, $acceptedType))
            $errors[] = "Error: invalid image type.";
        else if ($size > 2000000)
            $errors[] = "Error: max image size is 2mo.";
        else if ($error != UPLOAD_ERR_OK) {
            switch ($error) {
            case UPLOAD_ERR_INI_SIZE:
                $errors[] = "Error: The uploaded file exceeds the upload_max_filesize directive in php.ini.";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $errors[] = "Error: The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.";
                break;
            case UPLOAD_ERR_PARTIAL:
                $errors[] = "Error: The uploaded file was only partially uploaded.";
                break;
            case UPLOAD_ERR_NO_FILE:
                $errors[] = "Error: No file was uploaded.";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $errors[] = "Error: Missing a temporary folder.";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $errors[] = "Error: Failed to write file to disk.";
                break;
            case UPLOAD_ERR_EXTENSION:
                $errors[] = "Error: File upload stopped by extension.";
                break;
            default:
                $errors[] = "Unknown upload error";
                break;
            }
        }
    } else
        $errors[] = "Error: invalid image.";
    if (!empty($errors)) {
        foreach ($errors as $erro) {
            echo "
            <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
            ".$erro."
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
            <span aria-hidden=\"true\">&times;</span>
            </button>
            </div>
            ";
        }
    } else {
        moveFile($type, $current_user);
    }
}

function moveFile($ext, &$current_user)
{
    $dir = "/opt/lampp/htdocs/leaflighted_admin/img/avatar/";
    $tmpName = Lib::Sanitize($_FILES['editAvatar']['tmp_name']);
    $finalName = basename(Lib::Sanitize($current_user->_name."_".$current_user->_lastname.date('Y-m-d_H:i:s', time()).".".$ext));
    if (move_uploaded_file($tmpName, $dir.$finalName)) {
        $current_user->setAvatar("../img/avatar/".$finalName);
        echo "
        <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
        Success: Avatar changed.
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
        <span aria-hidden=\"true\">&times;</span>
        </button>
        </div>
        ";
    } else {
        echo "
        <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
        Error: An error occured. Please, try again.
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
        <span aria-hidden=\"true\">&times;</span>
        </button>
        </div>
        ";
    }
}

function checkEmail($email, &$current_user)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "
        <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
        Error: email is not valid
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
        <span aria-hidden=\"true\">&times;</span>
        </button>
        </div>
        ";
    } else {
        $current_user->setEmail($email);
        echo "
        <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
        Success: Email changed.
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
        <span aria-hidden=\"true\">&times;</span>
        </button>
        </div>
        ";
    }
}
