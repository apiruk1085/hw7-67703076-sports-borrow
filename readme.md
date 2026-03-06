# 🏀 Sports Borrowing System (ระบบยืม-คืนอุปกรณ์กีฬา)

[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com/)
[![Docker](https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white)](https://www.docker.com/)

ระบบจัดการยืม-คืนอุปกรณ์กีฬา พัฒนาด้วย **PHP PDO**, **AJAX**, และ **Tailwind CSS** โครงสร้างของโปรเจคถูกออกแบบมาให้สามารถใช้งานร่วมกับ Docker เพื่อความสะดวกในการติดตั้งและทดสอบระบบ

## ✨ Features (คุณสมบัติหลัก)

- 🔐 **ระบบ Login** (Simulation) - เข้าสู่ระบบเพื่อจัดการข้อมูล
- 📦 **CRUD อุปกรณ์กีฬา** - สามารถเพิ่ม (Create), ดูรายละเอียด (Read), แก้ไข (Update), และลบ (Delete) ข้อมูลอุปกรณ์กีฬาได้อย่างครบถ้วน
- 🎨 **Modern UI** - แสดงผลด้วย Tailwind CSS ทำให้หน้าตาของเว็บไซต์ดูสวยงาม ใช้งานง่าย
- ⚡ **Interactive System** - รองรับการทำงานแบบ Asynchronous ด้วย AJAX และใช้งาน `jQuery Confirm` สำหรับการแจ้งเตือน (Alerts/Dialogs)
- 🐳 **Dockerization** - รองรับการรันเซิร์ฟเวอร์ด้วย Docker Compose

---

## 🛠️ Technologies Used (เทคโนโลยีที่ใช้)

- **Frontend**: HTML5, Tailwind CSS, JavaScript, jQuery, jQuery Confirm
- **Backend**: PHP (PDO)
- **Database**: MySQL
- **Infrastructure**: Docker, Docker Compose

---

## 🚀 Getting Started (วิธีการติดตั้งและใช้งาน)

### วิธีที่ 1: ติดตั้งผ่าน Docker (แนะนำ)

1. ตรวจสอบให้แน่ใจว่าติดตั้ง [Docker](https://www.docker.com/) และ Docker Compose ในเครื่องเรียบร้อยแล้ว
2. โคลน Repository นี้:
   ```bash
   git clone https://github.com/apiruk1085/hw7-67703076-sports-borrow.git
   cd hw7-67703076-sports-borrow
   ```
3. รันคำสั่ง Docker Compose:
   ```bash
   docker-compose up -d
   ```
4. เปิดเบราว์เซอร์และเข้าไปที่: `http://localhost:8080/src/`

### วิธีที่ 2: ติดตั้งบน Local Server (XAMPP / MAMP)

1. นำไฟล์หน้าเว็บทั้งหมดที่อยู่ในโปรเจคไปไว้ในโฟลเดอร์ `htdocs` (สำหรับ XAMPP) หรือแฟ้ม Root ของเซิร์ฟเวอร์เว็บ
2. สร้างฐานข้อมูล MySQL และ Import ไฟล์ `database/init.sql`
3. ตั้งค่าการเชื่อมต่อฐานข้อมูลในไฟล์ `src/config/db.php`
4. เปิดเบราว์เซอร์ไปที่ `http://localhost/YOUR_PROJECT_FOLDER/src/`

---

## 📂 Project Structure (โครงสร้างโปรเจค)

```text
📁 hw7-67703076-sports-borrow
├── 📁 database/       # ไฟล์ SQL สำหรับสร้างตารางฐานข้อมูล
├── 📁 src/            # โค้ดหลักของโปรเจค (Frontend และ Backend)
│   ├── 📁 api/        # RESTful API (Login, CRUD)
│   ├── 📁 assets/     # CSS, JavaScript
│   ├── 📁 config/     # ตั้งค่า Database (db.php)
│   ├── dashboard.php  # หน้าจัดการอุปกรณ์กีฬา
│   └── index.php      # หน้าเข้าสู่ระบบ (Login)
├── docker-compose.yml # การตั้งค่า Docker Compose
├── Dockerfile         # Dockerfile ของ PHP Server
└── README.md          # เอกสารของโปรเจค
```

---

## 👩‍💻 Developer

**apiruk1085** (67703076)