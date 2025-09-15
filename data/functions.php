<?php
require_once 'config.php';

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
