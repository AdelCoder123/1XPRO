<?php
session_start();

// توليد أكواد عشوائية
function generateRandomCode() {
    return strtoupper(bin2hex(random_bytes(4))); // كود مكون من 8 أحرف
}

// التحقق من وقت التحديث
$timeElapsed = 0;
if (isset($_SESSION['last_update'])) {
    $timeElapsed = time() - $_SESSION['last_update'];
}

// تحديث الأكواد كل 10 دقائق
if ($timeElapsed > 600 || !isset($_SESSION['codes'])) { // 600 ثانية = 10 دقائق
    $_SESSION['codes'] = array();
    for ($i = 0; $i < 10; $i++) {
        $_SESSION['codes'][] = generateRandomCode();
    }
    $_SESSION['last_update'] = time();
}

// عرض الأكواد
$codes = $_SESSION['codes'];
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>لوحة التحكم</title>
    <style>
        body {
            background-color: black;
            color: white;
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }
        .code {
            margin: 10px 0;
            font-size: 24px;
        }
    </style>
</head>
<body>
    <h1>لوحة التحكم</h1>
    <div>
        <?php foreach ($codes as $code): ?>
            <div class="code"><?php echo $code; ?></div>
        <?php endforeach; ?>
    </div>
    <p>الكود سيتغير تلقائيًا كل 10 دقائق.</p>
</body>
</html>
