<div class="container page" id="batal">
    <div class="content">
        <div class="row mb-2">
            <div class="col-md-6">
                Data Pemenang Batal
            </div>
            <div class="col-md-6 text-right">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="javascript:void(0)" class="btn btn-sm btn-light delete" >Hapus Pemenang Batal</a>                    
                </div>
            </div>
        </div>        
        <table id="table" class="table table-sm table-striped table-bordered">
            <thead>
                <tr>
                    <th>No Undian</th>
                    <th>Nama Peserta</th>  
                    <th>No HP</th>                    
                    <th>Alamat</th>    
                    <th></th>                              
                </tr>
            </thead>
            <tbody></tbody>
        </table>        
    </div>
</div>
<div class="modal" id="ModalDelete" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <?php echo form_open("home/delete-batal", "class='form-submit'")?>
                <div class="modal-body">
                   <p>Apakah Anda yakin ingin menghapus data ini ?</p>
                </div>
                <div class="modal-footer">
                    <img src="<?php echo base_url()?>assets/img/loading.gif" class="loading" id="loading2" />                    
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="delete">Hapus</button>
                </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>
<div class="modal" id="ModalKonfirmasi" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open("home/reset-batal-by-one", 'class="form-submit"') ?>            
                <div class="modal-body">
                    <input type="hidden" id="id_delete" name="id_delete">
                   <p>Apakah Anda yakin ingin menghapus data ini ?</p>
                </div>
                <div class="modal-footer">
                    <img src="<?php echo base_url() ?>assets/img/loading.gif" class="loading" id="loading2" />                    
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <input type="submit" class="btn btn-primary" id="delete-hadiah" value="Hapus">
                </div>
            </form>
        </div>
    </div>
</div>
<?php $this->load->view("footer");?>
<style>
    table tr td:nth-child(4){ text-align:center;}
</style>
<script type="text/javascript">
    $(".delete").click(function(e){
        $("#ModalDelete").modal("show");
    })
    
    var table;
    table = $('#table').DataTable({ 
		"processing": true, 
		"serverSide": true, 
		"order": [], 
		"ajax": {
			"url": "<?php echo site_url('home/get-batal')?>",
			"type": "POST"
		},
		"columnDefs": [
		{ 
			"targets": [ 0 ], 
			"orderable": false, 
		},],
	}); 
    $("body").on("click", ".delete-by-one", function(event){     
        var id = $(this).attr("id");
        $("#id_delete").val(id);
        $("#ModalKonfirmasi").modal("show");
    })
</script>