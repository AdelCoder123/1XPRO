<?php
session_start();
$error = '';

// التحقق من الكود المدخل
if (isset($_POST['submit'])) {
    // التحقق إذا كان الكود موجودًا في الجلسة ولم يتم استخدامه بعد
    if (isset($_SESSION['codes']) && in_array($_POST['code'], $_SESSION['codes'])) {
        // التحقق مما إذا تم استخدام الكود من قبل
        if (!isset($_SESSION['used_codes'][$_POST['code']])) {
            // تعيين الكود كـ "مستخدم"
            $_SESSION['used_codes'][$_POST['code']] = true;
            $_SESSION['authenticated'] = true;
            header('Location: success.php');
            exit;
        } else {
            $error = 'الكود تم استخدامه مسبقًا.';
        }
    } else {
        $error = 'الكود غير صحيح.';
    }
}

// إعادة المستخدم إلى صفحة تسجيل الدخول إذا انتهى الوقت
if (isset($_SESSION['last_update'])) {
    if (time() - $_SESSION['last_update'] > 600) { // 10 دقائق
        session_destroy();
        header('Location: index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .login-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="login-form">
        <h2>أدخل الكود</h2>
        <form method="post">
            <input type="text" name="code" placeholder="أدخل الكود" required>
            <button type="submit" name="submit">تحقق</button>
        </form>
        <p style="color: red;"><?php echo $error; ?></p>
    </div>
</body>
</html>
