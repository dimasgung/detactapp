<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Mobile Site Processed</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url();?>Dashboard">Home</a></li>
              <li class="breadcrumb-item"><a href="#">CNOP</a></li>
              <li class="breadcrumb-item active">Mobile Site Migration Processed</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
       <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Mobile Site Data Processed</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="table" class="table table-striped"  cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>No</th>
                            <th>NAME_OSP</th>
                            <th>STATUS</th>
                            <th>SITE_ID</th>
                            <th>SITE_NAME</th>
                            <th>ADDRESS</th>
                            <th>REGIONAL</th>
                            <th>WITEL</th>
                            <th>STO</th>
                            <th>RESPONSE</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
         
                    <tfoot>
                        <tr>
                            <th><input style="width:30px; height:30px;" type="checkbox" id="check-all" class="checkbox-all"></th>
                            <th>No</th>
                            <th>NAME_OSP</th>
                            <th>STATUS</th>
                            <th>SITE_ID</th>
                            <th>SITE_NAME</th>
                            <th>ADDRESS</th>
                            <th>REGIONAL</th>
                            <th>WITEL</th>
                            <th>STO</th>
                            <th>RESPONSE</th>
                        </tr>
                    </tfoot>
                </table>

              </div>
              <!-- /.card-body -->
            </div>

              <button type="button" class="btn btn-primary btn-sm" id='create-all'>Create Selected Mobile Site</button>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>

  <div class="modal"><!-- Place at bottom of page --></div>

  <!--MODAL Create-->
  <div class="modal fade" id="ModalCreateAll" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Create Mobile Site</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
              </div>
              <form class="form-horizontal">
              <div class="modal-body">
                                     
                      <input type="hidden" name="kode" id="textkode" value="">
                      <div class="alert alert-primary"><p>Apakah Anda yakin mau membuat mobile site yang dichecklis?</p></div>
                                   
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                  <button class="btn_create_all btn btn-primary" id="btn_create_all">Create</button>
              </div>
              </form>
          </div>
      </div>
  </div>
 
<script src="<?php echo base_url();?>assets/AdminLTE/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    var table;
    $(document).ready(function() {
 
        tampil_datatable();

        function tampil_datatable(){
          //datatables
          table = $('#table').DataTable({ 
   
              "processing": true, 
              "serverSide": true, 
              "order": [], 
               
              "ajax": {
                  "url": "<?php echo site_url('CNOP/get_data_mobile_site_processed')?>",
                  "type": "POST",
              },
   
               
              "columnDefs": [
              { 
                  "targets": [ 0 ], 
                  "orderable": false, 
              },
              ],
   
          });
        }

       $('#check-all').click(function(){
          var inputs  = document.getElementsByClassName("checkbox-grid");
          for(var i = 0, l = inputs.length; i < l; ++i) {

            if($(this).is(":checked")){
              inputs[i].checked = true;
            }else{
              inputs[i].checked = false;
           }

          }
        })

      $('#create-all').click(function(){
            $('#ModalCreateAll').modal('show');
      });

      $('#btn_create_all').on('click',function(){


          var inputs = $('.checkbox-grid');

          var jumlahProses = 0;

          for(var i = 0, l = inputs.length; i < l; ++i) {


            if(inputs[i].checked == true){

              jumlahProses++;
              var site_id=inputs[i].value;

              $.ajax({
              type : "POST",
              async: false,
              url  : "<?php echo base_url('CNOP/create_location_osp_uimax')?>",
              dataType : "JSON",
                      data : {site_id: site_id},
                      success: function(data){
                        if(jumlahProses == inputs.length){

                        }
                      }
                  });
            }
          }

          alert("create data berhasil");

          $('#ModalCreateAll').modal('hide');
          
          tampil_data_barang();
          
          return false;
          });


    });
 
</script>
