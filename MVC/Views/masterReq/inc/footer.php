<!-- FECHAMENTO DAS ESTRUTURAS DE CONTEUDO-->
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->
<!-- /.FECHAMENTO DAS ESTRUTURAS DE CONTEUDO-->

<!-- jQuery -->
<script src=<?php echo URL . "_public/_JS/jquery.min.js";?>></script>
<!-- Bootstrap 4 -->
<script src=<?php echo URL . "_public/_JS/bootstrap.bundle.min.js";?>></script>
<!-- DataTables -->
<script src=<?php echo URL . "_public/_JS/jquery.dataTables.min.js";?>></script>
<script src=<?php echo URL . "_public/_JS/dataTables.bootstrap4.min.js";?>></script>
<script src=<?php echo URL . "_public/_JS/dataTables.responsive.min.js";?>></script>
<script src=<?php echo URL . "_public/_JS/responsive.bootstrap4.min.js";?>></script>
<!-- AdminLTE App -->
<script src=<?php echo URL . "_public/_JS/adminlte.min.js";?>></script>
<!-- AdminLTE for demo purposes -->
<script src=<?php echo URL . "_public/_JS/demo.js";?>></script>
<!-- page script -->
<script>
  $(function () {
    $("#table1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $("#table2").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $("#table3").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
</script>
</body>
</html>