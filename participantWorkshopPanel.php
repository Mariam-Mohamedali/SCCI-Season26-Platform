<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <!-- Irish Grover font -->
    <link href="https://fonts.googleapis.com/css2?family=Irish+Grover&display=swap" rel="stylesheet" />

    <!-- site icon -->
    <link rel="icon" type="image/png" href="./assets/icons/logoSCCI.png" />

    <!-- css other link -->
    <link rel="stylesheet" href="./assets/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/root.css">

    <!-- css page link -->
    <link rel="stylesheet" href="./assets/css/participantWorkshopPanel.css">

    <title>SCCI - Workshop Panel</title>
</head>

<body>
    <?php include './includes/nav.php'; ?>

    <!-- Main Workshop Panel Section -->
    <section class="workshopPanelSection">
        <div class="container">
            
            <!-- Week Navigation Tabs -->
            <div class="workshopNav">
                <button class="weekTab active" data-week="1">Week 1</button>
                <button class="weekTab" data-week="2">Week 2</button>
                <button class="weekTab" data-week="3">Week 3</button>
                <button class="weekTab" data-week="4">Week 4</button>
                <button class="weekTab" data-week="5">Week 5</button>
                <button class="weekTab" data-week="6">Week 6</button>
                <button class="weekTab" data-week="7">Week 7</button>
                <button class="weekTab" data-week="8">Week 8</button>
            </div>

            <!-- Workshop Card -->
            <div class="workshopCard">
                <!-- Card Header -->
                <div class="cardHeader">
                    <h2>WEEKLY TASK</h2>
                </div>

                <!-- Card Body -->
                <div class="cardBody">
                    <!-- Task Name Row -->
                    <div class="taskRow">
                        <label class="taskLabel">Task Name:</label>
                        <div class="taskValue">build your first website</div>
                    </div>

                    <!-- Deadline Row -->
                    <div class="taskRow">
                        <label class="taskLabel">Deadline</label>
                        <div class="taskValue">12/12/2025</div>
                    </div>

                    <!-- Session Row -->
                    <div class="taskRow">
                        <label class="taskLabel">Session</label>
                        <div class="taskValue">1</div>
                    </div>

                    <!-- Task Bio Box -->
                    <div class="taskBio">
                        <label class="taskLabel">Task bio:</label>
                        <div class="taskBioContent">
                            Your required to use semantic elements and make the page responsive with clean folder structure
                        </div>
                    </div>

                    <!-- Task Resource Row -->
                    <div class="taskResource">
                        <label class="taskLabel">Task Resource:</label>
                        <div class="resourceInfo">
                            <i class="fas fa-file-alt"></i>
                            <span>task.HTML</span>
                            <a href="#" class="downloadBtn">
                                <i class="fas fa-download"></i>
                                Download
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card Footer -->
                <div class="cardFooter">
                    <a href="#" class="btnSubmit">Go to Submit</a>
                </div>
            </div>

        </div>
    </section>

    <?php include './includes/footer.php'; ?>

    <script src="./assets/js/all.min.js" defer></script>
    <script src="./assets/js/participantWorkshopPanel.js" defer></script>
</body>

</html>