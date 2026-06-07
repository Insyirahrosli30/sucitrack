## Menstrual and Qada Tracker System
## Group Members
**Alya Qistina Nadia binti Idris (231134)**
* Leader
* Setup Laravel project 
* Configure GitHub repository
* Manage backend integration
* Assist route integration
* Create navbar/footer
* Manage website theme/layout
* Handle Blade template layout
* Display prayer times on dashboard
* Display reminder notifications
* Handle API frontend display
* Handle loading/error messages

**Putri Nur Batrisyia binti Azizul (2412444)**
* Design database tables
* Create ERD
* Create Sequence Diagram
* Setup MySQL database
* Create Laravel migrations
* Develop Eloquent Models
* Setup foreign keys and relationships
* Design landing page/homepage
* Design login page
* Design register page
* Create authentication forms
* Style input forms using Tailwind CSS
* Connect forms with backend routes
* Connect Laravel with JAKIM API
* Implement responsive layout for multiple pages
  
**Wan Nur Hanees binti Wan Shukri (2415978)**
* Create CRUD backend functions
* Create period controller
* Setup CRUD routes
* Create validation logic
* Store/retrieve period records
* Design dashboard layout
* Create cycle summary section
* Create history page UI
* Display records dynamically
* Process JSON response
* Extract prayer time data
* Format prayer information

**Wan Nur Insyirah binti Wan Rosli (2410848)**
* Create qada’ prayer logic
* Create hari suci calculation
* Create next cycle prediction logic
* Build calculation functions
* Design calendar tracker
* Display prediction section
* Design prayer reminder section
* Compare period time with prayer time
* Determine qada’ prayer needed
* Test calculation accuracy

## 1. Introduction

SuciTrack is a specialized, Laravel-based web application cater assist Muslim women in tracking their menstrual cycles (Hayd) and periods of purity (Tuhr) in strict accordance with Shariah (Islamic jurisprudence) guidelines.

Navigating the complexities of Islamic rulings regarding prayer (Salah), fasting (Sawm), and other acts of worship during and after menstruation can be challenging. SuciTrack addresses this by replacing manual calculations with an automated, reliable digital solution. By combining the robust Model-View-Controller (MVC) architecture of Laravel with precise jurisprudential logic, the platform empowers users to maintain the five daily prayers and accurately manage their religious obligations.

## 2. Problem Statement & Objectives

### 2.1 Problem Statement
Many contemporary period tracking applications are designed purely from a medical or lifestyle perspective. They lack the specific logical parameters required to determine Islamic purity, such as tracking the exact duration of a valid period, identifying irregular bleeding (Istihadah), or calculating missed prayers that require replacement (Qada'). This leaves users to manually calculate their end period time, often leading to confusion regarding their validation for acts of worship.

### 2.2 Project Objectives
- Provide an interactive website for users to login, view, and manage their current and historical cycle data.
- Eliminate manual calculation errors by automating the determination of purity days, valid menstruation limits, and transitional phases.
- Support users in fulfilling their religious duties by implementing a structured system to track and clear Qada' (missed) prayers.

## 3. System Architecture

### 3.1 Core Features
The application is built around four primary functional pillars:
- Secure user authentication through registration and login systems to ensure user data protection and privacy.
- Menstrual Records Management (CRUD) Create, Read, Update, and Delete capabilities allowing users to log start/end times.
- A visual featuring current cycle status, days of purity, unresolved qada' prayers, zone selection based on systemic calculations.
- Historical trends, predictive modeling for future cycles to inform users.

### 3.2 Technical
Backend Framework: 
- Laravel (PHP)
- JavaScript

Frontend Interface: 
- Blade Templating Engine, 
- Tailwind CSS (augmented with Livewire for real-time reactivity)

Database: 
- MySQL

## 4. Features & Functionalities

### 4.1 User Authentication
The system provides a secure authentication mechanism that allows users to create accounts, log in and access their personal menstrual tracking data. Authentication is implemented using Laravel's built-in authentication system to ensure user privacy and data security.

**Functions:**

- User registration
- User login
- User logout
- Session management
- User data protection

### 4.2 Menstrual Records Management
SuciTrack allows users to manage menstrual cycle records through a complete Create, Read, Update and Delete (CRUD) system. Users can record the start and end dates of their menstrual periods, enabling the system to calculate cycle-related information automatically.

**Functions:**

- Add new menstrual records
- View menstrual history
- Edit existing records
- Delete records
- Store cycle duration information
- Track purity periods (Tuhr)

### 4.3 Prayer Time Integration
The system integrates with JAKIM Prayer Time API to retrieve accurate prayer schedules based on selected zones. This ensures that prayer-related calculations are aligned with official Malaysian prayer times.

**Functions:**

- Retrieve prayer times from JAKIM API
- Display daily prayer schedule
- Support prayer zone selection
- Update prayer information dynamically

### 4.4 Dashboard Monitoring
A centralized dashboard provides users with an overview of their menstrual status and related information. Important cycle information is displayed in organized and user-friendly interface.

**Functions:**

- Display current menstrual status
- Display recorded cycle information
- Display history of menstrual records
- Predict next menstrual cycle
- Show prayer-related information
- Quick access to system features and modules

### 4.5 Qada' Prayer Tracking
Qada' module assists users in identifying prayers that may need to be replaced due to menstrual periods. The system supports the management and monitoring of qada' prayer records.

**Functions:**

- Record qada' prayer information
- Manage qada' prayer records
- Display qada' prayer status

### 4.6 Responsive User Interface
This application is designed using Tailwind CSS and Blade templates to provide a clean and responsive user experience across different devices.

**Functions:**

- Responsive page layout
- Modern user interface
- Consistent navigation design
- Mobile-friendly display
- Interactive forms and components

## 5. Entity Relationship Diagram (ERD)

<p align="center">
    <img src="public/images/ERD_SuciTrack.png" width="350">
</p>

<p align="center">
    <b>Figure 1: Entity Relationship Diagram (ERD) of SuciTrack</b>
</p>

The database consists of two main entities: USERS and MENSTRUAL_RECORDS. 
A one-to-many relationship exists between the tables, where one user can create multiple menstrual records while each menstrual record belongs to only one user.

## 6. Sequence Diagram

<p align="center">
    <img src="public/images/SequenceDiagram.png" width="800">
</p>

<p align="center">
    <b>Figure 2: Sequence Diagram of SuciTrack</b>
</p>

The sequence diagram illustrates the interaction between the user, SuciTrack system, database, and JAKIM API. The process begins when a user registers an account and logs into the system. The application then verifies the user's credentials through the database before granting access to the dashboard. When a menstrual record is created, the system stores the record in the database and retrieves prayer time information from the JAKIM API based on the selected zone. The processed data is then displayed on the dashboard, allowing users to monitor their menstrual cycle information and prayer-related records through a centralized interface.

## 7. User Interface (Completed System)
<img width="1837" height="893" alt="image" src="https://github.com/user-attachments/assets/249a5d1d-3d5c-42f4-8137-b145410762e3" />
<img width="1919" height="898" alt="image" src="https://github.com/user-attachments/assets/1e8f64f7-360e-4b80-922a-046a1cff2e90" /># SuciTrack – Menstrual Purity Tracker
<img width="1918" height="954" alt="Screenshot 2026-06-08 012749" src="https://github.com/user-attachments/assets/cd7e753e-0637-49c4-966a-ee3a10275341" />
<img width="1918" height="940" alt="Screenshot 2026-06-08 012733" src="https://github.com/user-attachments/assets/3a201abd-c28e-4110-8b5a-f220b7d759b5" />
<img width="1760" height="869" alt="Screenshot 2026-06-08 012721" src="https://github.com/user-attachments/assets/9d17c21d-8128-4040-82e9-0a0044e271f2" />
<img width="1919" height="898" alt="Screenshot 2026-06-08 012813" src="https://github.com/user-attachments/assets/a2be86c7-26e2-492b-bcd0-d4e53d495979" />
<img width="1919" height="895" alt="Screenshot 2026-06-08 012804" src="https://github.com/user-attachments/assets/8409802c-9cd6-49eb-a57f-c2b3c4a1bf3e" />

## 8. Implementation Details
routes.web.php
<img width="1004" height="909" alt="image" src="https://github.com/user-attachments/assets/481eace6-a77d-485b-812f-29e0c1dd4733" />

## Routes Configuration Explanation
The 'web.php' file in Laravel defines the web routes of the application. Routes determine how incoming HTTP requests are handled and which controller methods or views are returned. In this project, the routes are organized into two main categories: **public routes** and **authenticated routes**.

1. **Public Route**  
   - The root URL ('/') is mapped to the 'landing' view.  
   - This serves as the public homepage, accessible to all users without authentication.

2. **Authenticated Routes**  
   - These routes are grouped under middleware 'auth' and 'verified', ensuring only logged in and email-verified users can access them.  
   - Key routes include:
     - **Dashboard**: '/dashboard' calls 'DashboardController@index' and displays the main user dashboard.  
     - **Menstrual Records**:  
       - '/menstrual_records/end' calls 'MenstrualController@endCycle' to mark the end of a cycle.  
       - 'Route::resource('menstrual_records', MenstrualController::class)' automatically generates full CRUD operations (create, read, update, delete) for menstrual records.  
     - **Qada Page**: '/qada' calls 'QadaController@index' to display the Qada (missed prayers) page.  
     - **Complete Qada**: '/dashboard/complete-qada/{id}' is a POST route that calls 'DashboardController@completeQada' to mark a specific Qada entry as completed.

3. **Authentication Routes**  
   - The file also includes 'auth.php', which contains all authentication-related routes such as login, registration, and password reset.

This routing structure ensures a clear separation between public and protected areas of the application. The **landing page** is open to all users, while sensitive features like the **dashboard**, **menstrual records management**, and **Qada tracking** are restricted to authenticated and verified users. The use of 'Route::resource' simplifies CRUD operations, and named routes improve readability and maintainability across the project.



## 9. Recommendations

## 10. Conclusion
