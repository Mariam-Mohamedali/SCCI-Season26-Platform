# SCCI Season 26 Platform 🚀

[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/Guide/HTML/HTML5)
[![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/CSS)
[![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)](https://developer.mozilla.org/en-US/docs/Web/JavaScript)

**SCCI (Student's Conference for Communication and Information)** is the university's premier student community, bridging the gap between academic technical life and the practical market. This platform serves as the digital hub for **Season 26**, managing workshops, participants, crew members, and digital interactions.

## 🌟 Key Features

### 🎓 For Participants
-   **Workshop Panels**: Access assigned workshop materials, tasks, and quizzes.
-   **Attendance Tracking**: View personal attendance records for sessions.
-   **Task Submission**: Upload tasks directly through the platform.
-   **Feedback System**: Receive and view feedback on submitted tasks from instructors.

### 🛠️ For Crew & Admins
-   **Member Management**: Manage participant lists, attendance, and grading.
-   **Content Management**: Upload session materials (PDFs, docs) and tasks.
-   **Review System**: Grade tasks and provide detailed feedback to participants.
-   **IT & Admin Panels**: specialized dashboards for technical and administrative control.

### 🎨 General
-   **Responsive Design**: Fully optimized for desktop and mobile devices.
-   **Interactive Gallery**: Showcase of events and session highlights.
-   **Sponsorship & Crew Pages**: Dedicated sections for partners and team members.

## 🚀 Tech Stack

-   **Backend**: PHP (Vanilla)
-   **Database**: MySQL
-   **Frontend**: HTML5, CSS3 (Custom Design System), JavaScript (Vanilla)
-   **Libraries**: FontAwesome 6, AOS (Animate On Scroll)

## 📂 Project Structure

```bash
SCCI-Season26-Platform/
├── assets/                 # CSS, JS, Images, Fonts
├── auth/                   # Login & Authentication scripts
├── database/               # SQL scripts & DB config
├── docs/                   # Documentation files
├── includes/               # Reusable PHP components (Nav, Footer, DB Config)
├── logs/                   # System logs
├── uploads/                # User uploaded files (Tasks, Materials)
├── about.php               # About Us page
├── contactPanel.php        # Contact form handling
├── crew.php                # High Board/Heads listing
├── crewDetails.php         # Detailed view of crew members
├── gallary.php             # Photo gallery
├── headPanel.php           # Heads Dashboard
├── home.php                # Landing Page
├── index.php               # Entry point
├── itPanel.php             # IT Control Panel
├── memberWorkshopPanel.php # Dashboard for members/instructors
├── participantWorkshopPanel.php # Dashboard for participants
├── profile.php             # User profile settings
├── sub_crew.php            # Committee members listing
├── ViewProfile.php         # Public profile view
├── workshops.php           # Workshops listing
├── workshopsDetails.php    # Workshop details
└── README.md               # Project Documentation
```

## 🛠️ Installation & Setup

1.  **Clone the Repository**
    ```bash
    git clone https://github.com/mahmoud530/SCCI-Season26-Platform.git
    ```

2.  **Setup Environment**
    -   Ensure you have XAMPP/WAMP installed.
    -   Move the project folder to `htdocs` (XAMPP) or `www` (WAMP).

3.  **Database Configuration**
    -   Create a new database named `scci` (or match `includes/config.php`).
    -   Import the SQL file located in `database/` into your MySQL server.
    -   Update `includes/config.php` with your DB credentials if necessary.

4.  **Run the Project**
    -   Open your browser and navigate to `http://localhost/SCCI-Season26-Platform/home.php`.

## 🤝 Contribution

Contributions are welcome! If you're part of the **IT Crew**, please follow these steps:
1.  Pull the latest changes from `main` before starting.
2.  Create a new branch for your feature/fix.
3.  Commit your changes with clear messages.
4.  Push to the repo and request a review if needed.

## � IT Team (SCCI'26)

Huge appreciation for the entire team — your collaboration made this project possible:

| Name | Role | Link |
| :--- | :--- | :--- |
| **Mahmoud Allam** | IT Head | [LinkedIn](https://www.linkedin.com/in/mahmoud-alllam) |
| **Mahmoud Awad** | Frontend + UI/UX | [LinkedIn](https://www.linkedin.com/in/mahmoudawad11) |
| **Mariam Mohamed** | Frontend + UI/UX | [LinkedIn](https://www.linkedin.com/in/mariam-mohamed127) |
| **Yasmin Mohamed** | Frontend + UI/UX | [LinkedIn](https://www.linkedin.com/in/yasmin-mohamed-react) |
| **Jana Haitham** | Frontend + UI/UX | [LinkedIn](https://www.linkedin.com/in/jana-haitham) |
| **Nada Ashraf** | Frontend + UI/UX | [LinkedIn](https://www.linkedin.com/in/nada-ashraf-n8) |
| **Omar Raslan** | Frontend + UI/UX | [LinkedIn](https://www.linkedin.com/in/omar--raslan) |
| **Abdelrahman Rassmy** | Frontend + UI/UX | [LinkedIn](https://www.linkedin.com/in/abdelrahman-rassmy-057153346) |
| **Hazem Mohamed** | Backend + UI/UX | [LinkedIn](https://www.linkedin.com/in/hazem-mohamed-3b994a251) |
| **Mohamed Radwan** | Backend | [LinkedIn](http://linkedin.com/in/mohamed-radwan-876602242/) |
| **Ahmed Hany** | Frontend + UI/UX | |
| **Ahmed Gamal** | Backend | |

## �📞 Contact

**SCCI** - Seek The Peak
📍 Dokki, Cairo, Egypt

---
*Built with ❤️ by the SCCI `26 IT Committee*
