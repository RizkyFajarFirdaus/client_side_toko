<div class="container-fluid">
    <section class="content">
    <div class="col-lg-12 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h3 class="m-0 font-weight-bold text-primary">KELOLA DATA USER</h3>
            </div>

            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                <table class='table table-bordered>'        
                <tr><td width='200'>Nama Level <?php echo form_error('nama_level') ?></td><td><input type="text" class="form-control" name="nama_level" id="nama_level" placeholder="Nama level" value="<?php echo $nama_level; ?>" /></td></tr>
                <tr><td></td><td><input type="hidden" name="id_user_level" value="<?php echo $id_user_level; ?>" /> 
                <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
                <a href="<?php echo site_url('level') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
                </table>

            </form>        
        </div>
        </div>
    </section>

</div>