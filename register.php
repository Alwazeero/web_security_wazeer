<?php
require_once 'db.php';

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    if (isset($pdo)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hashed_password]);
            $message = "تم إنشاء الحساب بنجاح! يمكنك الآن تسجيل الدخول.";
            $message_type = "success";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $message = "اسم المستخدم أو البريد الإلكتروني مسجل مسبقاً.";
            } else {
                $message = "حدث خطأ أثناء التسجيل: " . $e->getMessage();
            }
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
    <title>إنشاء حساب جديد</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>إنشاء حساب جديد</h2>
        
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form action="register.php" method="POST">
            <div class="form-group">
                <label>اسم المستخدم</label>
                <input type="text" name="username" required placeholder="أدخل اسم المستخدم">
            </div>
            <div class="form-group">
                <label>البريد الإلكتروني</label>
                <input type="email" name="email" required placeholder="example@mail.com">
            </div>
            <div class="form-group">
                <label>كلمة المرور</label>
                <input type="password" name="password" required placeholder="********">
            </div>
            <button type="submit">تسجيل</button>
        </form>
        
        <div class="link">
            لديك حساب بالفعل؟ <a href="login.php">تسجيل الدخول من هنا</a>
        </div>
    </div>
</body>
</html>
