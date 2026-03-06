# 🏗️ System Architecture: Sports Borrowing System

เอกสารนี้อธิบายถึงสถาปัตยกรรมของระบบ การไหลของข้อมูล (Data Flow) และโครงสร้างการทำงานภายในเบื้องหลังโปรเจค **Sports Borrowing System**

---

## 1. Tech Stack Overview

ระบบถูกพัฒนาตามรูปแบบแอพพลิเคชัน Web-based (Client-Server Architecture) โดยแบ่งเป็นส่วนหลักๆ ดังนี้:
- **Frontend Layer:** `HTML`, `JavaScript (jQuery, AJAX)`, `Tailwind CSS`, `jQuery Confirm`
- **Backend Layer:** `PHP 8+` พร้อมส่วนขยาย `PDO` (PHP Data Objects) สำหรับจัดการข้อมูลในรูปแบบ RESTful API แบบพื้นฐาน
- **Database Layer:** `MySQL` (Relational Database)
- **Infrastructure:** `Docker`, `Docker Compose`

---

## 2. Directory & Structure Logic

```text
📁 src
├── 📁 api/ (API Endpoints สำหรับรับ-ส่งข้อมูลกับ Frontend)
│   ├── 📁 auth/ (จัดการการเชื่อมต่อจำลอง เช่น login.php, logout.php)
│   └── 📁 equipment/ (จัดการการทำ CRUD อุปกรณ์)
│       ├── create.php
│       ├── read.php
│       ├── update.php
│       └── delete.php
├── 📁 assets/ (ไฟล์ Static สำหรับ Frontend)
│   ├── 📁 js/ (ไฟล์ main.js และ auth.js ควบคุมลอจิกฝั่งผู้ใช้)
├── 📁 config/ (ตั้งค่าโครงสร้างระบบ)
│   └── db.php (Singleton คลาส หรือการตั้งค่า Database Connection)
├── index.php (UI: หน้าจอ Login เข้าสู่ระบบ)
└── dashboard.php (UI: หน้าจอการจัดการข้อมูลหลังบ้านสำหรับอุปกรณ์กีฬา)
```

---

## 3. Communication Flow (การรับส่งข้อมูล)

ระบบใช้แนวคิดการทำงานประสานกันแบบกึ่ง **Single-Page Application (SPA)** โดยเน้นใช้ AJAX เพื่อลดการรีเฟรชหน้าเว็บ:
1. **[User Action]** ผู้ใช้ (Client) กดปุ่ม "เพิ่มข้อมูล" หรือ "ลบข้อมูล" ผ่านหน้า `dashboard.php`
2. **[Frontend Logic]** ไฟล์ `assets/js/main.js` จะดักจับ Event ของปุ่ม และรวบรวมข้อมูลผ่าน HTTP Request (POST method สู่ Endpoints ใน `api/equipment/`)
3. **[Backend Logic]** ไฟล์ PHP Backend (เช่น `create.php`) รับพารามิเตอร์ และประมวลผลคำสั่งลงตารางฐานข้อมูล ผ่านไฟล์ `config/db.php` ด้วยการทำงานรูปแบบ Prepared Statements
4. **[Response]** Backend จะทำการตอบกลับผลลัพธ์ (Response) ไปยังเบราว์เซอร์ในรูปแบบ `JSON` (ตัวอย่าง: `{"status": "success", "message": "เพิ่มข้อมูลสำเร็จ"}`)
5. **[UI Update]** ฝั่ง Frontend นำสถานะที่ได้ทำการแสดงแจ้งเตือน (jQuery Confirm) และรีโหลดข้อมูลตารางอุปกรณ์แบบฉับพลันด้วย JavaScript โดยไม่ต้องโหลดหน้าเว็บใหม่

---

## 4. Database Schema Structure

การสร้างฐานข้อมูลใน MySQL อ้างอิงจากไฟล์ `database/init.sql` ซึ่งมีโครงสร้างตารางหลัก เช่น:
- **`equipments` Table**: บันทึกข้อมูลของอุปกรณ์ที่ให้ยืม
  - `id` (Primary Key, Auto Increment)
  - `name` (VARCHAR, ชื่ออุปกรณ์)
  - `quantity` (INT, จำนวนคงเหลือในระบบ)
  - `created_at` / `updated_at` (Timeline ของบันทึก)

*(ตารางอื่นๆ จะถูกเพิ่มตามความต้องการในอนาคต เช่น ประวัติการทำรายการ)*

---

## 5. Security Measures (มาตรการความปลอดภัย)

เพื่อให้โค้ดมีช่องโหว่น้อยที่สุด โครงสร้างถูกออกแบบมาพร้อมตัวบล็อกเบื้องต้น:
- **SQL Injection Prevention:** ใช้ **Prepared Statements (PDO)** ควบคุมพารามิเตอร์ทุกตัวก่อนส่งเข้า MySQL
- **AJAX Output Sanitization:** ไม่มีการโยน Error ที่มีรายละเอียด Database ออกสู่หน้าจอผู้ใช้งานตรงๆ แต่ส่งข้อความ Error ที่สกัดแล้วผ่าน JSON
- **Environment Automation:** ไฟล์ฐานข้อมูลและการเชื่อมต่อ ถูกรันใน Docker Container ที่แยกพอร์ตการทำงานเป็นสัดส่วน ป้องกันการขัดแย้งของฐานข้อมูลในโฮสต์หลัก
