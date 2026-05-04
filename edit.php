<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kategori - UTS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    require_once 'config/database.php';
    
    $errors = [];

    // Ambil ID dari GET
    $id = $_GET['id'] ?? 0;

    if (!$id || !is_numeric($id)) {
        header("Location: index.php?msg=ID tidak valid");
        exit;
    }

    // Retrieve data berdasarkan ID
    $stmt = $conn->prepare("SELECT * FROM kategori WHERE id_kategori = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if (!$data) {
        header("Location: index.php?msg=Data tidak ditemukan");
        exit;
    }

    // Set nilai awal
    $kode = $data['kode_kategori'];
    $nama = $data['nama_kategori'];
    $deskripsi = $data['deskripsi'];
    $status = $data['status'];

    // Jika POST, proses update
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $kode = trim($_POST['kode'] ?? '');
        $nama = trim($_POST['nama'] ?? '');
        $deskripsi = trim($_POST['deskripsi'] ?? '');
        $status = $_POST['status'] ?? 'Aktif';

        // Vlidasi kode kategori
        if (empty($kode)) {
            $errors[] = "Kode kategori wajib diisi";
        } elseif (strlen($kode) < 4 || strlen($kode) > 10) {
            $errors[] = "Kode kategori harus 4-10 karakter";
        } elseif (!preg_match('/^KAT-/', $kode)) {
            $errors[] = "Kode harus diawali dengan 'KAT-'";
        }

        // Validasi nama kategori
        if (empty($nama)) {
            $errors[] = "Nama kategori wajib diisi";
        } elseif (strlen($nama) < 3 || strlen($nama) > 50) {
            $errors[] = "Nama kategori harus 3-50 karakter";
        }

        // Validasi deskripsi
        if (!empty($deskripsi) && strlen($deskripsi) > 200) {
            $errors[] = "Deskripsi maksimal 200 karakter";
        }

        // Validasi status
        if (!in_array($status, ['Aktif', 'Nonaktif'])) {
            $errors[] = "Status tidak valid";
        }

        // Cek duplikasi kode
        if (empty($errors)) {
            $stmt = $conn->prepare("SELECT id_kategori FROM kategori WHERE kode_kategori = ? AND id_kategori != ?");
            $stmt->bind_param("si", $kode, $id);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $errors[] = "Kode kategori sudah digunakan";
            }
        }

        // Jika tidak ada error, update data
        if (empty($errors)) {
            $stmt = $conn->prepare("UPDATE kategori SET kode_kategori=?, nama_kategori=?, deskripsi=?, status=? WHERE id_kategori=?");
            $stmt->bind_param("ssssi", $kode, $nama, $deskripsi, $status, $id);

            if ($stmt->execute()) {
                header("Location: index.php?msg=Kategori berhasil diperbarui");
                exit;
            } else {
                $errors[] = "Gagal update data";
            }
        }
    }
    ?>
    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-warning">
                        <h4>Edit Kategori</h4>
                    </div>
                    <div class="card-body">
                        <!-- Form dengan data pre-filled -->
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <?php foreach ($errors as $error): ?>
                                    <div><?= htmlspecialchars($error) ?></div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST">

                            <div class="mb-3">
                                <label class="form-label">Kode Kategori</label>
                                <input type="text" name="kode" class="form-control" value="<?= htmlspecialchars($kode) ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama Kategori</label>
                                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($nama) ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control"><?= htmlspecialchars($deskripsi) ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status</label><br>
                                <input type="radio" name="status" value="Aktif" <?= $status == 'Aktif' ? 'checked' : '' ?>> Aktif
                                <input type="radio" name="status" value="Nonaktif" <?= $status == 'Nonaktif' ? 'checked' : '' ?>> Nonaktif
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-warning">Update Data</button>
                                <a href="index.php" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>