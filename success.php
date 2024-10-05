<?php
session_start();

// التحقق مما إذا كان المستخدم مصرح له
if (!isset($_SESSION['authenticated'])) {
    header('Location: index.php');
    exit;
}

// التحقق من وقت انتهاء الجلسة (10 دقائق)
$timeElapsed = time() - $_SESSION['last_update'];
$timeRemaining = 600 - $timeElapsed; // حساب الوقت المتبقي

if ($timeRemaining <= 0) { // إذا انتهت الجلسة، إعادة المستخدم إلى صفحة تسجيل الدخول
    session_destroy();
    header('Location: index.php');
    exit;
}

// تحويل الوقت المتبقي إلى دقائق وثواني
$minutes = floor($timeRemaining / 60);
$seconds = $timeRemaining % 60;

?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>نجاح</title>
    <style>
        body {
            background-color: white;
            color: black;
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }
    </style>
    <script>
        // عرض الوقت المتبقي بشكل ديناميكي
        let timeRemaining = <?php echo $timeRemaining; ?>;
        function startCountdown() {
            const countdownElement = document.getElementById('countdown');
            const interval = setInterval(() => {
                if (timeRemaining <= 0) {
                    clearInterval(interval);
                    window.location.href = 'index.php'; // إعادة التوجيه إلى صفحة تسجيل الدخول عند انتهاء الوقت
                } else {
                    timeRemaining--;
                    let minutes = Math.floor(timeRemaining / 60);
                    let seconds = timeRemaining % 60;
                    countdownElement.innerText = minutes + ' دقيقة و ' + seconds + ' ثانية';
                }
            }, 1000); // تحديث العد كل ثانية
        }
        window.onload = startCountdown;
    </script>
</head>
<body>
    <h1>تم التحقق بنجاح!</h1>
    <p>الوقت المتبقي لتغيير الأكواد:</p>
    <p id="countdown"><?php echo $minutes . ' دقيقة و ' . $seconds . ' ثانية'; ?></p>
</body>
</html>
