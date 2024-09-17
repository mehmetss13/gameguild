<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Dosya yükleme dizini
$uploadDir = 'uploads/';

// Dosyanın yüklendiğinde başarılı olup olmadığını kontrol edelim
if (isset($_FILES['savefile'])) {
    $fileError = $_FILES['savefile']['error'];

    if ($fileError === UPLOAD_ERR_OK) {
        // Dosya bilgilerini alıyoruz
        $fileTmpPath = $_FILES['savefile']['tmp_name'];
        $fileName = $_FILES['savefile']['name'];
        $fileSize = $_FILES['savefile']['size'];
        $fileType = $_FILES['savefile']['type'];

        // Dosya uzantısını alıyoruz
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Desteklenen uzantılar
        $allowedExtensions = array('sav', 'zip');

        if (in_array($fileExtension, $allowedExtensions)) {
            // Yeni bir isim ile dosyayı yüklüyoruz
            $newFileName = uniqid() . '.' . $fileExtension;
            $dest_path = $uploadDir . $newFileName;

            // Yükleme dizinini kontrol et ve yoksa oluştur
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Dosyayı yükleme dizinine taşıyoruz
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                echo "Dosya başarıyla yüklendi!";
            } else {
                echo "Dosya yükleme sırasında bir hata oluştu. Dosya taşınamadı.";
            }
        } else {
            echo "Sadece .sav veya .zip dosyaları yüklenebilir.";
        }
    } else {
        // Hata koduna göre açıklama yapalım
        switch ($fileError) {
            case UPLOAD_ERR_INI_SIZE:
                echo "Dosya, php.ini'deki upload_max_filesize limitini aşıyor.";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                echo "Dosya, formda belirtilen MAX_FILE_SIZE limitini aşıyor.";
                break;
            case UPLOAD_ERR_PARTIAL:
                echo "Dosyanın sadece bir kısmı yüklendi.";
                break;
            case UPLOAD_ERR_NO_FILE:
                echo "Hiçbir dosya yüklenmedi.";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                echo "Geçici bir dizin eksik.";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                echo "Dosya diske yazılamadı.";
                break;
            case UPLOAD_ERR_EXTENSION:
                echo "Dosya yükleme PHP uzantısı tarafından durduruldu.";
                break;
            default:
                echo "Bilinmeyen bir hata oluştu.";
                break;
        }
    }
} else {
    echo "Dosya yüklenirken bir hata oluştu.";
}
?>
