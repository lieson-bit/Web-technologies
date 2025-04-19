<?php
include 'db.php';
$view = isset($_GET['view']) ? $_GET['view'] : 'robots';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Промышленные роботы и Производители</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Промышленные роботы и Производители</h1>
        
        <div id="browser-info" class="browser-info"></div>
        
        <div class="button-container">
            <button onclick="loadData('robots')" class="primary-btn">Просмотр Роботов</button>
            <button onclick="loadData('manufacturers')" class="primary-btn">Просмотр Производителей</button>
            <button onclick="showMatrixSection()" class="secondary-btn">Матричные операции</button>
        </div>
        
        <div id="content-section">
            <!-- Content will be loaded here via AJAX -->
        </div>
        
        <div id="matrix-section" style="display:none;">
            <!-- Matrix section content -->
        </div>
    </div>

    <script>
    // Browser detection
    function detectBrowser() {
        const userAgent = navigator.userAgent;
        let browser = 'Unknown';
        
        if (userAgent.includes('Firefox')) browser = 'Firefox';
        else if (userAgent.includes('Chrome')) browser = 'Chrome';
        else if (userAgent.includes('Safari')) browser = 'Safari';
        else if (userAgent.includes('Edge')) browser = 'Edge';
        
        $('#browser-info').html(`
            <strong>Браузер:</strong> ${browser}<br>
            <strong>User Agent:</strong> ${userAgent}<br>
            <strong>AJAX поддержка:</strong> ${'XMLHttpRequest' in window ? 'Да' : 'Нет'}
        `);
    }
    
    // Load manufacturers for dropdown
    function loadManufacturers(callback) {
        $.ajax({
            url: 'api.php',
            method: 'GET',
            data: { table: 'manufacturers' },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    callback(response.data);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error loading manufacturers:", error);
            }
        });
    }
    
    // Main data loading function
    function loadData(table, editId = null) {
    $('#matrix-section').hide();
    $('#content-section').show().html('<div class="loading">Загрузка данных...</div>');
    
    $.ajax({
        url: 'api.php',
        method: 'GET',
        data: { table: table, id: editId || '' },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                renderTable(response.data, response.columns, table, editId);
                
                // Load manufacturers for robot form if needed
                if (table === 'robots') {
                    loadManufacturers(function(manufacturers) {
                        let options = '<option value="">Выберите производителя</option>';
                        manufacturers.forEach(manu => {
                            options += `<option value="${manu.id}">${manu.name}</option>`;
                        });
                        
                        // Set options for both add and edit forms
                        $('#manufacturer-select, #edit-manufacturer-select').html(options);
                        
                        // If in edit mode, set the selected manufacturer
                        if (editId && response.data.length > 0) {
                            const selectedManuId = response.data[0].manufacturer_id;
                            $('#edit-manufacturer-select').val(selectedManuId);
                        }
                    });
                }
            } else {
                $('#content-section').html(`<div class="error-card">Ошибка: ${response.error || 'Неизвестная ошибка'}</div>`);
            }
        },
        error: function(xhr, status, error) {
            $('#content-section').html(`<div class="error-card">Ошибка загрузки: ${error}</div>`);
        }
    });
}
    
    // Table rendering
    function renderTable(data, columns, table, editId = null) {
    let html = `<h2>${table === 'robots' ? 'Роботы' : 'Производители'}</h2>`;
    html += `<div class="table-responsive"><table class="data-table"><thead><tr>`;
    
    // Add headers
    columns.forEach(col => html += `<th>${col}</th>`);
    html += '<th>Действия</th></tr></thead><tbody>';
    
    // Add rows
    if (data && data.length > 0) {
        data.forEach(row => {
            html += '<tr>';
            
            if (table === 'robots') {
                html += `
                    <td>${row.model_name || ''}</td>
                    <td>${row.type || ''}</td>
                    <td>${row.weight || ''} кг</td>
                    <td>${row.payload || ''} кг</td>
                    <td>${row.manufacturer_name || ''}</td>
                    <td>${row.country || ''}</td>
                `;
            } else {
                html += `
                    <td>${row.name || ''}</td>
                    <td>${row.country || ''}</td>
                    <td>${row.founded_year || ''}</td>
                    <td><a href="${row.website || '#'}" target="_blank">${row.website || ''}</a></td>
                    <td>${row.rating || ''}/10</td>
                `;
            }
            
            // Action buttons
            html += `
            <td class="actions">
                <button onclick="showEditForm('${table}', ${row.id})" class="edit-btn">✏️</button>
                <button onclick="deleteItem('${table}', ${row.id})" class="delete-btn">🗑️</button>
            </td>
            `;

            
            html += '</tr>';
        });
    } else {
        html += `<tr><td colspan="${columns.length + 1}" class="no-data">Нет данных для отображения</td></tr>`;
    }
    
    html += '</tbody></table></div>';
    
    // Add form (edit or add)
    if (editId) {
        html += getEditForm(table, editId);
    } else {
        html += `
            <div class="form-card">
                <h3>Добавить нового ${table === 'robots' ? 'робота' : 'производителя'}</h3>
                ${table === 'robots' ? getRobotForm() : getManufacturerForm()}
            </div>
        `;
    }
    
    $('#content-section').html(html);
    
    // Populate edit fields if in edit mode
    if (editId && data && data.length > 0) {
        const item = data[0];
        
        if (table === 'robots') {
            $('#edit-model_name').val(item.model_name || '');
            $('#edit-type').val(item.type || '');
            $('#edit-weight').val(item.weight || '');
            $('#edit-payload').val(item.payload || '');
            
            // Manufacturer will be set after options are loaded in loadData()
        } else {
            $('#edit-name').val(item.name || '');
            $('#edit-country').val(item.country || '');
            $('#edit-founded_year').val(item.founded_year || '');
            $('#edit-website').val(item.website || '');
            $('#edit-rating').val(item.rating || '');
        }
    }
}

function confirmDelete(table, id) {
    if (confirm('Вы уверены, что хотите удалить эту запись?')) {
        $.ajax({
            url: 'api.php',
            method: 'POST',
            data: { 
                action: 'delete',
                table: table,
                id: id
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    loadData(table);
                } else {
                    alert('Ошибка: ' + (response.error || 'Не удалось удалить запись'));
                }
            },
            error: function() {
                alert('Ошибка соединения с сервером');
            }
        });
    }
}

    function deleteItem(table, id) {
        if (confirm('Вы уверены, что хотите удалить эту запись?')) {
            $.ajax({
                url: 'api.php',
                method: 'POST',
                data: JSON.stringify({
                    action: 'delete',
                    table: table,
                    id: id
                }),
                contentType: 'application/json',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        loadData(table);
                    } else {
                        alert('Ошибка: ' + (response.error || 'Не удалось удалить запись'));
                    }
                },
                error: function(xhr, status, error) {
                    alert('Ошибка соединения с сервером: ' + error);
                }
            });
        }
    }
    
    // Forms
    function getRobotForm() {
        return `
            <form id="add-form" onsubmit="addItem('robots'); return false;">
                <div class="form-group">
                    <label>Модель:</label>
                    <input type="text" name="model_name" required>
                </div>
                <div class="form-group">
                    <label>Тип:</label>
                    <input type="text" name="type" required>
                </div>
                <div class="form-group">
                    <label>Вес (кг):</label>
                    <input type="number" step="0.1" name="weight" required>
                </div>
                <div class="form-group">
                    <label>Грузоподъёмность (кг):</label>
                    <input type="number" step="0.1" name="payload" required>
                </div>
                <div class="form-group">
                    <label>Производитель:</label>
                    <select id="manufacturer-select" name="manufacturer_id" required>
                        <option value="">Загрузка производителей...</option>
                    </select>
                </div>
                <button type="submit" class="submit-btn">Добавить робота</button>
            </form>
        `;
    }
    
    function getManufacturerForm() {
        return `
            <form id="add-form" onsubmit="addItem('manufacturers'); return false;">
                <div class="form-group">
                    <label>Название:</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>Страна:</label>
                    <input type="text" name="country" required>
                </div>
                <div class="form-group">
                    <label>Год основания:</label>
                    <input type="number" name="founded_year" required>
                </div>
                <div class="form-group">
                    <label>Веб-сайт:</label>
                    <input type="url" name="website">
                </div>
                <div class="form-group">
                    <label>Рейтинг:</label>
                    <input type="number" step="0.1" name="rating" min="0" max="10">
                </div>
                <button type="submit" class="submit-btn">Добавить производителя</button>
            </form>
        `;
    }
    
    function getEditForm(table, id) {
        return `
            <div class="form-card">
                <h3>Редактировать ${table === 'robots' ? 'робота' : 'производителя'}</h3>
                <form id="edit-form" onsubmit="updateItem('${table}', ${id}); return false;">
                    <input type="hidden" name="id" value="${id}">
                    <input type="hidden" name="table" value="${table}">
                    ${table === 'robots' ? getRobotEditFields() : getManufacturerEditFields()}
                    <div class="form-actions">
                        <button type="submit" class="submit-btn">Обновить</button>
                        <button type="button" onclick="loadData('${table}')" class="cancel-btn">Отмена</button>
                    </div>
                </form>
            </div>
        `;
    }
    
    function getRobotEditFields() {
        return `
            <div class="form-group">
                <label>Модель:</label>
                <input type="text" name="model_name" id="edit-model_name" required>
            </div>
            <div class="form-group">
                <label>Тип:</label>
                <input type="text" name="type" id="edit-type" required>
            </div>
            <div class="form-group">
                <label>Вес (кг):</label>
                <input type="number" step="0.1" name="weight" id="edit-weight" required>
            </div>
            <div class="form-group">
                <label>Грузоподъёмность (кг):</label>
                <input type="number" step="0.1" name="payload" id="edit-payload" required>
            </div>
            <div class="form-group">
                <label>Производитель:</label>
                <select id="edit-manufacturer-select" name="manufacturer_id" required>
                    <option value="">Загрузка производителей...</option>
                </select>
            </div>
        `;
    }
    
    function getManufacturerEditFields() {
        return `
            <div class="form-group">
                <label>Название:</label>
                <input type="text" name="name" id="edit-name" required>
            </div>
            <div class="form-group">
                <label>Страна:</label>
                <input type="text" name="country" id="edit-country" required>
            </div>
            <div class="form-group">
                <label>Год основания:</label>
                <input type="number" name="founded_year" id="edit-founded_year" required>
            </div>
            <div class="form-group">
                <label>Веб-сайт:</label>
                <input type="url" name="website" id="edit-website">
            </div>
            <div class="form-group">
                <label>Рейтинг:</label>
                <input type="number" step="0.1" name="rating" id="edit-rating" min="0" max="10">
            </div>
        `;
    }
    
    function showEditForm(table, id) {
        loadData(table, id);
    }
    
    // Matrix section
    function showMatrixSection() {
        $('#content-section').hide();
        $('#matrix-section').show();
    }
    
    // CRUD operations
    function addItem(table) {
        const formData = $('#add-form').serialize();
        $.post('insert.php', formData + '&table=' + table, function(response) {
            try {
                const result = JSON.parse(response);
                if (result.success) {
                    loadData(table);
                } else {
                    alert('Ошибка: ' + (result.error || 'Неизвестная ошибка'));
                }
            } catch (e) {
                loadData(table);
            }
        }).fail(function(xhr, status, error) {
            alert('Ошибка при добавлении: ' + error);
        });
    }
    
    function updateItem(table, id) {
        const formData = $('#edit-form').serialize();
        $.post('update.php', formData, function(response) {
            try {
                const result = JSON.parse(response);
                if (result.success) {
                    loadData(table);
                } else {
                    alert('Ошибка: ' + (result.error || 'Неизвестная ошибка'));
                }
            } catch (e) {
                loadData(table);
            }
        }).fail(function(xhr, status, error) {
            alert('Ошибка при обновлении: ' + error);
        });
    }
    
    // Initialize
    $(document).ready(function() {
        detectBrowser();
        loadData('<?php echo $view; ?>');
    });
    </script>
</body>
</html>