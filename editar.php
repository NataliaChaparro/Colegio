<?php include 'includes/redirect.php';?>
<?php require_once("includes/header.php")?>
<?php
function mostrarError($error, $field){
  if(isset($error[$field]) && !empty($field)){
    $alerta='<div class="alert alert-danger">'.$error[$field].'</div>';
  }else{
    $alerta='';
  }
  return $alerta;
}
function setValueField($datos,$field, $textarea=false){
  if(isset($datos) && count($datos)>=1){
    if($textarea != false){
      echo $datos[$field];
    }else{
      echo "value='{$datos[$field]}'";
    }
  }
}
//Buscar Usuario
if(!isset($_GET["id"]) || empty($_GET["id"]) || !is_numeric($_GET["id"])){
  header("location:index.php");
  }
$id=$_GET["id"];
$user_query=mysqli_query($db, "SELECT * FROM registro WHERE idregistro={$id}");
$user=mysqli_fetch_assoc($user_query);
if(!isset($user["idregistro"]) || empty($user["idregistro"])){
  header("location:index.php");
}
//Validar usuario
$error=array();
if(isset($_POST["submit"])){
 if(!empty($_POST["documento"])){
$documento_validador=true;
}else{
$documento_validador=false;
$error["documento"]="El documento no es válido";
}
  if(!empty($_POST["nombres"])&& !is_numeric($_POST["nombres"]) && !preg_match("/[0-9]/", $_POST["nombres"])){
      $nombres_validador=true;
     }else{
     $nombres_validador=false;
       $error["nombres"]="Los nombres no son válidos";
        }
	if(!empty($_POST["apellidos"])&& !is_numeric($_POST["apellidos"]) && !preg_match("/[0-9]/", $_POST["apellidos"])){
      $apellidos_validador=true;
     }else{
     $apellidos_validador=false;
       $error["apellidos"]="Los apellidos no son válidos";
        }
     if(!empty($_POST["direccion"])&& !is_numeric($_POST["direccion"]) && !preg_match("/[0-9]/", $_POST["direccion"])){
      $direccion_validador=true;
     }else{
     $direccion_validador=false;
       $error["direccion"]="La direccion no es válidos";
        }
	if(!empty($_POST["acudiente"])&& !is_numeric($_POST["acudiente"]) && !preg_match("/[0-9]/", $_POST["acudiente"])){
      $acudiente_validador=true;
     }else{
     $acudiente_validador=false;
       $error["acudiente"]="El acudiente no es válidos";
        }
	if(!empty($_POST["telefono"])){
      $telefono_validador=true;
     }else{
     $telefono_validador=false;
       $error["telefono"]="El telefono no es válidos";
        }
    
        //nuevo código
        $foto=null;
        if(isset($_FILES["foto"]) && !empty($_FILES["foto"]["tmp_name"])){
          if(!is_dir("uploads")){
            $dir = mkdir("uploads", 0777, true);
          }else{
            $dir=true;
          }
          if($dir){
            $filename= time()."-".$_FILES["foto"]["name"]; //concatenar función tiempo con el nombre de imagen
            $muf=move_uploaded_file($_FILES["foto"]["tmp_name"], "uploads/".$filename); //mover el fichero utilizando esta función
            $foto=$filename;
            if($muf){
              $foto_upload=true;
            }else{
              $foto_upload=false;
              $error["foto"]= "La imagen no se ha subido";
            }
          }
          ;
  	 	}
    //Actualizar Usuarios en la base de Datos
    if(count($error)==0){
      $sql= "UPDATE registro set documento='{$_POST["documento"]}',"
      . "nombres= '{$_POST["nombres"]}',"
      . "apellidos= '{$_POST["apellidos"]}',"
      . "direccion= '{$_POST["direccion"]}',"
	  . "acudiente= '{$_POST["acudiente"]}',"
	  ."telefono= '{$_POST["telefono"]}',";
     //Código nuevo
     if(isset($_FILES["foto"]) && !empty($_FILES["foto"]["tmp_name"])){
       $sql.= "foto='{$foto}', ";
    }
      $update_user=mysqli_query($db, $sql);
      if($update_user){
        $user_query=mysqli_query($db, "SELECT * FROM registro WHERE idregistro={$id}");
        $user=mysqli_fetch_assoc($user_query);
      }
    }else{
      $update_user=false;
    }
}
?>
<h2>Editar Usuario <?php echo $user["idregistro"]."-".$user["nombres"]." ".$user["apellidos"];?></h2>
<?php if(isset($_POST["submit"]) && count($error)==0 && $update_user !=false){?>
  <div class="alert alert-success">
    El usuario se ha actualizado correctamente !!
  </div>
<?php }elseif(isset($_POST["submit"])){?>
  <div class="alert alert-danger">
    El usuario NO se ha actualizado correctamente !!
  </div>
<?php } ?>
<form action="" method="POST" enctype="multipart/form-data">
    <label for="documento">Documento:
    <input type="text" name="documento" class="form-control" <?php setValueField($user, "documento");?>/>
    <?php echo mostrarError($error, "documento");?>
    </label>
    </br></br>
    <label for="nombres">Nombres:
        <input type="text" name="nombres" class="form-control" <?php setValueField($user, "nombres");?>/>
        <?php echo mostrarError($error, "nombres");?>
    </label>
    </br></br>
    <label for="apellidos">Apellidos:
        <input type="text" name="apellidos" class="form-control" <?php setValueField($user, "apellidos");?>/>
        <?php echo mostrarError($error, "apellidos");?>
    </label>
</br></br>
    <label for="direccion">Direccion:
        <input type="text" name="direccion" class="form-control" <?php setValueField($user, "direccion");?>/>
        <?php echo mostrarError($error, "direccion");?>
    </label>
</br></br>
    <label for="acudiente">Acudiente:
        <input type="text" name="acudiente" class="form-control" <?php setValueField($user, "acudiente");?>/>
        <?php echo mostrarError($error, "acudiente");?>
    </label>
</br></br>
    <label for="telefono">Telefono:
        <input type="text" name="telefono" class="form-control" <?php setValueField($user, "telefono");?>/>
        <?php echo mostrarError($error, "telefono");?>
    </label>
    </br></br>
    <label for="foto">
      <?php if($user["foto"] != null){?>
        Imagen de Perfil: <img src="uploads/<?php echo $user["foto"] ?>" width="100"/><br/>
      <?php } ?>
        Actualizar Imagen de Perfil:
        <input type="file" name="foto" class="form-control"/>
        <!--Nuevo Código-->

    </label>
    </br></br>
    
    <input type="submit" value="Enviar" name="submit" class="btn btn-success"/>
</form>
<?php require_once("includes/footer.php")?>
