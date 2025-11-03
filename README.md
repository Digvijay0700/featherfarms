# 🐓 Poultry Management System – Web-Based Farm Control Panel (PHP + MySQL)

### 🌍 Overview
The **Poultry Management System** is a centralized web platform designed to help farms digitally manage their entire poultry ecosystem — including **farmer registration, batch tracking, daily records, supervisor management, and biosecurity monitoring** — all from one clean dashboard.

This system acts as the **administrative backbone** of the AI-powered Feather Scanner ecosystem, offering data organization, analytics, and control through a web interface.

---

### 🧠 Key Features

✅ **Multi-User Access (Admin, Supervisor, Farmer)**  
Manage all roles and permissions within the farm ecosystem.

✅ **Bird Batch Management**  
Add, assign, and monitor bird batches across different farmers and supervisors.

✅ **Daily Records Logging**  
Maintain daily health and feeding records through simple web forms.

✅ **Supervisor & Farmer Management**  
Register and track supervisors, link them with farmers, and manage responsibilities.

✅ **Biosecurity Tracking**  
Monitor hygiene, health checklists, and alert status for each batch.

✅ **Admin Panel Dashboard**  
Central hub for all activities — view batches, records, and manage data.

✅ **Smart Reports**  
Generate summaries for farm performance, mortality, and daily logs.

✅ **Modular PHP Scripts**  
Each action (add, fetch, assign, view) is separated into individual PHP files for easy maintenance.

---

### 🧩 Tech Stack

| Component | Technology Used |
|------------|----------------|
| **Frontend** | HTML5, CSS3, JavaScript |
| **Backend** | PHP |
| **Database** | MySQL |
| **Server** | Apache (XAMPP / WAMP) |
| **Authentication** | PHP Sessions |
| **Hosting (optional)** | Localhost / Web Server |

---

### 📂 Project Structure
Poultry_Management_System/
│
├── index.html # Login page
├── admin_panel.html # Admin dashboard
│
├── add_farmer.php # Register new farmers
├── add_supervisor.php # Add new supervisor
├── Assign_Birds_Batch_Farmer.php # Assign bird batches
│
├── Create_Batch.php # Create a new bird batch
├── add_daily_records.php # Enter daily feed/health records
├── View_daily_records_supp.php # View supervisor’s daily reports
│
├── fetch_farmer.php # Fetch farmer details (AJAX)
├── fetch_supervisor.php # Fetch supervisor details (AJAX)
├── fetch_groups.php # Load group/batch info dynamically
│
├── submit_farmer.php # Submit new farmer data
├── supervisor_panel.php # Supervisor dashboard
├── login_authenticate.php # User login validation
