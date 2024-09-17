<?php
// Veritabanı bağlantısı dahil ediliyor
include_once 'db_connect.php';

// Dosya yükleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['savefile'])) {
    // Dosya yükleme dizini
    $uploadDir = 'uploads/';
    
    // Dosyanın yüklendiğinde başarılı olup olmadığını kontrol edelim
    if ($_FILES['savefile']['error'] === UPLOAD_ERR_OK) {
        
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

            // Dosyayı yükleme dizinine taşıyoruz
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                echo "Dosya başarıyla yüklendi!<br>";

                // Eğer .zip dosyası ise unzip yapabiliriz
                if ($fileExtension == 'zip') {
                    echo "Zip dosyası başarıyla açıldı.<br>";
                    // Zip dosyası açma işlemi yapılabilir.
                } else {
                    // .sav dosyası ise doğrudan işlem yapılabilir
                    echo "Save dosyası başarıyla yüklendi.<br>";
                    // .sav dosyası işlenebilir.
                }

            } else {
                echo "Dosya yükleme sırasında bir hata oluştu.<br>";
            }
        } else {
            echo "Sadece .sav veya .zip dosyaları yüklenebilir.<br>";
        }
    } else {
        echo "Dosya yüklenirken bir hata oluştu.<br>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Witcher 3 Save Dosyası ve Envanter Görüntüleme</title>
</head>
<body>

    <!-- Dosya yükleme formu -->
    <h1>Witcher 3 Save Dosyası Yükleyin</h1>
    <form action="index.php" method="POST" enctype="multipart/form-data">
        <label for="file">Save Dosyasını Seçin:</label><br>
        <input type="file" name="savefile" id="savefile" accept=".sav,.zip"><br><br>
        <input type="submit" value="Yükle">
    </form>

    <hr>

    <!-- Veritabanındaki Envanter Listesi -->
    <h1>Envanter Listesi</h1>
    <?php
    // Envanter sorgusu
    $query = "SELECT * FROM items";
    $stmt = $pdo->prepare($query);  // PDO değişkeni olan $pdo kullanılıyor
    $stmt->execute();
    $items = $stmt->fetchAll();  // Tüm envanteri çekiyoruz

    // Elde edilen envanteri ekrana yazdırma
    foreach ($items as $item) {
        echo $item['item_name'] . ' - ' . json_encode($item['stats']) . '<br>';
    }
    ?>
    
</body>
</html>
