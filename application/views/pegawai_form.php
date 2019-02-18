<!-- Main content -->
        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='box'>
                <div class='box-header'>
                
                  <h3 class='box-title'>PEGAWAI</h3>
                      <div class='box box-primary'>
        <form action="<?php echo $action; ?>" method="post"><table class='table table-bordered'>
	    <tr><td>Nama <?php echo form_error('nama') ?></td>
            <td><input type="text" class="form-control" name="nama" id="nama" placeholder="Nama" value="<?php echo $nama; ?>" />
        </td>
	    <tr><td>Alamat <?php echo form_error('alamat') ?></td>
            <td><input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat" value="<?php echo $alamat; ?>" />
        </td>
	    <tr><td>Telpon <?php echo form_error('telp') ?></td>
            <td><input type="text" class="form-control" name="telp" id="telp" placeholder="Telp" value="<?php echo $telp; ?>" />
        </td>
	    <input type="hidden" name="NIK" value="<?php echo $NIK; ?>" /> 
	    <tr><td colspan='2'><button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('pegawai') ?>" class="btn btn-default">Cancel</a></td></tr>
	
    </table></form>
    </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->