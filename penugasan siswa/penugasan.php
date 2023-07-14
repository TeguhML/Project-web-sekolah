<?php
require('sambungkan.php');

$query = "SELECT t_tugas.id, t_mapel.keterangan, t_tugas.tugas, t_tugas.dl, t_tugas.id_mapel
FROM t_tugas
INNER JOIN t_mapel ON t_tugas.id_mapel = t_mapel.id_mapel";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Detail Tugas</title>
</head>
<body>
    <div class="row justify-content-center mt-6">
      <div class="col-md-10">
        <div class="card">
          <div class="card-header text-black">
            <h3 class="text-center mb-0">List Tugas</h3>
          </div>
          <div class="card-body">
            <table class="table table-bordered text-blue">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Mata Pelajaran</th>
                  <th>Rincian Tugas</th>
                  <th>Deadline</th>
                  <th>Kerjakan</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                  <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['keterangan']; ?></td>
                    <td><?php echo $row['tugas']; ?></td>
                    <td><?php echo $row['dl']; ?></td>
                    <td>
                      <a href="index.php?page=upload_tugas&id_mapel=<?php echo $row['id_mapel']; ?>" class="btn btn-primary">Kerjakan</a>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>

<?php
mysqli_close($conn);
?>
