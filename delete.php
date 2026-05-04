<?php
require_once 'config/database.php';

// Validasi ID dari GET
$id = $_GET['id'] ?? 0;

if (!$id || !is_numeric($id)) {
    header("Location: index.php?msg=ID tidak valid");
    exit;
}

// Cek keberadaan data
$stmt = $conn->prepare("SELECT id_kategori FROM kategori WHERE id_kategori = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    header("Location: index.php?msg=Data tidak ditemukan");
    exit;
}

// Delete data
$stmt = $conn->prepare("DELETE FROM kategori WHERE id_kategori = ?");
$stmt->bind_param("i", $id);

//Redirect dengan pesan
if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        header("Location: index.php?msg=Kategori berhasil dihapus");
        exit;
    } else {
        header("Location: index.php?msg=Gagal menghapus data");
        exit;
    }
} else {
    header("Location: index.php?msg=Terjadi kesalahan saat menghapus");
    exit;
}
