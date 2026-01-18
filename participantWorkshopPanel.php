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

    <!-- Page Title -->
    <title>SCCI - Workshop Panel</title>
</head>

<body>
    <?php include './includes/nav.php'; ?>
<!-- panel ----------------------------------------------------------------- -->

    <div class="navbar-spacer"></div>
    
    <!-- Floating Background Decorations -->
    <div class="floatingDecorations">
        <i class="fas fa-star decoration-icon" style="top: 10%; left: 5%; animation-delay: 0s;"></i>
        <i class="fas fa-sparkles decoration-icon" style="top: 20%; right: 8%; animation-delay: 2s;"></i>
        <i class="fas fa-code decoration-icon" style="top: 35%; left: 10%; animation-delay: 4s;"></i>
        <i class="fas fa-star decoration-icon" style="top: 50%; right: 15%; animation-delay: 1s;"></i>
        <i class="fas fa-gem decoration-icon" style="top: 65%; left: 7%; animation-delay: 3s;"></i>
        <i class="fas fa-rocket decoration-icon" style="top: 75%; right: 5%; animation-delay: 5s;"></i>
        <i class="fas fa-heart decoration-icon" style="top: 85%; left: 12%; animation-delay: 2.5s;"></i>
        <i class="fas fa-laptop-code decoration-icon" style="top: 15%; right: 20%; animation-delay: 1.5s;"></i>
        <i class="fas fa-lightbulb decoration-icon" style="top: 45%; left: 3%; animation-delay: 3.5s;"></i>
        <i class="fas fa-certificate decoration-icon" style="top: 60%; right: 10%; animation-delay: 4.5s;"></i>
    </div>
     
        <div class="miniNav">
            <div class="panelSvg">
                <!-- left edge -->
                <svg
                    shape-rendering="geometricPrecision"
                    class="panelEdge"
                    preserveAspectRatio="none"
                    viewBox="0 0 50 100"
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true">
                    <path
                        d="M50 0
                        C40 0 30 20 10 50
                        C30 80 40 100 50 100
                        Z"
                        fill="var(--color-primary-darker)"
                        stroke="var(--color-primary-darker)"
                        stroke-width="2"
                        stroke-linejoin="round"
                        stroke-linecap="round" />
                </svg>

                <!-- center -->
                <svg
                    shape-rendering="geometricPrecision"
                    class="panelBody"
                    viewBox="0 0 300 100"
                    preserveAspectRatio="none"
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true">
                    <defs>
                        <linearGradient id="fillCenter" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" stop-color="var(--color-primary-darker)" />
                            <stop offset="50%" stop-color="var(--color-primary)" />
                            <stop offset="100%" stop-color="var(--color-primary-darker)" />
                        </linearGradient>
                    </defs>

                    <rect
                        x="0"
                        y="0"
                        width="300"
                        height="100"
                        fill="url(#fillCenter)"
                        stroke="var(--color-primary-darker)"
                        stroke-width="2" />
                </svg>

                <!-- right edge -->
                <svg
                    shape-rendering="geometricPrecision"
                    class="panelEdge"
                    preserveAspectRatio="none"
                    viewBox="0 0 50 100"
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true">
                    <path
                        d="M0 0
                        C10 0 20 20 40 50
                        C20 80 10 100 0 100
                        Z"
                        fill="var(--color-primary-darker)"
                        stroke="var(--color-primary-darker)"
                        stroke-width="2"
                        stroke-linejoin="round"
                        stroke-linecap="round" />
                </svg>
            </div>

            <!-- Name the "data-page" in the mini nav the same as its section -->
            <a data-page="evaluate" class="activePanelLine">view task</a>
            <a data-page="review" class="">review Task</a>
            <a data-page="addTask" class="">materials</a>
            <a data-page="addMaterial" class="">activity time </a>
        </div>
        
    <!-- Main Workshop Panel Section -->
    <section class="workshopPanelSection">
        <div class="container">

            <!-- Panel Section: View Task (Evaluate) -->
            <div id="evaluate" class="panelSection panelSectionActive">
                <!-- Week Navigation Tabs -->
                <!-- Week Navigation Tabs: Allows switching between workshop weeks -->
                <div class="workshopNav">
                    <button class="weekTab active" data-week="1">session 1</button>
                    <button class="weekTab" data-week="2">session 2</button>
                    <button class="weekTab" data-week="3">session 3</button>
                    <button class="weekTab" data-week="4">session 4</button>
                    <button class="weekTab" data-week="5">session 5</button>
                    <button class="weekTab" data-week="6">session6</button>
                    <button class="weekTab" data-week="7">session 7</button>
                </div>

                <!-- Workshop Card -->
                <article class="workshopCard">
                    <!-- Card Header -->
                    <header class="cardHeader">
                        <h2>WEEKLY TASK</h2>
                    </header>

                    <!-- Card Body -->
                    <div class="cardBody">
                        <!-- Task Name Row -->
                        <div class="taskRow">
                            <label class="taskLabel">Task Name:</label>
                            <div class="taskValue">build your first website</div>
                        </div>

                        <!-- Deadline Row -->
                        <div class="taskRow">
                            <label class="taskLabel">Deadline:</label>
                            <div class="taskValue">12/12/2025</div>
                        </div>

                        <!-- Session Row -->
                        <div class="taskRow">
                            <label class="taskLabel">Session:</label>
                            <div class="taskValue">1</div>
                        </div>

                        <!-- Task Bio Box -->
                        <div class="taskBio">
                            <label class="taskLabel">Task bio:</label>
                            <div class="taskBioContent">
                                Your required to use semantic elements and make the page responsive with clean folder
                                structure
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
                </article>

                <!-- Submit Task Form Section -->
                <form class="fileUpload" id="validForm" action="" method="post" enctype="multipart/form-data">
                    <!-- Upload Header -->
                    <div class="uploadHeader">
                        <h3 class="uploadSectionTitle">Submit Task</h3>
                    </div>
                    <!-- Upload Container -->
                    <div class="uploadContainer" id="taskUploadContainer">
                        <label class="formLabel" for="taskFile">
                            <div class="uploadIcon">
                                <i class="fas fa-arrow-down"></i>
                            </div>
                            <h4 class="uploadTitle">Upload File</h4>
                            <p class="uploadText" id="fileUploadState">
                                Drag and drop or click to browse
                            </p>
                        </label>

                        <p id="fileUploadedName"></p>
                        <!-- Hidden File Input -->
                        <input type="file" name="taskFile" id="taskFile">

                        <p id="fileMessage"></p>
                    </div>

                    <!-- Submit Button -->
                    <div style="text-align: center; padding: var(--space-5) var(--space-8) var(--space-7);">
                        <button type="submit" class="btn btn-primary" style="min-width: 200px;">
                            <i class="fas fa-upload"></i>
                            Submit Task
                        </button>
                    </div>
                </form>
            </div>

            <!-- Panel Section: Review Task -->
            <div id="review" class="panelSection">
                <article class="workshopCard">
                    <header class="cardHeader">
                        <h2>TASK REVIEW</h2>
                    </header>
                    <div class="cardBody">
                        <!-- Review Table -->
                        <div class="reviewTableContainer">
                            <table class="reviewTable">
                                <thead>
                                    <tr>
                                        <th>Sessions</th>
                                        <th>Task Link</th>
                                        <th>Status</th>
                                        <th><i class="fas fa-check-circle"></i> Task rating</th>
                                        <th><i class="fas fa-comment-dots"></i> Feedback</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Session 1 - Submitted -->
                                    <tr>
                                        <td class="sessionName">Session 1</td>
                                        <td class="taskLink">
                                            <a href="#" class="taskLinkBtn">
                                                <i class="fas fa-link"></i>
                                                Task-link
                                            </a>
                                        </td>
                                        <td>
                                            <span class="statusBadge statusSubmitted">
                                                <i class="fas fa-check"></i>
                                                submitted
                                            </span>
                                        </td>
                                        <td class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                        </td>
                                        <td>
                                            <button class="feedbackBtn">view feedback</button>
                                        </td>
                                    </tr>

                                    <!-- Session 2 - Submitted -->
                                    <tr>
                                        <td class="sessionName">Session 2</td>
                                        <td class="taskLink">
                                            <a href="#" class="taskLinkBtn">
                                                <i class="fas fa-link"></i>
                                                Task-link
                                            </a>
                                        </td>
                                        <td>
                                            <span class="statusBadge statusSubmitted">
                                                <i class="fas fa-check"></i>
                                                submitted
                                            </span>
                                        </td>
                                        <td class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                        </td>
                                        <td>
                                            <button class="feedbackBtn">view feedback</button>
                                        </td>
                                    </tr>

                                    <!-- Session 3 - Not Submitted -->
                                    <tr>
                                        <td class="sessionName">Session 3</td>
                                        <td class="taskLink">—</td>
                                        <td>
                                            <span class="statusBadge statusNotSubmitted">
                                                <i class="fas fa-times"></i>
                                                Not submitted
                                            </span>
                                        </td>
                                        <td class="rating">—</td>
                                        <td>—</td>
                                    </tr>

                                    <!-- Session 4 - Pending (Highlighted Row) -->
                                    <tr class="highlightedRow">
                                        <td class="sessionName" style="color: var(--color-success);">Session 4</td>
                                        <td class="taskLink">
                                            <a href="#" class="taskLinkBtn">
                                                <i class="fas fa-link"></i>
                                                Task-link
                                            </a>
                                        </td>
                                        <td>
                                            <span class="statusBadge statusPending">
                                                <i class="fas fa-hourglass-half"></i>
                                                Pending
                                            </span>
                                        </td>
                                        <td class="rating">—</td>
                                        <td>—</td>
                                    </tr>

                                    <!-- Session 5 - Empty -->
                                    <tr>
                                        <td class="sessionName">Session 5</td>
                                        <td class="taskLink">—</td>
                                        <td>—</td>
                                        <td class="rating">—</td>
                                        <td>—</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Panel Section: Materials -->
            <div id="addTask" class="panelSection">
                <article class="workshopCard">
                    <header class="cardHeader">
                        <h2>WORKSHOP MATERIALS</h2>
                    </header>
                    <div class="cardBody">
                        <div class="materialsContainer">
                            <!-- Category Tabs -->
                            <div class="materialCategories">
                                <button class="materialCategoryBtn active" data-category="technical">
                                    <i class="fas fa-play"></i>
                                    Technical Material
                                </button>
                                <button class="materialCategoryBtn" data-category="softskills">
                                    <i class="fas fa-play"></i>
                                    Soft-skills Material
                                </button>
                            </div>

                            <!-- Materials List -->
                            <div class="materialsListContainer">
                                <!-- Technical Materials -->
                                <div id="technical" class="materialsList activeMaterialsList">
                                    <div class="materialItem">
                                        <i class="fas fa-file-alt materialIcon"></i>
                                        <span class="materialName">Session_1: Introduction to HTML</span>
                                        <a href="#" class="materialDownloadBtn">
                                            <i class="fas fa-download"></i>
                                            Download
                                        </a>
                                    </div>
                                    <div class="materialItem">
                                        <i class="fas fa-file-alt materialIcon"></i>
                                        <span class="materialName">Session_2: HTML Elements & Structure</span>
                                        <a href="#" class="materialDownloadBtn">
                                            <i class="fas fa-download"></i>
                                            Download
                                        </a>
                                    </div>
                                    <div class="materialItem">
                                        <i class="fas fa-file-alt materialIcon"></i>
                                        <span class="materialName">Session_3: CSS Fundamentals</span>
                                        <a href="#" class="materialDownloadBtn">
                                            <i class="fas fa-download"></i>
                                            Download
                                        </a>
                                    </div>
                                    <div class="materialItem">
                                        <i class="fas fa-file-alt materialIcon"></i>
                                        <span class="materialName">Session_4: Responsive Design</span>
                                        <a href="#" class="materialDownloadBtn">
                                            <i class="fas fa-download"></i>
                                            Download
                                        </a>
                                    </div>
                                </div>

                                <!-- Soft-skills Materials -->
                                <div id="softskills" class="materialsList">
                                    <div class="materialItem">
                                        <i class="fas fa-file-alt materialIcon"></i>
                                        <span class="materialName">Communication Skills for Developers</span>
                                        <a href="#" class="materialDownloadBtn">
                                            <i class="fas fa-download"></i>
                                            Download
                                        </a>
                                    </div>
                                    <div class="materialItem">
                                        <i class="fas fa-file-alt materialIcon"></i>
                                        <span class="materialName">Time Management & Productivity</span>
                                        <a href="#" class="materialDownloadBtn">
                                            <i class="fas fa-download"></i>
                                            Download
                                        </a>
                                    </div>
                                    <div class="materialItem">
                                        <i class="fas fa-file-alt materialIcon"></i>
                                        <span class="materialName">Teamwork & Collaboration</span>
                                        <a href="#" class="materialDownloadBtn">
                                            <i class="fas fa-download"></i>
                                            Download
                                        </a>
                                    </div>
                                    <div class="materialItem">
                                        <i class="fas fa-file-alt materialIcon"></i>
                                        <span class="materialName">Problem Solving Techniques</span>
                                        <a href="#" class="materialDownloadBtn">
                                            <i class="fas fa-download"></i>
                                            Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Panel Section: Activity Time (Game Intro) -->
            <div id="addMaterial" class="panelSection">
                <article class="workshopCard activityCard">
                    <header class="cardHeader activityHeader">
                        <h2><i class="fas fa-gamepad"></i> ACTIVITY TIME</h2>
                    </header>
                    <div class="cardBody activityBody">
                        <!-- Game Challenge Banner -->
                        <div class="gameBanner">
                            <!-- Animated Game Avatar -->
                            <div class="gameAvatar">
                                <div class="avatarCircle">
                                    <i class="fas fa-robot avatarIcon"></i>
                                </div>
                                <div class="avatarGlow"></div>
                            </div>

                            <div class="bannerIcons">
                                <i class="fas fa-trophy bannerIcon"></i>
                                <i class="fas fa-star bannerIcon"></i>
                                <i class="fas fa-fire bannerIcon"></i>
                            </div>
                            <h3 class="gameTitle">🎮 Weekly Challenge Game!</h3>
                            <p class="gameSubtitle">Test your knowledge and compete for the highest score!</p>
                        </div>

                        <!-- Game Info Cards -->
                        <!-- <div class="gameInfoGrid">
                            <div class="gameInfoCard rewardCard">
                                <div class="infoIcon">
                                    <i class="fas fa-gem"></i>
                                </div>
                                <div class="infoContent">
                                    <span class="infoLabel">Reward Points</span>
                                    <span class="infoValue">100 Points</span>
                                </div>
                            </div>
                        </div> -->

                        <!-- Motivational Message -->
                        <div class="motivationalBox">
                            <i class="fas fa-bullseye"></i>
                            <p><strong>Ready to prove yourself?</strong> Challenge your skills and climb the leaderboard! 🚀</p>
                        </div>

                        <!-- Play Button -->
                        <div class="playButtonContainer">
                            <a href="https://awadcoding.github.io/SCCI-Quiz/" class="playGameBtn">
                                <span class="btnGlow"></span>
                                <i class="fas fa-play"></i>
                                <span class="btnText">START GAME NOW</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                            <p class="playHint">Click to enter the game arena!</p>
                        </div>

                        <!-- Stats Preview -->
                        <div class="statsPreview">
                            <div class="statItem">
                                <i class="fas fa-users"></i>
                                <span>300 Players</span>
                            </div>
                            <div class="statItem">
                                <i class="fas fa-crown"></i>
                                <span>Top Score: 98/100</span>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

        </div>
    </section>

    <!-- Footer Section -->
    <?php include './includes/footer.php'; ?>

    <!-- Feedback Modal Popup -->
    <div id="feedbackModal" class="modalOverlay">
        <div class="modalContainer">
            <div class="modalHeader">
                <h3><i class="fas fa-comments"></i> Instructor Feedback</h3>
                <button class="modalCloseBtn" onclick="closeFeedbackModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modalBody">
                <!-- Session Info -->
                <div class="feedbackSessionInfo">
                    <span class="feedbackSessionLabel">Session:</span>
                    <span id="feedbackSessionName" class="feedbackSessionValue">Session 1</span>
                </div>
                
                <!-- Rating -->
                <div class="feedbackRating">
                    <span class="feedbackLabel">Rating:</span>
                    <div class="feedbackStars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                </div>

                <!-- Feedback Content -->
                <div class="feedbackContent">
                    <p class="feedbackLabel"><i class="fas fa-comment-alt"></i> Feedback Message:</p>
                    <div id="feedbackText" class="feedbackTextArea">
                        <p>Great work on your HTML structure! Your code is clean and well-organized. However, I noticed a few areas for improvement:</p>
                        <ul>
                            <li>Use semantic HTML elements more consistently (e.g., &lt;header&gt;, &lt;nav&gt;, &lt;main&gt;)</li>
                            <li>Add more descriptive class names for better maintainability</li>
                            <li>Consider adding comments to complex sections</li>
                        </ul>
                        <p>Keep up the excellent effort! Your progress is impressive. 🌟</p>
                    </div>
                </div>

                <!-- Instructor Info -->
                <div class="feedbackInstructor">
                    <i class="fas fa-user-tie"></i>
                    <span>Reviewed by: <strong>Instructor Ahmed</strong></span>
                </div>
            </div>
            <div class="modalFooter">
                <button class="modalOkBtn" onclick="closeFeedbackModal()">Got it!</button>
            </div>
        </div>
    </div>

    <!-- Page Scripts -->
    <script src="./assets/js/all.min.js" defer></script>
    <script src="./assets/js/participantWorkshopPanel.js" defer></script>
</body>

</html>