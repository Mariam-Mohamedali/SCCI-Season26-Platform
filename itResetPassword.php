<?php
ob_start();
include "./includes/config.php";

/* ===============================
   ACCESS CONTROL
================================ */
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}

$crewId = (int) $_SESSION['user_id'];

$stmt = $connect->prepare("SELECT workshop_id, role FROM users WHERE user_id = ? AND status = 1");
$stmt->bind_param("i", $crewId);
$stmt->execute();
$crew = $stmt->get_result()->fetch_assoc();

if (!$crew) {
    http_response_code(403);
    die("Access denied");
}

if ((int) $crew['role'] !== 2) {
    http_response_code(403);
    die("Access denied");
}

// Fetch committee_id if not in session
if (!isset($_SESSION['committee_id'])) {
    $stmt2 = mysqli_prepare($connect, "SELECT committee_id FROM users WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt2, "i", $crewId);
    mysqli_stmt_execute($stmt2);
    $result_comm = mysqli_stmt_get_result($stmt2);
    if ($row_comm = mysqli_fetch_assoc($result_comm)) {
        $_SESSION['committee_id'] = $row_comm['committee_id'];
    }
    mysqli_stmt_close($stmt2);
}

if ($_SESSION['role'] != 2 || $_SESSION['committee_id'] != 6) {
    die("Access denied: Only IT committee members can access this panel.");
}

/* ===============================
   RESET PASSWORD HANDLER
================================ */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_password'])) {
    $target_id    = (int) ($_POST['user_id'] ?? 0);
    $new_password = $_POST['new_password'] ?? '';
    $confirm_pass = $_POST['confirm_password'] ?? '';

    $errors = [];

    if ($target_id <= 0) {
        $errors[] = "Invalid user selected.";
    }
    if (strlen($new_password) < 8) {
        $errors[] = "Password must be at least 8 characters.";
    } elseif (!preg_match("/[A-Z]/", $new_password) || !preg_match("/[a-z]/", $new_password) || !preg_match("/[0-9]/", $new_password)) {
        $errors[] = "Password must contain uppercase, lowercase, and a number.";
    } elseif ($new_password !== $confirm_pass) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($errors)) {
        // Fetch the user's name for the success message
        $stmt_name = mysqli_prepare($connect, "SELECT user_name FROM users WHERE user_id = ?");
        mysqli_stmt_bind_param($stmt_name, "i", $target_id);
        mysqli_stmt_execute($stmt_name);
        $res_name = mysqli_stmt_get_result($stmt_name);
        $target_user = mysqli_fetch_assoc($res_name);
        mysqli_stmt_close($stmt_name);

        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt_upd = mysqli_prepare($connect, "UPDATE users SET password = ? WHERE user_id = ?");
        mysqli_stmt_bind_param($stmt_upd, "si", $hashed, $target_id);

        if (mysqli_stmt_execute($stmt_upd)) {
            $_SESSION['reset_msg'] = "Password reset successfully for " . htmlspecialchars($target_user['user_name'] ?? 'User') . ".";
        } else {
            $_SESSION['reset_err'] = "Database error: " . mysqli_error($connect);
        }
        mysqli_stmt_close($stmt_upd);
    } else {
        $_SESSION['reset_err'] = implode("<br>", $errors);
    }

    header("Location: itResetPassword.php");
    exit;
}

/* ===============================
   FETCH FILTERS DATA
================================ */
$workshops  = mysqli_query($connect, "SELECT workshop_id, workshop_name FROM workshops ORDER BY workshop_name");
$committees = mysqli_query($connect, "SELECT committee_id, committe_name FROM committees ORDER BY committe_name");

/* ===============================
   FETCH ALL USERS
================================ */
$sql = "
SELECT
    u.user_id,
    u.user_name,
    u.email,
    u.phone,
    u.status,
    u.role,
    CASE u.role
        WHEN 1 THEN 'Participant'
        WHEN 2 THEN 'Member'
        WHEN 3 THEN 'Coordinator'
        WHEN 4 THEN 'Head'
        WHEN 5 THEN 'Admin'
        ELSE 'Unknown'
    END AS role_label,
    w.workshop_name,
    c.committe_name
FROM users u
LEFT JOIN workshops w ON u.workshop_id = w.workshop_id
LEFT JOIN committees c ON u.committee_id = c.committee_id
ORDER BY u.user_name ASC
";

$usersResult   = mysqli_query($connect, $sql);
if (!$usersResult) {
    die("Users Query Error: " . mysqli_error($connect));
}

/* Flash messages */
$success_msg = $_SESSION['reset_msg'] ?? '';
$error_msg   = $_SESSION['reset_err'] ?? '';
unset($_SESSION['reset_msg'], $_SESSION['reset_err']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="./assets/icons/logoSCCI.png" />
    <meta property="og:title" content="SCCI`26" />
    <meta property="og:description"
        content="SCCI is the university's premier student community, uniting creative minds to build the future of tech, media, business, and entrepreneurship." />
    <meta name="keywords"
        content="SCCI, IT, Password Reset, Student Community" />
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <!-- CSS -->
    <link rel="stylesheet" href="./assets/css/root.css?v=<?= ASSET_VERSION ?>">
    <link rel="stylesheet" href="./assets/css/itResetPassword.css?v=<?= ASSET_VERSION ?>">
    <link rel="stylesheet" href="./assets/css/all.min.css?v=<?= ASSET_VERSION ?>">
    <title>SCCI - Reset Passwords</title>
</head>

<body>
    <?php include('./includes/nav.php'); ?>

    <!-- Toast Messages -->
    <?php if ($success_msg): ?>
        <div class="toast-msg toast-success" id="toastMsg">
            <i class="fa-solid fa-circle-check"></i>
            <?= htmlspecialchars($success_msg) ?>
        </div>
    <?php elseif ($error_msg): ?>
        <div class="toast-msg toast-error" id="toastMsg">
            <i class="fa-solid fa-circle-xmark"></i>
            <?= $error_msg ?>
        </div>
    <?php endif; ?>

    <main>
        <h1>Reset User Passwords</h1>
        <hr>

        <!-- Search & Filters -->
        <div class="controls-row">
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Search by name or email...">
                <i class="fa-solid fa-magnifying-glass search-icon"></i>
            </div>

            <div class="filter-group">
                <select id="roleFilter">
                    <option value="">All Roles</option>
                    <option value="Participant">Participant</option>
                    <option value="Member">Member</option>
                    <option value="Coordinator">Coordinator</option>
                    <option value="Head">Head</option>
                    <option value="Admin">Admin</option>
                </select>

                <select id="workshopFilter">
                    <option value="">All Workshops</option>
                    <?php while ($ws = mysqli_fetch_assoc($workshops)): ?>
                        <option value="<?= htmlspecialchars($ws['workshop_name']) ?>">
                            <?= htmlspecialchars($ws['workshop_name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>

        <!-- User Table -->
        <div class="userTableScroll" id="userTableScroll">
            <table class="userTable">
                <thead class="tableHead">
                    <tr class="tableHeaderRow">
                        <th class="tableHeader">#</th>
                        <th class="tableHeader">Full Name</th>
                        <th class="tableHeader">Email</th>
                        <th class="tableHeader">Role</th>
                        <th class="tableHeader">Workshop</th>
                        <th class="tableHeader">Status</th>
                        <th class="tableHeader">Action</th>
                    </tr>
                </thead>
                <tbody class="tableBody">
                    <?php
                    $counter  = 1;
                    $hasUsers = false;
                    if ($usersResult) {
                        while ($rowUser = mysqli_fetch_assoc($usersResult)) {
                            $hasUsers    = true;
                            $statusLabel = $rowUser['status'] == 1 ? '<span class="badge badge-active">Active</span>' : '<span class="badge badge-pending">Pending</span>';
                            ?>
                            <tr class="tableRow"
                                data-role="<?= htmlspecialchars($rowUser['role_label']) ?>"
                                data-workshop="<?= htmlspecialchars($rowUser['workshop_name'] ?? '') ?>">
                                <td class="tableData"><?= $counter++ ?></td>
                                <td class="tableData"><?= htmlspecialchars($rowUser['user_name'] ?? '') ?></td>
                                <td class="tableData text-normal"><?= htmlspecialchars($rowUser['email'] ?? '') ?></td>
                                <td class="tableData">
                                    <span class="role-badge role-<?= strtolower($rowUser['role_label']) ?>">
                                        <?= htmlspecialchars($rowUser['role_label']) ?>
                                    </span>
                                </td>
                                <td class="tableData"><?= htmlspecialchars($rowUser['workshop_name'] ?? '—') ?></td>
                                <td class="tableData"><?= $statusLabel ?></td>
                                <td class="tableData">
                                    <button
                                        type="button"
                                        class="btn btn-reset js-open-reset"
                                        data-userid="<?= (int) $rowUser['user_id'] ?>"
                                        data-username="<?= htmlspecialchars($rowUser['user_name'] ?? 'User') ?>">
                                        <i class="fa-solid fa-key"></i> Reset
                                    </button>
                                </td>
                            </tr>
                        <?php }
                    }
                    if (!$hasUsers) {
                        echo '<tr><td colspan="7" class="tableData" style="text-align:center;">No users found.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-controls" id="resetPagination">
            <button class="nav-arrow prev-btn" disabled>
                <i class="fa-solid fa-caret-left"></i>
            </button>
            <span class="page-info">Page 1</span>
            <button class="nav-arrow next-btn">
                <i class="fa-solid fa-caret-right"></i>
            </button>
        </div>
    </main>

    <!-- Reset Password Modal -->
    <div class="resetModalOverlay" id="resetModalOverlay">
        <div class="resetCard">
            <div class="resetCardHeader">
                <i class="fa-solid fa-key"></i>
                <h3 id="resetModalTitle">Reset Password</h3>
            </div>

            <p id="resetModalSubtitle" class="resetSubtitle">Enter a new password for this user.</p>

            <form method="POST" action="itResetPassword.php" id="resetForm">
                <input type="hidden" name="reset_password" value="1">
                <input type="hidden" name="user_id" id="resetUserId" value="">

                <!-- New Password -->
                <div class="input-group">
                    <label for="new_password">New Password</label>
                    <div class="passwordWrapper">
                        <input
                            class="passwordInput"
                            type="password"
                            name="new_password"
                            id="new_password"
                            placeholder="Min 8 chars, upper + lower + digit"
                            autocomplete="new-password">
                        <span class="toggle-password-btn" id="toggleNewPass">
                            <i class="fas fa-eye-slash"></i>
                        </span>
                    </div>
                    <span class="error-msg" id="err-new-password"></span>
                </div>

                <!-- Confirm Password -->
                <div class="input-group">
                    <label for="confirm_password">Confirm Password</label>
                    <div class="passwordWrapper">
                        <input
                            class="passwordInput"
                            type="password"
                            name="confirm_password"
                            id="confirm_password"
                            placeholder="Repeat the new password"
                            autocomplete="new-password">
                        <span class="toggle-password-btn" id="toggleConfirmPass">
                            <i class="fas fa-eye-slash"></i>
                        </span>
                    </div>
                    <span class="error-msg" id="err-confirm-password"></span>
                </div>

                <div class="resetBtnGroup">
                    <button type="button" class="btn btn-cancel-reset" id="cancelResetBtn">Cancel</button>
                    <button type="submit" class="btn btn-do-reset" id="submitResetBtn">
                        <i class="fa-solid fa-lock-open"></i> Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="scrollTopBtn" id="scrollTopBtn">&#8593;</div>

    <script src="assets/js/all.min.js?v=<?= ASSET_VERSION ?>"></script>
    <script src="assets/js/itResetPassword.js?v=<?= ASSET_VERSION ?>"></script>
</body>

</html>
