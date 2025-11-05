# 📚 TutorLagbe – Smart Online Tutoring Platform

**TutorLagbe** is a modern web-based tutoring platform designed to connect **students** with **verified tutors** in a secure, user-friendly, and efficient way.  
It provides role-based dashboards for Students, Tutors, and Admins — enabling smooth tuition management, real-time communication, and performance analytics.

> “এক প্ল্যাটফর্মেই খুঁজুন দক্ষ টিউটর, দিন ক্লাস অনুরোধ, আর শিখুন নিজের সময়মতো।”

---

## 🌐 Project Overview
TutorLagbe bridges the gap between learners and educators through a **secure, dynamic, and responsive** web application.  
Students can easily find tutors by subject, location, or class, while tutors can manage their profiles, accept class requests, and chat with students in real time.  
Admins maintain full control over user approvals, data management, and analytics.

---

## 👥 User Roles & Core Features

### 🧑‍🎓 Student Panel
- Register/Login with validation  
- Search tutors by subject, class, or area  
- View detailed tutor profiles  
- Send tuition/class requests  
- Real-time messaging with tutors (AJAX)  
- View tuition history  
- Submit feedback and reviews  

### 🧑‍🏫 Tutor Panel
- Register/Login securely  
- Create & update profile with photo and subjects  
- Set availability and preferred salary  
- Receive and manage class requests  
- Accept/Reject tuition offers  
- Message students directly  
- View tuition analytics  

### 👨‍💼 Admin Panel
- Secure Admin Login  
- Manage all user accounts  
- Approve/Reject tutor registrations  
- Monitor messages and class requests  
- Ban or remove users if necessary  
- View analytics: Total users, active classes, feedback stats  
- Export reports (PDF/CSV)

---

## 🎨 Frontend (UI)
- **Technologies:** HTML5, CSS3, Bootstrap 5, JavaScript, jQuery  
- Fully responsive design (mobile, tablet, desktop)  
- Clean sidebar menus and card-based layout  
- Light/Dark mode toggle (optional)  
- Search filters and notification badges  

---

## ⚙️ Backend (Server-Side)
- **Technology:** Core PHP + MySQLi (Prepared Statements)  
- Secure login & session management  
- Role-based access and redirection  
- Real-time messaging via AJAX  
- Sanitized inputs to prevent SQL Injection & XSS  
- REST-like PHP endpoints for CRUD operations  
- Comprehensive form validation  

---

## 🗄️ Database Design
- **Database Name:** `TutorLagbe`  
- **Platform:** MySQL (XAMPP)  
- Normalized structure with relational tables for users, requests, messages, and reviews.  

---

## 🧰 Tech Stack Summary
| Layer | Technology Used |
|--------|----------------|
| **Frontend** | HTML5, CSS3, Bootstrap 5, JS, jQuery |
| **Backend** | Core PHP, AJAX |
| **Database** | MySQL (XAMPP / PhpMyAdmin) |
| **Authentication** | PHP Sessions |
| **Messaging** | AJAX (Real-time fetch/send) |

---

## ⚙️ Installation & Setup

1. **Clone this repository**
   ```bash
   git clone https://github.com/Muhtasim-Masum-Hasnayen/TutorLagbe.git
