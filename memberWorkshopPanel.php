<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Irish+Grover&display=swap"
        rel="stylesheet">

    <!-- SCCI Icon -->
    <link rel="icon" href="assets/icons/logoSCCI.png" type="image/x-icon">

    <!-- Font Awesome (Standard CDN) -->
    <link rel="stylesheet" href="assets/css/all.min.css" />

    <!-- Styles -->
    <link rel="stylesheet" href="assets/css/root.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/navbar.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/memberWorkshopPanel.css?v=<?php echo time(); ?>">
    <!-- Custom Page Styles -->

    <title>SCCI-Panel</title>
</head>

<body>
    <!-- add materials section -->
    <main class="materialPage">

        <!-- panel ----------------------------------------------------------------- -->
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
            <a data-page="evaluate" class="activePanelLine">evaluate</a>
            <a data-page="review" class="">review</a>
            <a data-page="addTask" class="">add task</a>
            <a data-page="addMaterial" class="">add materials</a>
            <a data-page="quiz" class="">quiz</a>
        </div>

        <!-- EVALUATE --------------------------------------------------------------------------- -->
        <section
            id="evaluate"
            class="panelSection panelSectionActive evaluateContainer">
            <h4>dashboard</h4>

            <div class="panelWhiteBox">
                <!-- Sessions -->
                <div class="sessionsSelectorFrame">
                    <div class="sessionsSelector">
                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 1</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 2</p>
                        </div>

                        <!-- Active Session -->
                        <div class="sessionBtn sessionActive">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="#1f184e"
                                        stroke="#1f184e"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionBlue"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="#1f184e"
                                        stroke="#1f184e"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 3</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 4</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 5</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 6</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 7</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 8</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 9</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 10</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 11</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 12</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 13</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 14</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 15</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 16</p>
                        </div>
                    </div>
                </div>
            
                <!-- Table -->
                <div class="tableScrollFrame">
                    <div class="tableScroll">
                        <table
                            cellpadding="0"
                            cellspacing="0"
                            summary="participants dashboard">
                            <colgroup>
                                <col span="1" style="width: 25%" />
                                <col span="1" style="width: 25%" />
                                <col span="1" style="width: 25%" />
                                <col span="1" style="width: 25%" />
                            </colgroup>

                            <!-- Table head -->
                            <thead>
                                <tr>
                                    <th scope="col"><i class="fa-solid fa-user"></i> Name</th>
                                    <th scope="col"><i class="fa-solid fa-user"></i> attendance</th>
                                    <th scope="col">
                                        <i class="fa-regular fa-circle-check"></i> task
                                    </th>
                                    <th scope="col">
                                        <i class="fa-solid fa-splotch"></i> feedback
                                    </th>
                                </tr>
                            </thead>

                            <!-- Table body -->
                            <tbody>
                                <!-- table row -->
                                <tr>
                                    <td class="tableParticipantName">omar raslan</td>
                                    <td>
                                        <div class="evaluateTaskRow">
                                            <label class="radioOption">
                                                <input type="radio" name="attendance2" value="attended" />
                                                <div class="evaluateAttendanceCircle evaluateCheckTask">
                                                    <i class="fa-solid fa-check"></i>
                                                </div>
                                            </label>

                                            <label class="radioOption">
                                                <input type="radio" name="attendance2" value="absent" />
                                                <div class="evaluateAttendanceCircle evaluateXtask">
                                                    <i class="fa-solid fa-x"></i>
                                                </div>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="" class="taskLink">
                                            <i class="fa-solid fa-link"></i> Task-Link</a>
                                    </td>
                                    <td>
                                        <button
                                            class="btn evaluateFeedback btn-primary"
                                            type="submit">
                                            Add Feedback
                                        </button>
                                    </td>
                                </tr>

                                <!-- table row -->
                                <tr>
                                    <td class="tableParticipantName">omar raslan</td>
                                    <td>
                                        <div class="evaluateTaskRow">
                                            <label class="radioOption">
                                                <input type="radio" name="attendance3" value="attended" />
                                                <div class="evaluateAttendanceCircle evaluateCheckTask">
                                                    <i class="fa-solid fa-check"></i>
                                                </div>
                                            </label>

                                            <label class="radioOption">
                                                <input type="radio" name="attendance3" value="absent" />
                                                <div class="evaluateAttendanceCircle evaluateXtask">
                                                    <i class="fa-solid fa-x"></i>
                                                </div>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="" class="taskLink">
                                            <i class="fa-solid fa-link"></i> Task-Link</a>
                                    </td>
                                    <td>
                                        <button
                                            class="btn evaluateFeedback btn-primary"
                                            type="submit">
                                            Add Feedback
                                        </button>
                                    </td>
                                </tr>

                                <!-- table row -->
                                <tr>
                                    <td class="tableParticipantName">omar raslan</td>
                                    <td>
                                        <div class="evaluateTaskRow">
                                            <label class="radioOption">
                                                <input type="radio" name="attendance4" value="attended" />
                                                <div class="evaluateAttendanceCircle evaluateCheckTask">
                                                    <i class="fa-solid fa-check"></i>
                                                </div>
                                            </label>

                                            <label class="radioOption">
                                                <input type="radio" name="attendance4" value="absent" />
                                                <div class="evaluateAttendanceCircle evaluateXtask">
                                                    <i class="fa-solid fa-x"></i>
                                                </div>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="" class="taskLink">
                                            <i class="fa-solid fa-link"></i> Task-Link</a>
                                    </td>
                                    <td>
                                        <button
                                            class="btn evaluateFeedback btn-primary"
                                            type="submit">
                                            Add Feedback
                                        </button>
                                    </td>
                                </tr>

                                <!-- table row -->
                                <tr>
                                    <td class="tableParticipantName">omar raslan</td>
                                    <td>
                                        <div class="evaluateTaskRow">
                                            <label class="radioOption">
                                                <input type="radio" name="attendance5" value="attended" />
                                                <div class="evaluateAttendanceCircle evaluateCheckTask">
                                                    <i class="fa-solid fa-check"></i>
                                                </div>
                                            </label>

                                            <label class="radioOption">
                                                <input type="radio" name="attendance5" value="absent" />
                                                <div class="evaluateAttendanceCircle evaluateXtask">
                                                    <i class="fa-solid fa-x"></i>
                                                </div>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="" class="taskLink">
                                            <i class="fa-solid fa-link"></i> Task-Link</a>
                                    </td>
                                    <td>
                                        <button
                                            class="btn evaluateFeedback btn-primary"
                                            type="submit">
                                            Add Feedback
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- add feedback -->
            <section class="feedbackSection">
              <div class="feedbackHeader">
                Feedback
              </div>
              <!-- id="feedbackLabel" -->
              <form action="" method= "post" id="feedbackForm">
                <div class="materialForm"> 
                  <label class="formLabel" id="feedbackLabel" for="addFeedback">Add feedback:</label>
                  <textarea class="textInput" name="addFeedback" id="addFeedback" rows="5" ></textarea>
                </div>
                <div class="rateInput"> 
                  <label for="star1">
                    <i class="fa-regular fa-star"></i>
                  </label>
                  <input class="rates" name="rates" type="radio" id="star1" value="star1">
                  <label for="star2">
                    <i class="fa-regular fa-star"></i>
                  </label>
                  <input class="rates" name="rates" type="radio" id="star2" value="star2">
                  <label for="star3">
                    <i class="fa-regular fa-star"></i>
                  </label>
                  <input class="rates" name="rates" type="radio" id="star3" value="star3">
                  <label for="star4">
                    <i class="fa-regular fa-star"></i>
                  </label>
                  <input class="rates" name="rates" type="radio" id="star4" value="star4">
                  <label for="star5">
                    <i class="fa-regular fa-star"></i>
                  </label>
                  <input class="rates" name="rates" type="radio" id="star5" value="star5">
                </div>
                <div class="feedbackSubmit">
                  <input class="btn btn-primary btn-sm" type="submit" value="Submit">
                </div>
              </form>
            </section>

        </section>


        <!-- REVIEW ----------------------------------------------------------------------------- -->
        <section id="review" class="panelSection evaluateContainer">
            <h4>dashboard</h4>

            <div>
                <!-- Sessions -->
                <div class="sessionsSelectorFrame">
                    <div class="sessionsSelector">
                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 1</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 2</p>
                        </div>

                        <!-- Active Session -->
                        <div class="sessionBtn sessionActive">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="#1f184e"
                                        stroke="#1f184e"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionBlue"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="#1f184e"
                                        stroke="#1f184e"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 3</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 4</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 5</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 6</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 7</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 8</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 9</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 10</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 11</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 12</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 13</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 14</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 15</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 16</p>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="tableScrollFrame">
                    <div class="tableScroll">
                        <table
                            cellpadding="0"
                            cellspacing="0"
                            summary="participants dashboard">
                            <colgroup>
                                <col span="1" style="width: 20%" />
                                <col span="1" style="width: 20%" />
                                <col span="1" style="width: 20%" />
                                <col span="1" style="width: 20%" />
                                <col span="1" style="width: 20%" />
                            </colgroup>

                            <!-- Table head -->
                            <thead>
                                <tr>
                                    <th scope="col"><i class="fa-solid fa-user"></i> Name</th>
                                    <th scope="col"><i class="fa-solid fa-user"></i> attendance</th>
                                    <th scope="col">
                                        <i class="fa-solid fa-splotch"></i> task rating
                                    </th>
                                    <th scope="col">
                                        <i class="fa-solid fa-splotch"></i> feedback
                                    </th>
                                    <th scope="col"><i class="fa-solid fa-plus"></i> added by</th>
                                </tr>
                            </thead>

                            <!-- Table body -->
                            <tbody>
                                <!-- table row -->
                                <tr>
                                    <td class="tableParticipantName">omar raslan</td>

                                    <td>
                                        <!-- absent -->
                                        <div class="reviewAbsent">
                                            <div class="reviewAttendBox">
                                                <div class="reviewAttendedLeft"></div>
                                                <div class="reviewAttendedSymbol">X</div>
                                            </div>
                                            <div>absent</div>
                                        </div>
                                    </td>

                                    <td>
                                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i>
                                    </td>

                                    <td>
                                        <button
                                            class="btn evaluateFeedback btn-primary"
                                            type="submit">
                                            view feedback
                                        </button>
                                    </td>

                                    <td>
                                        <!-- added by -->
                                        <p class="reviewAddedBy">omar raslan</p>
                                    </td>
                                </tr>
                                
                                <!-- table row -->
                                <tr>
                                    <td class="tableParticipantName">omar raslan</td>

                                    <td>
                                        <div class="reviewAttended">
                                            <div class="reviewAttendBox">
                                                <div class="reviewAttendedLeft"></div>
                                                <i class="fa-solid fa-check reviewAttendedSymbol"></i>
                                            </div>
                                            <div>attended</div>
                                        </div>
                                    </td>

                                    <td>
                                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i>
                                    </td>

                                    <td>
                                        <button
                                            class="btn evaluateFeedback btn-primary"
                                            type="submit">
                                            view Feedback
                                        </button>
                                    </td>
                                    <td>
                                        <!-- added by -->
                                        <p class="reviewAddedBy">omar raslan</p>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>


        <!-- Add Task Section ------------------------------------- -->
        <section id="addTask" class="taskContainer panelSection evaluateContainer">
            <h4>Add Tasks</h4>
            <div class="panelWhiteBox">
                <!-- Sessions -->
                <div class="sessionsSelectorFrame">
                    <div class="sessionsSelector">
                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 1</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 2</p>
                        </div>

                        <!-- Active Session -->
                        <div class="sessionBtn sessionActive">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="#1f184e"
                                        stroke="#1f184e"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionBlue"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="#1f184e"
                                        stroke="#1f184e"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 3</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 4</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 5</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 6</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 7</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 8</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 9</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 10</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 11</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 12</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 13</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 14</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 15</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 16</p>
                        </div>
                    </div>
                </div>
            </div>
                <!-- add task section -->
            <div>
                <form id="validForm" action="" method="post">
                    <div class="materialForm">
                        <div class="sideInputs">
                            <!-- add task name -->
                            <div class="groupInputs">
                                <label class="formLabel" for="taskName">Task Name:</label>
                                <input class="textInput" type="text" name="taskName" id="taskName">
                                <p id="taskNameMessage"></p>
                            </div>
                            <!-- add task deadline -->
                            <div class="groupInputs">
                                <label class="formLabel" for="dueDate">Deadline:</label>
                                <input class="textInput" type="datetime-local" name="dueDate" id="dueDate">
                                <p id="dueDateMessage"></p>
                            </div>
                        </div>
                        <!-- add task Description -->
                        <div class="groupInputs">
                            <label class="formLabel" for="description" id="descriptionLabel">Task Description:</label>
                            <textarea class="textInput" name="description" id="descriptionInput" rows="5"></textarea>
                            <p id="descriptionMessage"></p>
                        </div>

                    </div>

                    <!-- upload task file -->
                    <div class="fileUpload" id="taskUpload">
                        <div class="uploadContainer" id ="taskUploadContainer">
                            <label class="formLabel" for="taskFile">
                                <div class="uploadIcon"></div>
                            </label>
                            
                            <p class="uploadText" id="fileUploadState">
                            Drag and drop or click to browse
                            </p>
                            <p id="fileUploadedName"></p>
                            <label  class=" btn btn-secondary btn-sm" for="taskFile">Upload File</label>
                            <input  type="file" name="taskFile" id="taskFile">
                            
                            <p id="fileMessage"></p>
                        </div>
                    </div>

                    <button id="submitBtn" class="btn btn-primary btn-sm" type="submit">Add Task</button>
                </form>
            </div>
            
            <!-- <div class="taskSeparator"></div> -->
            
            <!--task list section ----------------------------- -->
            <!-- materials items List -->
            <div class="panelWhiteBox">
                <h4>Tasks</h4>
                <!-- <div class="materialItemsList"> -->

                <div class="articleFiles">
                    <article class="materialItem">

                        <div class="materialInfo">
                            <span class="materialFileName">
                                Session 1: Session Name
                            </span>
                        </div>
                        <div class="materialActions">
                            <button class="deleteMaterialButton">Delete</button>
                        </div>
                    </article>
                </div>

                <!-- </div> -->
            </div>
        </section>
        
        
        <!-- adding materials section ---------------------------------- -->
        <section class="evaluateContainer panelSection" class="addMaterial" id="addMaterial">
            <h4>Add Materials</h4>

            <div class="panelWhiteBox">
                <!-- Sessions -->
                <div class="sessionsSelectorFrame">
                    <div class="sessionsSelector">
                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 1</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 2</p>
                        </div>

                        <!-- Active Session -->
                        <div class="sessionBtn sessionActive">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="#1f184e"
                                        stroke="#1f184e"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionBlue"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="#1f184e"
                                        stroke="#1f184e"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 3</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 4</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 5</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 6</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 7</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 8</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 9</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 10</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 11</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 12</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 13</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 14</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 15</p>
                        </div>

                        <!-- Not Active Session -->
                        <div class="sessionBtn">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M50 0
                    C40 0 30 20 10 50
                    C30 80 40 100 50 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>

                                <!-- center -->

                                <div class="panelBody sessionWhite"></div>
                                <!-- right edge -->
                                <svg
                                    shape-rendering="geometricPrecision"
                                    class="panelEdge sessionEdge"
                                    preserveAspectRatio="none"
                                    viewBox="0 0 50 100"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path
                                        d="M0 0
                    C10 0 20 20 40 50
                    C20 80 10 100 0 100
                    Z"
                                        fill="var(--color-white-gradient)"
                                        stroke="var(--color-white-gradient)"
                                        stroke-width="2"
                                        stroke-linejoin="round"
                                        stroke-linecap="round" />
                                </svg>
                            </div>

                            <p>session 16</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div>
                <form id="validMaterialForm" action="" method="post">
                  <div class="materialForm">
                    <div class="formGroup">
                <!-- adding materials name -->
                      <label class="formLabel" for="materialName">Material Name</label>
                      <input class="textInput" type="text" id="materialName"name="materialName" />
                      <p id="materialNameMessage"></p>
                    </div>
                    <!-- Session Type Select -->
                    <div class="formGroup">
                      <label class="formLabel" for="sessionType">Session Type</label>
                      <select class="selectInput"  id="sessionType" name="sessionType">
                        <option value="">Select Type</option>
                        <option value="Technical">Technical</option>
                        <option value="Soft Skills">Soft Skills</option>
                      </select>
                      <p id="sessionTypeMessage"></p>
                    </div>
                  </div>
            
            <!--file upload section-->
            <div class="fileUpload" id="materialUpload">
              <div class="uploadContainer" id="materialUploadContainer">
                <label class="formLabel" for="materialFile">
                <div class="uploadIcon"></div>
                </label>
                <p class="uploadText"  id="materialFileState">
                  Drag and drop or click to browse
                </p>
                <p id="materialFileUploadedName"></p>
                <label class="btn btn-secondary btn-sm" for="materialFile">Upload File</label>
                <input type="file" name="materialFile" id="materialFile">
                    <p id="materialFileMessage"></p>

                </div>
              </div>

                <!--end of file upload section-->

                <div>
                  <button id="addMaterialBtn" class="btn btn-primary btn-sm" type="submit">Add Material</button>
                </div>

              </form>
            </div>

            <!--materials list section ----------------------------- -->
            <section class="panelWhiteBox">
                <h4>Materials</h4>
    
                <div class="materialCategory">
                    <!-- material type -->
                    <aside class="materialType">
                        <button class="materialTypeButton">
                            Technical Material
                        </button>
                        <button class="materialTypeButton">
                            SoftSkills Material
                        </button>
                    </aside>
    
                    <!-- materials items List -->
                    <div class="materialItemsList">
                        <div class="articleFiles">
                            <article class="materialItemJs materialItem">
    
                                <div class="materialInfo">
                                    <span class="materialFileName">
                                        Session 1: Introduction to HTML
                                    </span>
                                </div>
                                <div class="materialActions">
                                    <button class="deleteMaterialButton">Delete</button>
                                </div>
                            </article>
                        </div>
    
                        <div class="articleFiles">
                            <article class="materialItemJs materialItem" style="display: none;">
                                <div class="materialInfo">
                                    <span class="materialFileName">
                                        Session 1: Soft Skills & Communication
                                    </span>
                                </div>
                                <div class="materialActions">
                                    <button class="deleteMaterialButton">Delete</button>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </section>
        </section>

    </main>
    <!-- end add materials section-->


    <!-- JAVASCRIPT -->

    <script src="assets/js/all.min.js" defer></script>
    <script src="assets/js/memberWorkshopPanel.js" defer></script>

</body>

</html>
