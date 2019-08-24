<?php
if(isset($_POST["submit"]) && strlen($_POST["nombres"]<=20) && !is_numeric($_POST["nombres"]) && !preg_match("/[0-9]/", $_POST["nombres"])){
	if(!empty($_POST["documento"])){
        echo $_POST["documento"]."<br/>";
    }
    if(!empty($_POST["nombres"])){
        echo $_POST["nombres"]."<br/>";
    }
     if(!empty($_POST["apellidos"])&& !is_numeric($_POST["apellidos"]) && !preg_match("/[0-9]/", $_POST["apellidos"])){
        echo $_POST["apellidos"]."<br/>";
    }
     if(!empty($_POST["direccion"])&& !is_numeric($_POST["direccion"]) && !preg_match("/[0-9]/", $_POST["direccion"])){
        echo $_POST["direccion"]."<br/>";
    }
     if(!empty($_POST["acudiente"])&& !is_numeric($_POST["acudiente"]) && !preg_match("/[0-9]/", $_POST["acudiente"])){
        echo $_POST["acudiente"]."<br/>";
    }
	if(!empty($_POST["telefono"])){
        echo $_POST["telefono"]."<br/>";
    }
    if(isset($_FILES["foto"]) && !empty($_FILES["foto"]["tmp_name"])){
		echo "La imagen esta cargada";
	    }
}
