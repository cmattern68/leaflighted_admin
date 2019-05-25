<?php

function changeUserRank($id, $rank)
{
    if ($rank > 1 || $rank < 0)
        $rank = 0;
    $dbh = Lib::createSecureDataConnection();
    $request = $dbh->prepare("SELECT id FROM users_admin WHERE id=:id");
    $request->execute(array(
        'id' => $id
    ));
    $result = $request->fetchAll();
    if (empty($result))
        echo "<script type=\"text/javascript\">window.location.href = 'index.php?page=edit_user';</script>";
    $request = $dbh->prepare("UPDATE users_admin SET isadmin=:isadmin WHERE id=:id");
    $request->execute(array(
        ':isadmin' => $rank,
        ':id' => $id
    ));
    $dbh = NULL;
    echo "<script type=\"text/javascript\">window.location.href = 'index.php?page=edit_user';</script>";
}
