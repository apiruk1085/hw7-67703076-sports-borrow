# 🤝 Contributing to Sports Borrowing System

ขอบคุณที่ให้ความสนใจในการพัฒนาโปรเจค **Sports Borrowing System** ยินดีต้อนรับทุกคนที่มีส่วนร่วม ไม่ว่าจะเป็นการรายงาน Bug, เสนอฟีเจอร์ใหม่, หรือการส่งแก้ไขโค้ดเข้ามา (Pull Requests)!

## 🛠️ ขั้นตอนการมีส่วนร่วม (How to Contribute)

1. **Fork the Project** - กดปุ่ม Fork บริเวณมุมขวาบนของหน้านี้เพื่อคัดลอกโปรเจคไปยัง حساب GitHub ของคุณ
2. **Clone your Fork** - นำโปรเจคลงมายังเครื่องของคุณ:
   ```bash
   git clone https://github.com/YOUR-USERNAME/hw7-67703076-sports-borrow.git
   ```
3. **Create a Branch** - สร้าง Branch ใหม่สำหรับฟีเจอร์หรือข้อผิดพลาดที่คุณต้องการแก้ไข:
   ```bash
   git checkout -b feature/AmazingFeature
   # หรือสำหรับแก้บัก
   git checkout -b fix/BugName
   ```
4. **Make your Changes** - เขียนโค้ด, ตรวจสอบ, และทดสอบการทำงานให้เรียบร้อย
5. **Commit your Changes** - บันทึกการเปลี่ยนแปลงของคุณพร้อมข้อความที่อธิบายอย่างชัดเจน:
   ```bash
   git commit -m 'Add some AmazingFeature'
   ```
6. **Push to the Branch** - อัปโหลด Branch กลับไปที่หน้า Fork ของคุณ:
   ```bash
   git push origin feature/AmazingFeature
   ```
7. **Open a Pull Request** - กลับไปที่หน้า Repository ต้นทางหลัก และกดปุ่ม "New Pull Request" พร้อมอธิบายสิ่งที่คุณได้แก้ไขหรือเพิ่มเติม

## 📝 กฎการเขียนโค้ด (Coding Standards)

- **Naming Convention:**
  - ตัวแปรและฟังก์ชันใน **JavaScript/PHP** ควรเป็น `camelCase` (ตัวอย่าง: `fetchEquipment()`, `equipmentId`)
  - โครงสร้างฐานข้อมูล Table/Column ใน **SQL** ควรเป็น `snake_case` (ตัวอย่าง: `created_at`, `sports_equipment`)
- **Commenting:** อธิบายโค้ดในส่วนที่ซับซ้อน (สามารถใช้ภาษาไทยหรืออังกฤษก็ได้)
- **UI Consistency:** ควรตรวจสอบ UI เสมอเพื่อให้แน่ใจว่า Tailwind CSS แสดงผลได้ถูกต้องและไม่ทับซ้อน (Overlap) กับส่วนอื่น
- **Database Scope:** หากมีการแก้ไขที่กระทบต่อ Database กรุณาอัปเดตสคริปต์ในไฟล์ `database/init.sql` เสมอ

## 🐛 การรายงานปัญหา (Reporting Bugs)

หากคุณพบเจอข้อผิดพลาดของระบบ สามารถเปิด [Issues](../../issues) ใหม่ใน Repository พร้อมระบุรายละเอียดเพื่อให้นักพัฒนาเข้าใจและตามแก้ได้ง่ายขึ้น ดังนี้:
1. การทำงานที่คาดหวัง (Expected Behavior)
2. สิ่งที่เกิดขึ้นจริง (Actual Behavior / Bug)
3. ขั้นตอนการทำให้เกิดบั๊ก (Steps to Reproduce)
4. สภาพแวดล้อมที่ใช้ (เช่น Browser, XAMPP, หรือ Docker)
5. ภาพประกอบ / Screenshot (ถ้ามี)
