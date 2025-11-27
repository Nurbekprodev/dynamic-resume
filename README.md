---

# **Dynamic Resume Builder**

A PHP-based resume management system that allows users to create, update, and publicly display a professional resume with sections for Experience, Education, Skills, and Projects.

---

## 🚀 **Features**

### **👤 User Authentication**

* User Registration & Login System (secure with password hashing)
* Session-based authentication
* Access-controlled admin dashboard

### **📄 Resume Management**

* Manage your full resume:

  * Personal Info
  * Experience
  * Education
  * Skills
  * Projects
* Add, Edit, Delete operations for each section
* Live preview of your resume

### **🌐 Public Resume Page**

* Automatically generates a clean, readable public resume
* Shows profile picture, biography, social links, and all sections

### **🖼 File Uploads**

* Upload profile photo (avatar)
* Safe file handling & sanitization

### **🎨 UI & Layout**

* Header + footer included on every page
* Sticky footer layout
* Clean, consistent form design
* Dashboard layout for easy navigation

---

## 🛠️ **Tech Stack**

| Technology             | Purpose                     |
| ---------------------- | --------------------------- |
| **PHP 8+**             | Backend logic and routing   |
| **MySQL / phpMyAdmin** | Database                    |
| **HTML / CSS**         | UI                          |
| **JavaScript**         | Dropdowns, UX details       |
| **PDO**                | Secure database connections |

---

## 📁 **Project Structure**

```
dynamic-resume/
│
├── admin/
│   ├── dashboard.php
│   ├── add_experience.php
│   ├── edit_experience.php
│   ├── ...
│
├── users/
│   ├── login.php
│   ├── register.php
│   ├── logout.php
│
├── includes/
│   ├── db_connect.php
│   ├── functions.php
│   ├── header.php
│   ├── footer.php
│
├── uploads/
│   └── profile images stored here
│
├── css/
│   └── style.css
│
├── index.php     (Public resume)
├── README.md
```

---

## 📦 **Installation**

### **1. Clone Repository**

```bash
[git clone https://github.com/YOUR_USERNAME/dynamic-resume.git
cd dynamic-resume](https://github.com/Nurbekprodev/dynamic-resume.git)
```

### **2. Set Up Database**

* Create a MySQL database (example: `dynamic_resume`)
* Import your SQL file (if you exported one), or create these tables:

```
users
resume
experience
education
skills
projects
```

### **3. Configure Database Connection**

Edit:

```
includes/db_connect.php
```

Set:

```php
$host = "localhost";
$dbname = "dynamic_resume";
$username = "root";
$password = "";
```

### **4. Start Local Server**

If using XAMPP/WAMP:

* Place the project folder into `htdocs/`
* Visit:

```
http://localhost/dynamic-resume/
```

---

## 🧩 **How to Use**

### **For Visitors (Public Resume Page)**

* View the resume at `index.php`
* Download or copy the resume details

### **For Registered Users**

1. Register an account
2. Login
3. Use the dashboard to:

   * Add experience
   * Add education
   * Add skills
   * Add projects
   * Edit or delete existing entries
4. Upload a profile photo
5. View the updated public resume anytime

---

## 🔒 **Security Highlights**

* Input sanitization (`sanitize_input()`)
* Password hashing (`password_hash()`)
* Prepared statements (PDO)
* Session protection

---

## 🎯 **Future Improvements (Optional Goals)**

* Dark/Light mode
* Export resume as PDF
* API for JSON resume data
* Multiple resume templates
* Drag-and-drop section ordering

---

## 🤝 **Contributing**

Pull requests are welcome!
For major changes, please open an issue first to discuss what you want to add.

---

## 📄 License

This project is licensed under the **MIT License**.

