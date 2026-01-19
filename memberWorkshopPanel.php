<?php


include('./includes/nav.php');
?>


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

  <!-- Icons -->
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

    <!-- Add Task Section -->
    <section class="taskContainer">
        <h2 class="sectionTitle">Add Tasks</h2>
        <form id="validForm" action="" method="post">
            <div class="materialForm">  
                <div class="sideInputs">
                    <!-- add task name -->
                    <div class="groupInputs">
                        <label class="formLabel" for="taskName">Task Name:</label>
                        <input class="textInput"  type="text" name="taskName" id="taskName">
                        <p  id="taskNameMessage"></p>
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
                    <textarea class="textInput" name="description" id="descriptionInput"  rows="5"></textarea> 
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
            <div>
                <button id="submitBtn" class="btn btn-primary btn-sm" type="submit">Add Task</button>
            </div>
        </form>
    </section>
    <!-- View Task Section -->
    <section id="materialList">
      <h3 class="materialTitle">Task</h3>
      <div class="materialContent">

        <!-- material type -->
        <aside class="materialType">
          <button id="materialTypeButton">
            Task Details
          </button>
        </aside>

        <!-- materials items List -->
        <div class="materialItemsList">
          <article id="materialItem">

            <div class="materialInfo">
              <p class="viewTasks" >
                    Task Name: <span id="viewTaskName"></span>
              </p>
              <p class="viewTasks">
                    Task Deadline: <span id="viewTaskDesctiption"></span>
              </p>
              <p class="viewTasks" >
                    Task Desctiption: <span id="viewTaskDeadline"></span>
              </p>
              <p id="viewTaskFile" class="materialFileName">
                    Task File: <span id="viewTaskFile"></span>
              </p>
            </div>
            <div class="materialActions">
              <button id="deleteTask" class="deleteMaterialButton">Delete</button>
            </div>
          </article>
        </div>
      </div>
    </section>

    <!-- adding materials name -->
    <section class="addMaterial">
      <h2 class="sectionTitle">Add Materials</h2>
      <div class="materialForm">
        <div class="formGroup">
          <label class="formLabel">Material Name</label>
          <input class="textInput" type="text" />
        </div>
        <!-- Session Type Select -->
        <div class="formGroup">
          <label class="formLabel">Session Type</label>
          <select class="selectInput">
            <option>Technical</option>
            <option>Soft Skills</option>
          </select>
        </div>
      </div>
    </section>
    <!--end of add materials form section-->


    <!--file upload section-->
    <section class="fileUpload">

      <div class="uploadContainer">
        <div class="uploadIcon"></div>

        <p class="uploadText">
          Drag and drop or click to browse
        </p>

        <button class="btn btn-secondary btn-sm">Upload File</button>

      </div>
    </section>
    <!--end of file upload section-->


    <!--materials list section-->
    <section class="materialList">
      <h3 class="materialTitle">Materials</h3>
      <div class="materialContent">

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
          <article class="materialItem">

            <div class="materialInfo">
              <span class="materialFileName">
                Session 1: Introduction to HTML
              </span>
            </div>
            <div class="materialActions">
              <button class="editMaterialButton">Edit</button>
              <button class="deleteMaterialButton">Delete</button>
            </div>
          </article>

          <article class="materialItem" style="display: none;">
            <div class="materialInfo">
              <span class="materialFileName">
                Session 1: Soft Skills & Communication
              </span>
            </div>
            <div class="materialActions">
              <button class="editMaterialButton">Edit</button>
              <button class="deleteMaterialButton">Delete</button>
            </div>
          </article>
        </div>
      </div>
    </section>
    <!--end materials list section-->

  </main>
  <!-- end add materials section-->



  <script src="assets/js/memberWorkshopPanel.js" defer></script>
</body>

</html>