<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Head Panel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="icon" href="assets/icons/logoSCCI.png" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Irish+Grover&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Stencil&display=swap" rel="stylesheet">

    <!-- css -->
    <link rel="stylesheet" href="./assets/css/headPanel.css">
    <link rel="stylesheet" href="./assets/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php

    include('./includes/nav.php');

    // Handle blocking user via POST
    $blocked_message = '';

    // Handle blocking user
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['block_user_id'])) {
        $id = intval($_POST['block_user_id']);
        $section = isset($_POST['section']) ? $_POST['section'] : 'participants';

        // Fetch image before deletion
        $result = mysqli_query($connect, "SELECT image FROM users WHERE user_id = $id");
        if ($result && $row = mysqli_fetch_assoc($result)) {
            $image_path = './assets/uploadedImages/' . $row['image'];
            if (file_exists($image_path) && $row['image'] != 'default.png') {
                unlink($image_path);
            }
        }

        mysqli_query($connect, "SET FOREIGN_KEY_CHECKS=0");
        mysqli_query($connect, "DELETE FROM users WHERE user_id = $id");
        mysqli_query($connect, "SET FOREIGN_KEY_CHECKS=1");
        header("Location: headPanel.php?section=$section");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
        $id = intval($_POST['delete']);
        $section = isset($_POST['section']) ? $_POST['section'] : 'participants';

        // Fetch image before deletion
        $result = mysqli_query($connect, "SELECT image FROM users WHERE user_id = $id");
        if ($result && $row = mysqli_fetch_assoc($result)) {
            $image_path = './assets/uploadedImages/' . $row['image'];
            if (file_exists($image_path) && $row['image'] != 'default.png') {
                unlink($image_path);
            }
        }

        mysqli_query($connect, "SET FOREIGN_KEY_CHECKS=0");
        mysqli_query($connect, "DELETE FROM users WHERE user_id = $id");
        mysqli_query($connect, "SET FOREIGN_KEY_CHECKS=1");
        header("Location: headPanel.php?section=$section");
        exit();
    }

    // Fetch participants
    $participants = mysqli_query($connect, "SELECT * FROM users WHERE role='1' AND `status` = 1 ORDER BY user_id DESC");

    // Fetch members
    $members = mysqli_query($connect, "SELECT * FROM users WHERE role IN ('2', '3') AND `status` = 1 ORDER BY user_id DESC");

    ?>

    <?php if ($blocked_message): ?>
        <div class="success-message"><?= htmlspecialchars($blocked_message) ?></div>
    <?php endif; ?>

    <main class="panelWrapper">
        <div class="miniNav">
            <div class="panelSvg">
                <!-- left edge -->
                <svg shape-rendering="geometricPrecision" class="panelEdge" preserveAspectRatio="none"
                    viewBox="0 0 50 100" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M50 0 C40 0 30 20 10 50 C30 80 40 100 50 100 Z" fill="var(--color-primary-darker)"
                        stroke="var(--color-primary-darker)" stroke-width="2" stroke-linejoin="round"
                        stroke-linecap="round" />
                </svg>

                <!-- center -->
                <svg shape-rendering="geometricPrecision" class="panelBody" viewBox="0 0 300 100"
                    preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <defs>
                        <linearGradient id="fillCenter" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" stop-color="var(--color-primary-darker)" />
                            <stop offset="50%" stop-color="var(--color-primary)" />
                            <stop offset="100%" stop-color="var(--color-primary-darker)" />
                        </linearGradient>
                    </defs>
                    <rect x="0" y="0" width="300" height="100" fill="url(#fillCenter)"
                        stroke="var(--color-primary-darker)" stroke-width="2" />
                </svg>

                <!-- right edge -->
                <svg shape-rendering="geometricPrecision" class="panelEdge" preserveAspectRatio="none"
                    viewBox="0 0 50 100" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M0 0 C10 0 20 20 40 50 C20 80 10 100 0 100 Z" fill="var(--color-primary-darker)"
                        stroke="var(--color-primary-darker)" stroke-width="2" stroke-linejoin="round"
                        stroke-linecap="round" />
                </svg>
            </div>

            <a data-page="participants" class="participant">participants</a>
            <a data-page="members" class="member">members</a>
        </div>

        <!-- Participants Table -->
        <div class="headTableScroll" id="participantsSchedule">
            <table class="headTable">
                <thead class="tableHead">
                    <tr class="tableRow">
                        <th class="tableHeader">Full Name</th>
                        <th class="tableHeader">Email</th>
                        <th class="tableHeader">Phone</th>
                        <th class="tableHeader">Status</th>
                        <th class="tableHeader">Action</th>
                    </tr>
                </thead>
                <tbody class="tableBody">
                    <?php while ($row = mysqli_fetch_assoc($participants)) { ?>
                        <tr class="tableRow">
                            <td class="tableData"><?= htmlspecialchars($row['user_name']) ?></td>
                            <td class="tableData"><?= htmlspecialchars($row['email']) ?></td>
                            <td class="tableData"><?= htmlspecialchars($row['phone']) ?></td>
                            <td class="tableData"><?= ($row['status'] == 0) ? 'User Blocked' : 'Active'; ?></td>
                            <td class="tableData">
                                <?php if ($row['status'] == 1): ?>
                                    <form method="post" style="display:inline;"
                                        onsubmit="return confirm('Are you sure you want to block this user?');">
                                        <input type="hidden" name="block_user_id" value="<?= $row['user_id'] ?>">
                                        <input type="hidden" name="section" value="participants">
                                        <button type="submit" class="btn block">Block</button>
                                    </form>
                                <?php else: ?>
                                    <span class="blocked-text">Blocked</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Members Table -->
        <div class="headTableScroll" id="membersSchedule" style="display: none;">
            <table class="headTable">
                <thead class="tableHead">
                    <tr class="tableRow">
                        <th class="tableHeader">Full Name</th>
                        <th class="tableHeader">Email</th>
                        <th class="tableHeader">Phone</th>
                        <th class="tableHeader">Status</th>
                        <th class="tableHeader">Action</th>
                    </tr>
                </thead>
                <tbody class="tableBody">
                    <?php while ($row = mysqli_fetch_assoc($members)) { ?>
                        <tr class="tableRow">
                            <td class="tableData"><?= htmlspecialchars($row['user_name']) ?></td>
                            <td class="tableData"><?= htmlspecialchars($row['email']) ?></td>
                            <td class="tableData"><?= htmlspecialchars($row['phone']) ?></td>
                            <td class="tableData"><?= ($row['status'] == 0) ? 'User Blocked' : 'Active'; ?></td>
                            <td class="tableData">
                                <?php if ($row['status'] == 1): ?>
                                    <form method="post" style="display:inline;"
                                        onsubmit="return confirm('Are you sure you want to block this user?');">
                                        <input type="hidden" name="delete" value="<?= $row['user_id'] ?>">
                                        <input type="hidden" name="section" value="members">
                                        <button type="submit" class="btn block">Block</button>
                                    </form>
                                <?php else: ?>
                                    <span class="blocked-text">Blocked</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>

    <script src="./assets/js/headPanel.js"></script>
</body>

</html>