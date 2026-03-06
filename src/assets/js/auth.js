/**
 * ===================================================
 * auth.js - จัดการ Login Form ผ่าน AJAX
 * ===================================================
 */
$(document).ready(function () {
    $('#loginForm').on('submit', function (e) {
        e.preventDefault();

        let btn = $('#btnSubmit');
        let originalContent = btn.html();

        // แสดงสถานะ Loading
        btn.html('<i class="fas fa-spinner fa-spin mr-2"></i> กำลังตรวจสอบ...')
           .prop('disabled', true)
           .addClass('opacity-70 cursor-not-allowed');

        $.ajax({
            url: 'api/auth/login.php',
            type: 'POST',
            data: {
                username: $('#username').val(),
                password: $('#password').val()
            },
            dataType: 'json',
            success: function (res) {
                btn.html(originalContent).prop('disabled', false).removeClass('opacity-70 cursor-not-allowed');

                if (res.success) {
                    $.confirm({
                        title: '🎉 สำเร็จ!',
                        content: 'ยินดีต้อนรับ <strong>' + res.name + '</strong><br>กำลังพาท่านไปหน้าจัดการข้อมูล...',
                        type: 'green',
                        theme: 'modern',
                        autoClose: 'ok|2000',
                        buttons: {
                            ok: {
                                text: '<i class="fas fa-arrow-right mr-1"></i> ไปที่ Dashboard',
                                btnClass: 'btn-green',
                                action: function () {
                                    window.location.href = 'dashboard.php';
                                }
                            }
                        }
                    });
                } else {
                    $.confirm({
                        title: '🚨 ข้อผิดพลาด!',
                        content: res.message,
                        type: 'red',
                        theme: 'modern',
                        buttons: {
                            tryAgain: {
                                text: '<i class="fas fa-redo mr-1"></i> ลองอีกครั้ง',
                                btnClass: 'btn-red',
                                action: function () { $('#username').focus(); }
                            }
                        }
                    });
                }
            },
            error: function () {
                btn.html(originalContent).prop('disabled', false).removeClass('opacity-70 cursor-not-allowed');
                $.confirm({
                    title: '⚠️ เซิร์ฟเวอร์ผิดพลาด!',
                    content: 'ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้ กรุณาลองใหม่',
                    type: 'orange',
                    theme: 'modern',
                    buttons: { ok: { text: 'ตกลง', btnClass: 'btn-orange' } }
                });
            }
        });
    });
});
