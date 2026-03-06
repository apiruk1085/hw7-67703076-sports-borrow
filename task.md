# 📋 Task Tracking for Sports Borrowing System

This document tracks the progress, completed features, and future goals of the Sports Borrowing System (ระบบยืม-คืนอุปกรณ์กีฬา).

## ✅ Completed (เสร็จสิ้นแล้ว)
- [x] ออกแบบฐานข้อมูลสำหรับจัดการอุปกรณ์กีฬา (Database Schema for Equipments)
- [x] สร้างหน้า Login แบบจำลอง (Simulation) พร้อมรองรับ AJAX
- [x] สร้าง Dashboard สำหรับการจัดการอุปกรณ์กีฬา
- [x] สร้าง API สำหรับ **อ่านข้อมูล (Read)** - ดึงรายการอุปกรณ์ทั้งหมด
- [x] สร้าง API สำหรับ **เพิ่มข้อมูล (Create)** - เพิ่มอุปกรณ์กีฬาใหม่
- [x] สร้าง API สำหรับ **แก้ไขข้อมูล (Update)** - อัปเดตข้อมูลอุปกรณ์ที่มีอยู่
- [x] สร้าง API สำหรับ **ลบข้อมูล (Delete)** - ลบอุปกรณ์ออกจากระบบ
- [x] นำ Tailwind CSS มาช่วยตกแต่ง UI ให้สวยงาม
- [x] ติดตั้ง jQuery Confirm สำหรับการทำ Dialog/Alert แจ้งเตือนผู้ใช้งาน
- [x] สร้างไฟล์ `Dockerfile` และ `docker-compose.yml` สำหรับสภาพแวดล้อมการพัฒนา
- [x] จัดทำเอกสารโปรเจคเบื้องต้น (`README.md`, `architecture.md`, `CONTRIBUTING.md`)

## 🚧 In Progress (กำลังดำเนินการ)
- [ ] ทดสอบระบบแบบ End-to-End เพื่อหาข้อผิดพลาด (Bugs) ในหน้าจอ UI และ Backend
- [ ] ตรวจสอบความถูกต้องของการกรอกข้อมูล (Form Validation) ให้ครอบคลุมมากขึ้น

## 🚀 Future Enhancements (เป้าหมายอนาคต)
- [ ] พัฒนาระบบ Authentication ที่สมบูรณ์ด้วยระบบ Session จริงและเข้ารหัส Hash Password ในฐานข้อมูล
- [ ] แจ้งเตือนผ่าน LINE Notify เมื่อมีการยืม/คืนอุปกรณ์
- [ ] เพิ่มระบบสิทธิ์ผู้ใช้งาน (Roles/Permissions) เช่น ผู้ดูแลระบบ (Admin) กับ นักเรียน (Student)
- [ ] เพิ่มหน้าสถานะประวัติการยืม-คืน (Transaction History Logging)
- [ ] สร้างกราฟสรุปสถิติประจำเดือนบนหน้า Dashboard (เช่น ใช้ Chart.js)
