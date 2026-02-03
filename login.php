<?php
session_start();
require_once 'db.php';

$message = '';
$message_type = '';

if (isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (isset($pdo)) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: home.php");
                exit();
            } else {
                $message = "اسم المستخدم أو كلمة المرور غير صحيحة.";
                $message_type = "error";
            }
        } catch (PDOException $e) {
            $message = "حدث خطأ أثناء تسجيل الدخول: " . $e->getMessage();
            $message_type = "error";
        }
    } else {
        $message = "تنبيه: لم يتم الاتصال بقاعدة البيانات. (هذا العرض للمعاينة فقط)";
        $message_type = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>تسجيل الدخول</h2>
        
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label>اسم المستخدم</label>
                <input type="text" name="username" required placeholder="أدخل اسم المستخدم">
            </div>
            <div class="form-group">
                <label>كلمة المرور</label>
                <input type="password" name="password" required placeholder="********">
            </div>
            <button type="submit">دخول</button>
        </form>
        
        <div class="link">
            ليس لديك حساب؟ <a href="register.php">إنشاء حساب جديد</a>
        </div>
    </div>
</body>
</html>
