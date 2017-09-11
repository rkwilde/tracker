<?php
    require_once("./../model/LogModel.php");
    require_once("AjaxController.php");

    $ajaxCont = new AjaxController(new LogModel(),$_POST);

?>
