<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الصفحة الرئيسية</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="home-container">
        <h1>مرحباً بك، <?php echo htmlspecialchars($username); ?>! 👋</h1>
        <p style="margin-top: 1rem; color: #666;">لقد تم تسجيل دخولك بنجاح إلى نظام الوزير.</p>
        
        <div style="margin-top: 2rem; padding: 1rem; background: #f9f9f9; border-radius: 8px; text-align: right;">
            <h3 style="color: #764ba2; margin-bottom: 0.5rem;">مميزات هذا النظام:</h3>
            <ul style="list-style: inside; color: #444;">
                <li>ربط كامل مع قاعدة بيانات MySQL.</li>
                <li>تشفير كلمات المرور باستخدام تقنية Hash.</li>
                <li>تصميم متجاوب وجذاب باستخدام CSS.</li>
                <li>إدارة الجلسات (Sessions) لحماية الصفحات.</li>
            </ul>
        </div>

        <a href="logout.php" class="logout-btn">تسجيل الخروج</a>
    </div>
</body>
</html>
