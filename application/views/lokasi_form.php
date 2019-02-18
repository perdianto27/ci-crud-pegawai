<!-- Main content -->
        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='box'>
                <div class='box-header'>
                
                  <h3 class='box-title'>LOKASI</h3>
                      <div class='box box-primary'>
        <form action="<?php echo $action; ?>" method="post"><table class='table table-bordered'>
      <tr><td>Kode Lokasi <?php echo form_error('kd_lokasi') ?></td>
            <td><input type="text" class="form-control" name="kd_lokasi" id="kd_lokasi" placeholder="Kode Lokasi" value="<?php echo $kd_lokasi; ?>" />
        </td>
	    <tr><td>Nama Lokasi <?php echo form_error('nm_lokasi') ?></td>
            <td><input type="text" class="form-control" name="nm_lokasi" id="nm_lokasi" placeholder="Nama Lokasi" value="<?php echo $nm_lokasi; ?>" />
        </td>
	    <tr><td colspan='2'><button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('lokasi') ?>" class="btn btn-default">Cancel</a></td></tr>
	
    </table></form>
    </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->