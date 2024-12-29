<?php 
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=pemenang-undian.xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
?>
<!DOCTYPE html><html lang="en">
<head>
<meta charset="utf-8">
</head>
<body>
	<table>
        <tr><td colspan="5" align="center"><h3>Data Pemenang Undian</h3></td></tr>
    </table>

    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Undian</th>                
                <th>Nama Peserta</th>    
                <th>No HP</th>            
                <th>Alamat</th>                
                <th>Nama Hadiah</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 0;
            foreach($pemenang->result() as $item){
                $no++;
                echo "<tr>
                        <td>".$no."</td>
                        <td>".(string)$item->no_undian."</td>                        
                        <td>".$item->nama_peserta."</td>                        
                        <td>".$item->no_hp."</td> 
                        <td>".$item->alamat."</td>                        
                        <td>".$item->nama_hadiah."</td>
                     </tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>