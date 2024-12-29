<link href="../../../../assets/css/home.css" rel="stylesheet" type="text/css">
<audio class="audio" id="audio">
  <source src="<?php echo base_url() ?>assets/music.mp3" type="audio/ogg">
  <source src="<?php echo base_url() ?>assets/music.mp3" type="audio/mpeg">
</audio><audio class="audio-menang" id="audio-menang">
  <source src="<?php echo base_url() ?>assets/menang.mp3" type="audio/ogg">
  <source src="<?php echo base_url() ?>assets/menang.mp3" type="audio/mpeg">
</audio>
<div class="container-fluid page" id="undian">
  <!-- <div class="row">
    <div class="col-md-12 text-center" style="margin-top:20px;"> <img src="<?php echo base_url() ?>assets/img/<?php echo $pengaturan->logo ?>" style="max-height: 70px;" />
      <div class="row">
        <div class="col-md-6 col-xs-12 offset-md-3">
          <h4 align="center" id="judul-undian"><?php echo $pengaturan->nama_undian ?></h4>
        </div>
      </div>
    </div>
  </div> -->
  <div class="row">
    <div class="col-md-5 mt-5">
    <div class="row">
        <div class="col-md-6 col-xs-12 offset-md-3">
          <center>
            <img src="<?php echo base_url() ?>assets/img/<?php echo $pengaturan->logo ?>" style="max-height: 70px;" />
          </center>
          <h4 align="center" id="judul-undian"><?php echo $pengaturan->nama_undian ?></h4>
        </div>
      </div>
      <div class="kolom-list-rewards">
        <h5 class="title-list">Reward :</h5>
        <input type="hidden" id="baseurl" value="@ViewBag.BaseUrl" />
        <select name="select" class="form-control rewards-options">
          <option value="" selected="selected">[ Pilih Reward ]</option>
          <?php foreach ($hadiah->result() as $row) { ?>
            <?php if ($row->cabang != [] || $row->cabang != null) { ?>
              <option value="<?php echo $row->ta_hadiah_id . '|' . $row->gambar_hadiah ?>"> <?php echo $row->kategori_hadiah ?></option>
            <?php } ?>
          <?php } ?>
        </select>
        <div class="text-center">
          <img id="preview-rewards" class="img-fluid" style="max-width: 60%;" />
          <h5 class="title-list">Hadiah Cabang:</h5>
          <ul id="cabang-rewards-list" class="list-unstyled mt-2"></ul>
        </div>
      </div>
      <a href="javascript:void(0)" class="btn btn-sm btn-block btn-light pengaturan mb-5" style="margin-bottom: 20px;"><i class="fa fa-"></i> Pengaturan Tambahan</a>
    </div>
    <div class="col-md-7 text-center undian">
      <h1 style="margin-top:30px;" class="nomor-undian acak-name" id="nomor">0000000</h1>
      <div style="margin-top:30px;">
        <button type="button" class="btn-acak">MULAI ACAK</button>
        <br />
      </div>
      <div class="data" style="padding:10px; margin-bottom:20px;">
        <h2>
          <!--<h4 id="keterangan">No. Transaksi</h4>-->
        </h2>
        <h1 id="nama"><strong>[ _ _ _ _ _ _ _ _ _ ]</strong></h1>
        <h4 id="alamat">[ _ _ _ _ _ _ _ _ _ _ _ _ _ _ ]</h4>
      </div>
      <button type="button" class="btn btn-lg btn-warning rounded btn-block mb-2" id="btn-save-result">SIMPAN</button>

      <div class="kolom-list" >
        <h5 class="title-list">Selamat Kepada :</h5>
        <div class="kolom" >
          <table class="table" style="color: white;">
            <tbody>
              <?php
              $no = 0;
              foreach ($nama_pemenang->result() as $item) {
                $no++;
                echo "<tr>";
                echo "<td>" . $item->nama_peserta . "</td>";
                echo "<td>" . $item->kategori_hadiah . "</td>";
                echo "<td>" . $item->no_undian . "</td>";
                echo "</tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- <div class="col-md-3 mt-4">
      
    </div> -->
  </div>
  <div class="modal" id="ModalPengaturan" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Pengaturan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <?php echo form_open_multipart("home/update-waktu-undian", "class='form-submit'") ?>
        <div class="modal-body">
          <div class="form-group row">
            <label for="jumlah_pemenang" class="col-sm-6 col-form-label">Jumlah Pemenang</label>
            <div class="col-sm-6">
              <input type="text" class="form-control angka" name="jumlah_pemenang" id="jumlah_pemenang" value="<?php echo $pengaturan->jumlah_pemenang ?>">
              <div class="text-danger err jumlah_pemenang"></div>
            </div>
          </div>
          <div class="form-group row">
            <label for="jumlah_pemenang" class="col-sm-6 col-form-label">Lama Waktu Putaran (detik)</label>
            <div class="col-sm-6">
              <input type="text" class="form-control angka" name="waktu_putaran" id="waktu_putaran" value="<?php echo $pengaturan->waktu_putaran ?>">
              <span style="font-size: 12px; font-style: italic;">0 berarti tidak terbatas</span>
              <div class="text-danger err waktu_putaran"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <img src="<?php echo base_url() ?>assets/img/loading.gif" class="loading" id="loading1" /><button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button><button type="submit" class="btn btn-primary" id="simpan-pengaturan">Simpan</button>
        </div><?php echo form_close() ?>
      </div>
    </div>
  </div><input type="hidden" name="base_url" id="base_url" value="<?php echo base_url() ?>"><input type="hidden" name="lama_putaran_detik" id="lama_putaran_detik" value="<?php echo $pengaturan->waktu_putaran ?>"><input type="hidden" name="jumlah_pemenang" id="jumlah_pemenang" value="<?php echo $pengaturan->jumlah_pemenang ?>"><input type="hidden" name="hitung_mundur" id="hitung_mundur" value="<?php echo $pengaturan->waktu_putaran ?>"><input type="hidden" id="sudah_menang" value="<?php echo $nama_pemenang->num_rows() ?>"><?php $this->load->view("footer"); ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    var lama_putaran_detik = $("#lama_putaran_detik").val();
    var jumlah_pemenang = $("#jumlah_pemenang").val();
    var hitung_mundur = $("#hitung_mundur").val();
    var audio = document.getElementById("audio");
    var audiomenang = document.getElementById("audio-menang");
    audio.loop = true;
    audiomenang.loop = false;
    audio.loop = true;
    var timer;
    var jumlah_putaran = 1;
    var mode_putaran = "Manual";
    var sudah_menang = 0;
    var arrayPesertaBaru = [];
    var awal = 1;
    var akhir = 0;

    function peserta() {
      $.ajax({
        url: base_url + "home/peserta_baru",
        type: 'POST',
        data: {},
        success: function(data) {
          //alert(data);                         
          var obj = $.parseJSON(data);
          arrayPesertaBaru = [];
          $.each(obj, function(index, value) {
            arrayPesertaBaru.push(value);
          });
          akhir = arrayPesertaBaru.length;

          $(".btn-start").removeAttr('disabled');
          $(".btn-stop").attr('disabled', 'disabled');
        }
      });
      console.log(arrayPesertaBaru);
    }
    peserta();

    function startCount() {
      timer1 = setInterval(function() {
        random = getRandomInt();
        $(".btn-start").text(hitung_mundur);
        hitung_mundur--;
        if (hitung_mundur == 0) {
          stop_random();
          clearTimeout(timer1);
        }
      }, 1000);
    }

    function startFinal() {
      timer2 = setInterval(function() {
        timerFinal++;
        if (timerFinal == 2) {
          $(".acak-name").addClass("blur-text");
          $("#btn-start-automatis").removeClass("btn-red");
          $("#btn-start-automatis").addClass("btn-start-automatis");
          startCount();
          start_random();
          clearTimeout(timer2);
        }
      }, 1000);
    }


    function getRandomInt() {
      min = Math.floor(awal);
      max = Math.floor(arrayPesertaBaru.length);
      return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    function startTimer() {
      timer = setInterval(function() {
        random = getRandomInt();
        $('.acak-name').text(arrayPesertaBaru[random - 1]);
      }, 50);
    }
    // $(".rewards-options").change(function (e) {
    //     var url_id = $(".rewards-options").val();
    //     tmp = url_id.split("|");
    //     url = $("#base_url").val()+"assets/img/"+ tmp[1];
    //     $('#preview-rewards').attr('src', url);        
    // })

    $(".rewards-options").change(function(e) {
      var url_id = $(".rewards-options").val();

      if (url_id === "") {
        $('#preview-rewards').attr('src', '');
        $('#cabang-rewards-list').empty();
        return;
      }

      var tmp = url_id.split("|");
      var url = $("#base_url").val() + "assets/img/" + tmp[1];
      $('#preview-rewards').attr('src', url);

      // Kirim AJAX request untuk mendapatkan data cabang
      $.ajax({
        url: base_url + 'home/get_cabang/' + tmp[0], // ID hadiah
        type: 'GET',
        success: function(response) {
          if (typeof response === 'string') {
            try {
                response = JSON.parse(response); // Parse string ke objek jika perlu
            } catch (e) {
                console.error('Error parsing response:', e);
            }
        }
          // Memeriksa apakah response adalah objek JavaScript
          console.log('Response:', response); // Pastikan response diterima sebagai objek

          // Mengakses data cabang dengan aman
          var cabangArray = response.cabang || []; // Jika cabang tidak ada, beri nilai default []
          console.log('Cabang Array:', cabangArray);
          $('#cabang-rewards-list').empty(); // Kosongkan list cabang sebelumnya

          if (cabangArray.length > 0) {
            // Loop dan tampilkan list cabang
            cabangArray.forEach(function(cabang) {
              $('#cabang-rewards-list').append('<li>• ' + cabang + '</li>');
            });
            getPesertaByCabang(cabangArray);

          } else {
            Swal.fire({
              icon: 'warning',
              title: 'Cabang Kosong',
              text: 'Mohon tambahkan cabang untuk hadiah tersebut.'
            });
          }
        },
        error: function(xhr, status, error) {
          console.error('AJAX Error: ' + error);
        }
      });
    });


  // Fungsi untuk mengambil peserta berdasarkan cabang yang dipilih
  function getPesertaByCabang(cabangArray) {
      $.ajax({
          url: base_url + "home/get_peserta_by_cabang",  // Endpoint untuk mendapatkan peserta berdasarkan cabang
          type: 'POST',
          data: { cabang: cabangArray },  // Kirim cabang yang dipilih
          success: function(data) {
              var obj = $.parseJSON(data);
              arrayPesertaBaru = []; // Reset array peserta baru
              $.each(obj, function(index, value) {
                  arrayPesertaBaru.push(value);  // Tambahkan peserta ke array
              });
              console.log('Peserta Baru BY:', arrayPesertaBaru);

              $(".btn-start").removeAttr('disabled');
              $(".btn-stop").attr('disabled', 'disabled');
          },
          error: function(xhr, status, error) {
              console.error('Error fetching peserta:', error);
          }
      });
  }

    var url_id = $(".rewards-options").val();


    $(".btn-acak").click(function(e) {
      $("#nama").html("[ _ _ _ _ _ _ _ _ _ ]");
      $("#alamat").html("[ _ _ _ _ _ _ _ _ _ _ _ _ _ _ ]");
      var text = $(this).text();
      if ($(".rewards-options").val() == "") {
        alert("Mohon pilih reward terlebih dahulu !");
      } else {
        if (jumlah_pemenang == 1) {
          if (lama_putaran_detik == 0) {

            if (text == "MULAI ACAK") {
              start_random();
            } else {
              stop_random();
            }
          } else {
            $(".btn-acak").prop('disabled', true);
            mode_putaran = "Automatis";
            startCount();
            start_random();
          }
        } else {
          if (lama_putaran_detik == 0) {

            if (text == "MULAI ACAK") {
              start_random();
            } else {
              stop_random();
            }
          } else {
            $(".btn-acak").prop('disabled', true);
            mode_putaran = "Automatis";
            startCount();
            start_random();
          }
        }
      }
    })

    function start_random() {
      audio.play();
      $(".btn-acak").text("BERHENTI");
      $("#btn-save-result").prop('disabled', true);
      startTimer();
    }

    function stop_random() {
      audio.pause();
      audio.currentTime = 0;
      audiomenang.play();
      clearTimeout(timer);
      $(".btn-acak").text("MULAI ACAK");
      $.ajax({
        url: base_url + "home/get-undian-data",
        type: 'POST',
        data: {
          nomor: $(".acak-name").html()
        },
        success: function(data) {
          peserta();
          var res = data.split("|");
          $("#nama").html(res[1]);
          $("#alamat").html(res[2]);
          $("#btn-save-result").prop('disabled', false);

          if (lama_putaran_detik > 0) {
            simpan_result();
          }
        }
      });
    }
    //
    $("#btn-save-result").click(function(e) {
      $("#btn-save-result").prop('disabled', true);
      simpan_result();
    })


    function simpan_result() {
      if ($(".rewards-options").val() == "") {
        alert("Mohon pilih reward terlebih dahulu !");
        return false;
      }
      var angka = $("#jumlah_pemenang").val();
      angka++;
      sudah_menang++;
      $.ajax({
        type: "POST",
        url: base_url + "home/save-result",
        data: {
          'rewards': $(".rewards-options").val(),
          'nomor': $(".acak-name").html(),
          'pemenang_ke': sudah_menang
        },
        success: function(data) {
          var namaPeserta = $("#nama").text();
          var namaHadiah = data;
          var nomor = $("#nomor").text();
          var tableRow = "<tr><td>" + namaPeserta + "</td><td>" + namaHadiah + "</td><td>" + nomor + "</td></tr>";
          $(".kolom table").prepend(tableRow);
          peserta();
          if (mode_putaran == "Automatis") {
            if (sudah_menang < jumlah_pemenang) {
              hitung_mundur = lama_putaran_detik;
              timerFinal = 0;
              startFinal();
            }
          }
        }
      })
    }
    $(".pengaturan").click(function(e) {
      $("#ModalPengaturan").modal("show");
    })
  </script>