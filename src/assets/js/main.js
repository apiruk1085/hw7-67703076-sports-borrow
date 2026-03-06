/**
 * ===================================================
 * main.js - จัดการ CRUD อุปกรณ์กีฬา (Dashboard)
 * ===================================================
 * - loadEquipment()      : โหลดข้อมูลจาก API
 * - renderTable()        : แสดงข้อมูลในตาราง
 * - showEquipmentForm()  : ฟอร์มเพิ่ม/แก้ไข (jQuery Confirm)
 * - deleteEquipment()    : ลบพร้อม Confirm Dialog
 */

$(document).ready(function () {
    loadEquipment();

    // ปุ่มเพิ่มอุปกรณ์
    $('#btnAdd').on('click', function () {
        showEquipmentForm();
    });

    // ปุ่ม Logout
    $('#btnLogout').on('click', function () {
        $.confirm({
            title: '🚪 ออกจากระบบ',
            content: 'คุณต้องการออกจากระบบใช่หรือไม่?',
            type: 'red',
            theme: 'modern',
            buttons: {
                confirm: {
                    text: '<i class="fas fa-check mr-1"></i> ยืนยัน',
                    btnClass: 'btn-red',
                    action: function () {
                        $.get('api/auth/logout.php', function () {
                            window.location.href = 'index.php';
                        });
                    }
                },
                cancel: { text: 'ยกเลิก' }
            }
        });
    });

    // ค้นหาแบบ Realtime
    $('#searchInput').on('keyup', function () {
        let term = $(this).val().toLowerCase();
        $('#equipmentTableBody tr').each(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(term) > -1);
        });
    });
});

// ==================== โหลดข้อมูลอุปกรณ์ ====================
function loadEquipment() {
    $('#loadingState').show();
    $('#emptyState').hide();
    $('#equipmentTableBody').html('');

    $.ajax({
        url: 'api/equipment/read.php',
        type: 'GET',
        dataType: 'json',
        success: function (res) {
            $('#loadingState').hide();
            if (res.success && res.data.length > 0) {
                renderTable(res.data);
                updateStats(res.data);
            } else {
                $('#emptyState').show();
                updateStats([]);
            }
        },
        error: function () {
            $('#loadingState').hide();
            $('#equipmentTableBody').html(
                '<tr><td colspan="7" class="text-center py-8 text-red-400">' +
                '<i class="fas fa-exclamation-circle mr-2"></i>ไม่สามารถโหลดข้อมูลได้</td></tr>'
            );
        }
    });
}

// ==================== แสดงข้อมูลในตาราง ====================
function renderTable(data) {
    let html = '';
    data.forEach(function (item, index) {
        let badge = getStatusBadge(item.status);
        let desc = escapeHtml(item.description || '-');
        let name = escapeHtml(item.name);

        html += '<tr class="border-b border-slate-700/30">' +
            '<td class="px-5 py-4 text-slate-400 font-mono text-xs">' + (index + 1) + '</td>' +
            '<td class="px-5 py-4 font-medium text-white">' + name + '</td>' +
            '<td class="px-5 py-4 text-slate-400 text-sm hidden md:table-cell">' + desc + '</td>' +
            '<td class="px-5 py-4 text-center text-white font-medium">' + item.total_quantity + '</td>' +
            '<td class="px-5 py-4 text-center font-semibold ' +
            (item.available_quantity > 0 ? 'text-emerald-400' : 'text-red-400') + '">' +
            item.available_quantity + '</td>' +
            '<td class="px-5 py-4 text-center">' + badge + '</td>' +
            '<td class="px-5 py-4 text-center">' +
            '<div class="flex items-center justify-center space-x-1">' +
            '<button onclick="showEquipmentForm(' + item.id + ')" ' +
            'class="bg-amber-500/10 hover:bg-amber-500/20 text-amber-400 w-8 h-8 rounded-lg transition-all" title="แก้ไข">' +
            '<i class="fas fa-pen text-xs"></i></button>' +
            '<button onclick="deleteEquipment(' + item.id + ',\'' + escapeAttr(item.name) + '\')" ' +
            'class="bg-red-500/10 hover:bg-red-500/20 text-red-400 w-8 h-8 rounded-lg transition-all" title="ลบ">' +
            '<i class="fas fa-trash text-xs"></i></button>' +
            '</div>' +
            '</td></tr>';
    });
    $('#equipmentTableBody').html(html);
    $('#emptyState').hide();

    // เก็บ data ไว้ใน global เพื่อใช้ตอน edit
    window._equipmentData = data;
}

// ==================== ฟอร์มเพิ่ม/แก้ไขอุปกรณ์ ====================
function showEquipmentForm(editId) {
    let isEdit = (typeof editId !== 'undefined' && editId !== null);
    let item = {};

    if (isEdit && window._equipmentData) {
        item = window._equipmentData.find(function (d) { return d.id == editId; }) || {};
    }

    let formHtml =
        '<div class="space-y-4 pt-2" style="text-align:left;">' +
        '<div>' +
        '<label class="block text-sm font-medium mb-1" style="color:#94a3b8;">ชื่ออุปกรณ์ <span style="color:#f87171;">*</span></label>' +
        '<input type="text" id="eqName" value="' + escapeAttr(item.name || '') + '" ' +
        'class="w-full px-3 py-2 rounded-lg border text-sm" ' +
        'style="background:#1e293b;border-color:#475569;color:#fff;" placeholder="เช่น ลูกฟุตบอล">' +
        '</div>' +
        '<div>' +
        '<label class="block text-sm font-medium mb-1" style="color:#94a3b8;">รายละเอียด</label>' +
        '<textarea id="eqDesc" rows="2" ' +
        'class="w-full px-3 py-2 rounded-lg border text-sm" ' +
        'style="background:#1e293b;border-color:#475569;color:#fff;resize:none;" ' +
        'placeholder="รายละเอียดเพิ่มเติม...">' + escapeHtml(item.description || '') + '</textarea>' +
        '</div>' +
        '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">' +
        '<div>' +
        '<label class="block text-sm font-medium mb-1" style="color:#94a3b8;">จำนวนทั้งหมด <span style="color:#f87171;">*</span></label>' +
        '<input type="number" id="eqTotalQty" value="' + (item.total_quantity || '') + '" min="0" ' +
        'class="w-full px-3 py-2 rounded-lg border text-sm" ' +
        'style="background:#1e293b;border-color:#475569;color:#fff;" placeholder="0">' +
        '</div>' +
        '<div>' +
        '<label class="block text-sm font-medium mb-1" style="color:#94a3b8;">คงเหลือ' + (isEdit ? ' <span style="color:#f87171;">*</span>' : '') + '</label>' +
        '<input type="number" id="eqAvailQty" value="' + (isEdit ? item.available_quantity : '') + '" min="0" ' +
        'class="w-full px-3 py-2 rounded-lg border text-sm" ' +
        'style="background:#1e293b;border-color:#475569;color:#fff;' + (isEdit ? '' : 'opacity:0.5;') + '" ' +
        'placeholder="' + (isEdit ? '0' : 'อัตโนมัติ') + '" ' + (isEdit ? '' : 'disabled') + '>' +
        '</div>' +
        '</div>' +
        '</div>';

    $.confirm({
        title: isEdit ? '✏️ แก้ไขอุปกรณ์' : '➕ เพิ่มอุปกรณ์ใหม่',
        content: formHtml,
        type: isEdit ? 'orange' : 'blue',
        theme: 'modern',
        columnClass: 'medium',
        buttons: {
            save: {
                text: '<i class="fas fa-save mr-1"></i> ' + (isEdit ? 'บันทึกการแก้ไข' : 'เพิ่มอุปกรณ์'),
                btnClass: isEdit ? 'btn-orange' : 'btn-blue',
                action: function () {
                    let name = $('#eqName').val().trim();
                    let desc = $('#eqDesc').val().trim();
                    let totalQty = parseInt($('#eqTotalQty').val()) || 0;
                    let availQty = isEdit ? (parseInt($('#eqAvailQty').val()) || 0) : totalQty;

                    if (!name || totalQty <= 0) {
                        $.alert({ title: '⚠️', content: 'กรุณากรอกชื่อและจำนวน (มากกว่า 0)', type: 'orange', theme: 'modern' });
                        return false;
                    }

                    let url = isEdit ? 'api/equipment/update.php' : 'api/equipment/create.php';
                    let postData = { name: name, description: desc, total_quantity: totalQty };
                    if (isEdit) {
                        postData.id = editId;
                        postData.available_quantity = availQty;
                    }

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: postData,
                        dataType: 'json',
                        success: function (res) {
                            if (res.success) {
                                $.confirm({
                                    title: '✅ สำเร็จ!', content: res.message, type: 'green', theme: 'modern',
                                    autoClose: 'ok|1500',
                                    buttons: { ok: { text: 'ตกลง', btnClass: 'btn-green' } }
                                });
                                loadEquipment();
                            } else {
                                $.alert({ title: '❌ ผิดพลาด', content: res.message, type: 'red', theme: 'modern' });
                            }
                        },
                        error: function () {
                            $.alert({ title: '❌', content: 'เกิดข้อผิดพลาดในการเชื่อมต่อ', type: 'red', theme: 'modern' });
                        }
                    });
                }
            },
            cancel: { text: 'ยกเลิก' }
        }
    });
}

// ==================== ลบอุปกรณ์ ====================
function deleteEquipment(id, name) {
    $.confirm({
        title: '🗑️ ยืนยันการลบ',
        content: 'คุณต้องการลบ <strong>"' + name + '"</strong> ใช่หรือไม่?<br><small style="color:#f87171;">⚠️ การลบไม่สามารถกู้คืนได้</small>',
        type: 'red',
        theme: 'modern',
        buttons: {
            confirm: {
                text: '<i class="fas fa-trash mr-1"></i> ลบเลย',
                btnClass: 'btn-red',
                action: function () {
                    $.ajax({
                        url: 'api/equipment/delete.php',
                        type: 'POST',
                        data: { id: id },
                        dataType: 'json',
                        success: function (res) {
                            if (res.success) {
                                $.confirm({
                                    title: '✅ ลบสำเร็จ!', content: res.message, type: 'green', theme: 'modern',
                                    autoClose: 'ok|1500',
                                    buttons: { ok: { text: 'ตกลง', btnClass: 'btn-green' } }
                                });
                                loadEquipment();
                            } else {
                                $.alert({ title: '❌', content: res.message, type: 'red', theme: 'modern' });
                            }
                        },
                        error: function () {
                            $.alert({ title: '❌', content: 'เกิดข้อผิดพลาดในการเชื่อมต่อ', type: 'red', theme: 'modern' });
                        }
                    });
                }
            },
            cancel: { text: 'ยกเลิก' }
        }
    });
}

// ==================== อัปเดต Stats Cards ====================
function updateStats(data) {
    $('#statTotal').text(data.length);
    let available = data.filter(function (i) { return i.status === 'available'; }).length;
    let lowOrOut = data.filter(function (i) { return i.status === 'low' || i.status === 'out_of_stock'; }).length;
    $('#statAvailable').text(available);
    $('#statLow').text(lowOrOut);
}

// ==================== Status Badge ====================
function getStatusBadge(status) {
    switch (status) {
        case 'available':
            return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">' +
                '<i class="fas fa-circle text-[6px] mr-1.5"></i>พร้อมใช้</span>';
        case 'low':
            return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-500/10 text-amber-400 border border-amber-500/20">' +
                '<i class="fas fa-circle text-[6px] mr-1.5"></i>ใกล้หมด</span>';
        case 'out_of_stock':
            return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-500/10 text-red-400 border border-red-500/20">' +
                '<i class="fas fa-circle text-[6px] mr-1.5"></i>หมด</span>';
        default:
            return '<span class="text-slate-500 text-xs">-</span>';
    }
}

// ==================== Utility Functions ====================
function escapeHtml(str) {
    if (!str) return '';
    return $('<div>').text(str).html();
}

function escapeAttr(str) {
    if (!str) return '';
    return str.replace(/'/g, "\\'").replace(/"/g, '&quot;');
}
