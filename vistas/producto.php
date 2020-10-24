<?php
require 'header.php';
?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Producto <button class="btn btn-success" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                      <table id="tbllistado" class="table table-striped table-bordered table-hover">
                        <thead>
                          <th>Opciones</th>
                          <th>Categoria</th>
                          <th>Descripcion</th>
                          <th>Stock</th>
                          <th>Imagen</th>
                          <th>Estado</th>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                          <th>Opciones</th>
                          <th>Categoria</th>
                          <th>Descripcion</th>
                          <th>Stock</th>
                          <th>Imagen</th>
                          <th>Estado</th>
                        </tfoot>
                      </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                      <!--aqui va el formularioa para agregar y editar-->

                      <form name="formulario" id="formulario" method="POST">
                       

                       <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Categoria(*):</label>
                                <select id="idcategoria" name="idcategoria" class="form-control selectpicker" data-live-search="true" required></select>
                       </div> 

                       <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Descripcion:</label>
                          <input type="hidden" name="idproducto" id="idproducto">
                          <input type="text" class="form-control" name="v_descripcion" id="v_descripcion" maxlength="256" placeholder="Descripcion">
                       </div>

                       <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Stock(*):</label>
                          <input type="number" class="form-control" name="i_stock" id="i_stock" required>
                       </div> 

                       
                       <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <label>Imagen:</label>
                          <input type="file" class="form-control" name="v_imagen" id="v_imagen">
                          <input type="hidden" name="imagenactual" id="imagenactual">
                          <img src="" width="150px" height="120px" id="imagenmuestra">
                       </div>  

                        
                       <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <button class="btn btn-primary" type="submit" id="btnGuardar">
                            <i class="fa fa-save"></i>Guardar</button>

                          <button class="btn btn-danger" onclick="cancelarform()" type="button">
                            <i class="fa fa-arrow-circle-left"></i>Cancelar</button>
                       </div>     


                      </form>


                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->

<?php
require 'footer.php';
?>

<script type="text/javascript" src="scripts/producto.js"></script>
