<div class="container page" id="hadiah">
    <div class="content">        
        <div class="row">
            <div class="col-md-6">
                <h4>Rewards :</h4>
            </div>
            <div class="col-md-6 text-right">
                <a href="javascript:void(0)" class="btn btn-sm btn-light rewards">Tambah Rewards</a>
            </div>
        </div>
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>Kategori Juara</th>
                    <th>Nama Hadiah</th>
                    <th>Gambar Hadiah</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($hadiah->result() as $item){
                    echo "<tr>
                            <td>".$item->kategori_hadiah."</td>
                            <td>".$item->nama_hadiah."</td>
                            <td align=center><img src='".base_url()."assets/img/".$item->gambar_hadiah."' width='100'></td>
                            <td align=center width=50>
                                <a href='javascript:void(0)' id='".$item->ta_hadiah_id."|".$item->gambar_hadiah."' class='delete-rewards'><i class='fa fa-edit'></i></a>
                                <a href='javascript:void(0)' id='".$item->ta_hadiah_id."|".$item->gambar_hadiah."' class='delete-rewards'><i class='fa fa-trash text-danger'></i></a>
                            </td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal" id="ModalHadiah" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Rewards</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open("home/rewards-save", 'class="form-submit"') ?>            
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Kategori Hadiah</label>
                                <input type="text" class="form-control" name="kategori_hadiah" id="kategori_hadiah" />
                                <div class="text-danger err kategori_hadiah"></div>
                            </div>
                            <div class="form-group">
                                <label>Nama Hadiah</label>
                                <input type="text" class="form-control" name="nama_hadiah" id="nama_hadiah" />
                                <div class="text-danger err nama_hadiah"></div>
                            </div>
                            <div class="form-group">
                                <label>Gambar Hadiah</label>
                                <input type="file" id="file" class="fileImg" name="file" multiple />
                                <div class="text-danger err file"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <img id="preview" class="img-fluid preview" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <img src="<?php echo base_url() ?>assets/img/loading.gif" class="loading" id="loading2" />                    
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <input type="submit" class="btn btn-primary" id="simpan-hadiah" value="Simpan">
                </div>
            </form>
        </div>
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
            <?php echo form_open("home/delete-rewards", 'class="form-submit"') ?>            
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
<script type="text/javascript">    
    $(".rewards").click(function(e){ $("#ModalHadiah").modal("show");})    
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $(".fileImg").change(function () {        
        readURL(this);        
    });        
    $(".delete-rewards").click(function(e){
        var id = $(this).attr("id");
        $("#id_delete").val(id);
        $("#ModalDelete").modal("show");
    })       
</script>