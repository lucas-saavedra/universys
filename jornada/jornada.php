 <?php  /* include_once("header.php"); */ ?>
 <div class="container">
     <div class="row">
         <div class="col">



             <form action="" id="jornada" method="POST">
                 <?PHP include("includes/elegir_agente.php") ?>
                 <?php include("includes/jornada.php"); ?>
                 <?php if ($tipo_agente == 'docente') {
                        include("includes/elegir_catedra.php");
                    } else {
                        include("includes/elegir_area.php");
                    }
                    ?>

                 <div class="form-group col-md-12 d-flex justify-content-around">
                     <button type="submit" class="btn btn-primary">Aceptar</button>
                     <button type="reset" class="btn btn-secondary">Cancelar</button>
                 </div>

             </form>
         </div>
     </div>
 </div>

 <?php /*  include_once("includes/listar_jornadas.php"); */ ?>

 <?php  /* include_once("footer.html")  */ ?>