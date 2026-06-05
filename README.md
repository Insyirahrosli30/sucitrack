# SuciTrack – Menstrual Purity Tracker

## Group Members
Alya Qistina Nadia binti Idris 231134
*Leader
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

Putri Nur Batrisyia binti Azizul (2412444)
* Design database tables
* Create ERD
* Setup MySQL database
* Create Laravel migrations
* Create models
* Setup foreign keys and relationships
* Design login page
* Design register page
* Create authentication forms
* Style input forms
* Connect forms with backend routes
* Connect Laravel with JAKIM API
  
Wan Nur Hanees binti Wan Shukri (2415978)
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

Wan Nur Insyirah binti Wan Rosli (2410848)
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


##1. Introduction
SuciTrack is a specialized, Laravel-based web application cater assist Muslim women in tracking their menstrual cycles (Hayd) and periods of purity (Tuhr) in strict accordance with Shariah (Islamic jurisprudence) guidelines.

Navigating the complexities of Islamic rulings regarding prayer (Salah), fasting (Sawm), and other acts of worship during and after menstruation can be challenging. SuciTrack addresses this by replacing manual calculations with an automated, reliable digital solution. By combining the robust Model-View-Controller (MVC) architecture of Laravel with precise jurisprudential logic, the platform empowers users to maintain the five daily prayers and accurately manage their religious obligations.

## 2. Problem Statement & Objectives
2.1 Problem Statement
Many contemporary period tracking applications are designed purely from a medical or lifestyle perspective. They lack the specific logical parameters required to determine Islamic purity, such as tracking the exact duration of a valid period, identifying irregular bleeding (Istihadah), or calculating missed prayers that require replacement (Qada'). This leaves users to manually calculate their end period time, often leading to confusion regarding their validation for acts of worship.

2.2 Project Objectives tgk balikkkkkkkkkkkkkkkkkkkk
- Provide an interactive website for users to log, view, and manage their historical cycle data.

- Eliminate manual calculation errors by automating the determination of purity days, valid menstruation limits, and transitional phases.

- Support users in fulfilling their religious duties by implementing a structured system to track and clear Qada' (missed) prayers.

## 3. System Architecture & Features
3.1 Core Features
The application is built around four primary functional pillars:
- Secure user authentication through registration and login systems to ensure user data protection and privacy.
- Menstrual Records Management (CRUD) Create, Read, Update, and Delete capabilities allowing users to log start/end times.
- A visual featuring current cycle status, days of purity, unresolved qada' prayers, zone selection based on systemic calculations.
- Historical trends, predictive modeling for future cycles to inform users.

3.2 Technical 
Backend Framework: Laravel (PHP), JavaScript
Frontend Interface: Blade Templating Engine, Tailwind CSS (augmented with Livewire for real-time reactivity)
Database: MySQL


<img width="724" height="491" alt="Screenshot (451)" src="https://github.com/user-attachments/assets/57c034bf-b1d6-4d31-be7c-c04cd30b5431" />


