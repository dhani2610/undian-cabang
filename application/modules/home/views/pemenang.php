<div class="container page" id="pemenang">
    <div class="content">
        <div class="row mb-2">
            <div class="col-md-6">
                Data Pemenang Undian
            </div>
            <div class="col-md-6 text-right">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="javascript:void(0)" class="btn btn-sm btn-light delete" >Hapus Pemenang</a>
                <a href="<?php echo base_url("home/export-pemenang")?>" class="btn btn-sm btn-light">Export Excel</a>
                </div>

                
            </div>
        </div>
        <table id="table" class="table table-sm table-striped table-bordered">            
            <thead>
                <tr>                                            
                    <th data-sortable="false" width="250">No Undian</th>
                    <th data-sortable="false" width="250">Nama Peserta</th>  
					<th data-sortable="false" width="250">No HP</th>
					<th data-sortable="false" width="250">Alamat</th>
                    <th data-sortable="false" width="250">Nama Hadiah</th>
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
            
            <?php echo form_open("home/delete-pemenang", "class='form-submit'")?>
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
<?php $this->load->view("footer");?>
<script type="text/javascript">
    $(".delete").click(function(e){
        $("#ModalDelete").modal("show");
    })
    
    var table;
    table = $('#table').DataTable({ 
		"pageLength": 400,
		"processing": true, 
		"serverSide": true, 
		"order": [], 
		
		"ajax": {
			"url": "<?php echo site_url('home/get_pemenang')?>",
			"type": "POST"
		},

		
		"columnDefs": [
		{ 
			"targets": [ 0 ], 
			"orderable": false, 
		},
		],
	});
</script>