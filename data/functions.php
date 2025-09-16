<?php
require_once 'config.php';

// Include PHPMailer
require_once __DIR__ . '/../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Connection logic at the top, available as $pdo, $connectionError
$connectionError = '';
$pdo = null;

function db_connect() {
    global $host, $db, $user, $pass;
    $dsn_dblib = "dblib:host=$host;dbname=$db";
    try {
        $pdo = new PDO($dsn_dblib, $user, $pass);
        return $pdo;
    } catch (PDOException $e) {
        return null;
    }
}

$pdo = db_connect();
if (!$pdo) 
    $connectionError = 'Could not connect to database.';

function get_online_users($pdo) {
    try {
        $stmt = $pdo->query("SELECT COUNT(*) FROM MEMB_STAT WHERE ConnectStat = 1");
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        return 0;
    }
}

function register($pdo, $username, $password, $email) {
    // Returns [success(bool), error(string)]
    if (strlen($username) < 3 || strlen($username) > 10) {
        return [false, 'Username must be 3-10 characters.'];
    }
    if (strlen($password) < 3 || strlen($password) > 10) {
        return [false, 'Password must be 3-10 characters.'];
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return [false, 'Invalid email address.'];
    }
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM MEMB_INFO WHERE memb___id = ?"); 
        $stmt->execute([$username]);
        if ($stmt->fetchColumn() > 0) {
            return [false, 'Username already exists.'];
        }
        $stmt = $pdo->prepare("INSERT INTO MEMB_INFO (memb___id, memb_name, memb__pwd, mail_addr, sno__numb, bloc_code, ctl1_code) VALUES (?, ?, ?, ?, 0, 0, 0)");
        if ($stmt->execute([$username, $username, $password, $email])) {
            return [true, ''];
        } else {
            return [false, 'Registration failed. Please try again.'];
        }
    } catch (PDOException $e) {
        return [false, 'Registration failed. Please try again.'.$e];
    }
}

function login($pdo, $username, $password) {
    // Returns [success(bool), error(string)]
    if (strlen($username) < 3 || strlen($username) > 10) {
        return [false, 'Username must be 3-10 characters.'];
    }
    if (strlen($password) < 3 || strlen($password) > 10) {
        return [false, 'Password must be 3-10 characters.'];
    }
    try {
        $stmt = $pdo->prepare("SELECT memb__pwd FROM MEMB_INFO WHERE memb___id = ?");
        $stmt->execute([$username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && $row['memb__pwd'] === $password) {
            return [true, ''];
        } else {
            return [false, 'Invalid username or password.'];
        }
    } catch (PDOException $e) {
        return [false, 'Login failed. Please try again.'.$e];
    }
}

function get_user_wcoins($pdo, $username) {
    // Returns the WCoinC amount for a user or 0 if not found/error.
    try {
        $stmt = $pdo->prepare("SELECT WCoinC FROM CashShopData WHERE AccountID = ?");
        $stmt->execute([$username]);
        $result = $stmt->fetchColumn();
        return $result !== false ? (int)$result : 0;
    } catch (PDOException $e) {
        // Optionally log the error: error_log($e->getMessage());
        return 0;
    }
}

function get_user_characters($pdo, $username) {
    // Returns an array of characters for a given account.
    try {
        $stmt = $pdo->prepare(
            "SELECT Name, cLevel, Class, ResetCount 
             FROM Character 
             WHERE AccountID = ? 
             ORDER BY cLevel DESC"
        );
        $stmt->execute([$username]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Optionally log the error: error_log($e->getMessage());
        return [];
    }
}

function get_top_players($pdo, $limit = 20) {
    // Assumes 'Character' table with 'Name', 'cLevel', 'Class', 'ResetCount'
    // and 'GuildMember' table with 'Name', 'G_Name'
    try {
        $stmt = $pdo->prepare(
            "SELECT TOP $limit c.Name, c.cLevel, c.Class, c.ResetCount, gm.G_Name AS Guild
             FROM Character c
             LEFT JOIN GuildMember gm ON c.Name = gm.Name
             ORDER BY c.ResetCount DESC, c.cLevel DESC, c.Name ASC"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

function class_id_to_name($classId) {
    // MU Online class mapping
    $classes = [
        0 => 'Dark Wizard',
        1 => 'Soul Master',
        2 => 'Grand Master',
        16 => 'Dark Knight',
        17 => 'Blade Knight',
        18 => 'Blade Master',
        32 => 'Fairy Elf',
        33 => 'Muse Elf',
        34 => 'High Elf',
        48 => 'Magic Gladiator',
        49 => 'Duel Master',
        64 => 'Dark Lord',
        66 => 'Lord Emperor',
        80 => 'Summoner',
        81 => 'Bloody Summoner',
        82 => 'Dimension Master',
        96 => 'Rage Fighter',
        97 => 'Fist Master'
        // Add more if needed
    ];
    return $classes[$classId] ?? 'Unknown';
}

/**
 * Initiates the password reset process for a user.
 *
 * @param PDO $pdo The database connection object.
 * @param string $username The user's username.
 * @return array An array containing [bool $success, array $dataOrError]. On success, $dataOrError is ['token' => string, 'email' => string].
 */
function requestPasswordReset(PDO $pdo, string $username): array
{
    // 1. Validate username format
    if (strlen($username) < 3 || strlen($username) > 10) {
        return [false, 'Invalid username format.'];
    }

    // 2. Check if the username exists in MEMB_INFO and get their email
    $stmt = $pdo->prepare("SELECT mail_addr FROM MEMB_INFO WHERE memb___id = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if (!$user || empty($user['mail_addr'])) {
        // User not found or has no email. Return true to prevent user enumeration.
        // The API will handle sending a generic success message.
        return [true, []];
    }

    $email = $user['mail_addr'];

    // 3. Generate a secure token and expiration date
    try {
        $token = bin2hex(random_bytes(32)); // 64 characters long
    } catch (Exception $e) {
        // Handle failure of random_bytes
        return [false, ['error' => 'Could not generate a secure token.']];
    }
    $expires = new DateTime('now', new DateTimeZone('UTC'));
    $expires->add(new DateInterval('PT1H')); // Token expires in 1 hour
    $expires_at = $expires->format('Y-m-d H:i:s');

    // 4. Store the token in the password_resets table (upsert logic for MS SQL)
    // Check if a token for the user already exists.
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM password_resets WHERE username = ?");
    $stmt->execute([$username]);
    $exists = $stmt->fetchColumn() > 0;

    if ($exists) {
        // Update the existing token
        $stmt = $pdo->prepare("UPDATE password_resets SET token = ?, expires_at = ? WHERE username = ?");
        $stmt->execute([$token, $expires_at, $username]);
    } else {
        // Insert a new token
        $stmt = $pdo->prepare("INSERT INTO password_resets (username, token, expires_at) VALUES (?, ?, ?)");
        $stmt->execute([$username, $token, $expires_at]);
    }

    // 5. Return the token and email so they can be used to build and send the email
    return [true, ['token' => $token, 'email' => $email]];
}

/**
 * Sends an email using PHPMailer and SMTP settings from config.
 *
 * @param string $to The recipient's email address.
 * @param string $subject The email subject.
 * @param string $body The plain text body of the email.
 * @return bool True on success, false on failure.
 */
function sendSmtpMail(string $to, string $subject, string $body): bool
{
    global $smtpHost, $smtpUser, $passwordSMTP, $smtpPort, $smtpSecure;

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = $smtpHost;
        $mail->SMTPAuth   = true;
        $mail->Username   = $smtpUser;
        $mail->Password   = $passwordSMTP;
        $mail->SMTPSecure = $smtpSecure;
        $mail->Port       = $smtpPort;

        //Recipients
        $mail->setFrom($smtpUser, 'HexMU Support');
        $mail->addAddress($to);

        //Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = nl2br(htmlspecialchars($body)); // Convert newlines to <br> and escape HTML
        $mail->AltBody = $body; // Plain text version

        return $mail->send();
    } catch (Exception $e) {
        error_log("PHPMailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

/**
 * Resets a user's password using a valid token.
 *
 * @param PDO $pdo The database connection object.
 * @param string $token The password reset token from the URL.
 * @param string $newPassword The new password provided by the user.
 * @return array An array containing [bool $success, string $message].
 */
function resetPassword(PDO $pdo, string $token, string $newPassword): array
{
    // 1. Validate new password length
    if (strlen($newPassword) < 3 || strlen($newPassword) > 10) {
        return [false, 'Password must be 3-10 characters.'];
    }

    // 2. Find the token in the database and ensure it's not expired
    $stmt = $pdo->prepare("SELECT username, expires_at FROM password_resets WHERE token = ?");
    $stmt->execute([$token]);
    $resetRequest = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$resetRequest) {
        return [false, 'Invalid or expired reset token. Please try again.'];
    }

    // 3. Check if the token has expired
    $now = new DateTime('now', new DateTimeZone('UTC'));
    $expires = new DateTime($resetRequest['expires_at'], new DateTimeZone('UTC'));

    if ($now > $expires) {
        // Clean up expired token
        $stmt = $pdo->prepare("DELETE FROM password_resets WHERE token = ?");
        $stmt->execute([$token]);
        return [false, 'Invalid or expired reset token. Please try again.'];
    }

    // 4. Update the user's password in MEMB_INFO
    $username = $resetRequest['username'];
    $stmt = $pdo->prepare("UPDATE MEMB_INFO SET memb__pwd = ? WHERE memb___id = ?");
    $stmt->execute([$newPassword, $username]);

    // 5. Delete the used token from the password_resets table
    $stmt = $pdo->prepare("DELETE FROM password_resets WHERE username = ?");
    $stmt->execute([$username]);

    return [true, 'Your password has been updated successfully! You can now log in.'];
}

/**
 * Gets the donation history for a specific user.
 *
 * @param PDO $pdo The database connection object.
 * @param string $username The user's username.
 * @return array An array of donation records.
 */
function get_user_donations(PDO $pdo, string $username): array
{
    try {
        $stmt = $pdo->prepare("SELECT amount_usd, wcoins_received, payment_method, transaction_id, created_at FROM donation_history WHERE username = ? ORDER BY created_at DESC");
        $stmt->execute([$username]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Donation History Error: " . $e->getMessage());
        return [];
    }
}
