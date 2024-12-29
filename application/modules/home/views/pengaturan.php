<div class="container page" id="pengaturan">
    <div class="content">
        <div class="form-group">
            <label>Logo</label><br>
            <img src="<?php echo base_url() ?>assets/img/<?php echo $pengaturan->logo ?>" style="border:3px solid #FFF; max-height:80px;" />
        </div>
        <?php
        if ($this->session->flashdata('success') != null) {
            echo '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  ' . $this->session->flashdata('success') . '
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
            ';
        }
        ?>
        <div class="form-group">
            <span>Nama Undian</span>
            <h2><?php echo $pengaturan->nama_undian  ?></h2>
            <a href="javascript:void(0)" class="btn btn-sm btn-light ganti-nama-undian">Ganti Nama Undian</a> &nbsp;
            <a href="javascript:void(0)" class="btn btn-sm btn-light ganti-bg">Ganti Background</a>
            <a href="javascript:void(0)" class="btn btn-sm btn-light ganti-logo">Ganti Logo</a>
            <a href="javascript:void(0)" class="btn btn-sm btn-light password">Ubah Password</a>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-6">
                <h4>Rewards :</h4>
            </div>
            <div class="col-md-6 text-right">
                <a href="javascript:void(0)" class="btn btn-sm btn-light rewards">Tambah Rewards</a>
            </div>
        </div>
        <!-- <table class="table table-sm table-bordered">
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
                foreach ($hadiah->result() as $item) {
                    echo "<tr>
                            <td>" . $item->kategori_hadiah . "</td>
                            <td>" . $item->nama_hadiah . "</td>
                            <td align=center><img src='" . base_url() . "assets/img/" . $item->gambar_hadiah . "' width='100'></td>
                            <td align=center width=50><a href='javascript:void(0)' id='" . $item->ta_hadiah_id . "|" . $item->gambar_hadiah . "' class='delete-rewards'><i class='fa fa-trash text-danger'></i></a></td>
                        </tr>";
                }
                ?>
            </tbody>
        </table> -->
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>Kategori Juara</th>
                    <th>Nama Hadiah</th>
                    <th>Gambar Hadiah</th>
                    <th>Cabang</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hadiah->result() as $item): ?>
                    <tr>
                        <td><?= $item->kategori_hadiah; ?></td>
                        <td><?= $item->nama_hadiah; ?></td>
                        <td align="center">
                            <img src="<?= base_url('assets/img/' . $item->gambar_hadiah); ?>" width="100">
                        </td>
                        <td>
                            <?php foreach ($cabang_by_peserta as $cabang): ?>
                                <div class="form-check">
                                    <input
                                        class="form-check-input cabang-checkbox"
                                        type="checkbox"
                                        data-hadiah-id="<?= $item->ta_hadiah_id; ?>"
                                        value="<?= $cabang['cabang']; ?>"
                                        <?= in_array($cabang['cabang'], json_decode($item->cabang ?? '[]')) ? 'checked' : ''; ?>>
                                    <label class="form-check-label">
                                        <?= $cabang['cabang']; ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </td>
                        <td align="center" width="50">
                            <a href="javascript:void(0)" id="<?= $item->ta_hadiah_id; ?>|<?= $item->gambar_hadiah; ?>" class="delete-rewards">
                                <i class="fa fa-trash text-danger"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>

        <div class="modal fade" id="modalKonfirmasi" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Update Cabang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin memperbarui cabang untuk hadiah ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="button" id="btnConfirmUpdate" class="btn btn-primary">Ya, Update</button>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
<div class="modal" id="ModalNamaUndian" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php echo form_open("home/update-nama-undian", 'class="form-submit"') ?>
            <div class="modal-header">
                <h5 class="modal-title">Ganti Nama Undian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <textarea class="form-control" name="nama_undian" id="nama-undian" style="resize:none"><?php echo $pengaturan->nama_undian ?></textarea>
                    <div class="text-danger err nama_undian"></div>
                </div>
            </div>
            <div class="modal-footer">
                <img src="<?php echo base_url() ?>assets/img/loading.gif" class="loading" id="loading" />
                <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary btn-sm" value="Simpan">
            </div>
            <?php echo form_close() ?>
        </div>
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
<div class="modal" id="ModalLogo" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ganti Logo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open_multipart("home/logo-save", "class='form-submit'") ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <input type="file" class="fileImg" name="file" multiple />
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
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal" id="ModalBg" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ganti Background</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open_multipart("home/bg-save", "class='form-submit'") ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <input type="file" class="fileImg" name="file" multiple />
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
                <button type="submit" class="btn btn-primary">Simpan</button>
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
<div class="modal" id="ModalPassword" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open("home/password", 'class="form-submit"') ?>
            <div class="modal-body">
                <div class="form-group">
                    <label>Password Baru</label>
                    <input type="password" class="form-control" name="pass_b" id="pass_b">
                    <div class="text-danger err pass_b"></div>
                </div>
                <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <input type="password" class="form-control" name="pass_c" id="pass_c">
                    <div class="text-danger err pass_c"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <input type="submit" class="btn btn-primary" id="btnPassword" value="Simpan">
            </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php $this->load->view("footer"); ?>
<script type="text/javascript">
    $(".ganti-nama-undian").click(function() {
        $("#ModalNamaUndian").modal("show");
    })
    $(".ganti-logo").click(function() {
        $("#ModalLogo").modal("show");
    })
    $(".ganti-bg").click(function() {
        $("#ModalBg").modal("show");
    })
    $(".rewards").click(function(e) {
        $("#ModalHadiah").modal("show");
    })

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('.preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $(".fileImg").change(function() {
        readURL(this);
    });
    $(".delete-rewards").click(function(e) {
        var id = $(this).attr("id");
        $("#id_delete").val(id);
        $("#ModalDelete").modal("show");
    })
    $(".password").click(function(e) {
        $("#ModalPassword").modal("show");
    })

    $(document).ready(function() {
        let selectedHadiahId = null;
        let selectedCabang = null;

        $('.cabang-checkbox').on('change', function() {
            selectedHadiahId = $(this).data('hadiah-id');
            selectedCabang = $(this).val();

            if ($(this).is(':checked')) {
                $('#modalKonfirmasi').modal('show');
            } else {
                Swal.fire({
                    title: 'Yakin ingin menghapus cabang ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        updateCabang(selectedHadiahId, selectedCabang, false);
                    } else {
                        $(this).prop('checked', true); // Kembalikan checkbox jika batal
                    }
                });
            }
        });

        $('#btnConfirmUpdate').on('click', function() {
            $('#modalKonfirmasi').modal('hide');
            updateCabang(selectedHadiahId, selectedCabang, true);
        });

        function updateCabang(hadiahId, cabang, status) {
            $.ajax({
                url: '<?= base_url("home/update_cabang"); ?>',
                type: 'POST',
                data: {
                    hadiah_id: hadiahId,
                    cabang: cabang,
                    status: status ? 'true' : 'false'
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        Swal.fire('Berhasil!', data.msg, 'success');
                    } else {
                        Swal.fire('Error!', data.msg, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error!', 'Terjadi kesalahan saat memproses permintaan.', 'error');
                    console.error(xhr.responseText);
                }
            });
        }
    });
</script>