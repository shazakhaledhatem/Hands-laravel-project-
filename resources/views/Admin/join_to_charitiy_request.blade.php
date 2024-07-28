<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<style>
body {
    font-family: Arial, sans-serif;
    direction: rtl;
    margin: 0;
    padding: 0;
    background-color: #f5f5f5;
}

.container {
    max-width: 1200px;
    margin: 20px auto;
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

header h2 {
    margin: 0;
}

.search-bar {
    display: flex;
    align-items: center;
}

.search-bar input,
.search-bar select {
    padding: 5px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-left: 10px;
}

.table-container {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
}

table th, table td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: center;
}

table th {
    background-color: #f2f2f2;
}

.status-green {
    background-color: #4caf50;
    color: white;
    padding: 5px 10px;
    border-radius: 4px;
}

.status-yellow {
    background-color: #ffeb3b;
    color: black;
    padding: 5px 10px;
    border-radius: 4px;
}

.status-red {
    background-color: #f44336;
    color: white;
    padding: 5px 10px;
    border-radius: 4px;
}

.action-button {
    padding: 5px 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.action-button.view {
    background-color: #2196f3;
    color: white;
}

.action-button.delete {
    background-color: #f44336;
    color: white;
}

.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
}

.pagination a {
    margin: 0 5px;
    padding: 10px 15px;
    background-color: #00bcd4;
    color: white;
    border-radius: 4px;
    text-decoration: none;
}

.pagination a:hover {
    background-color: #0097a7;
}
</style>
<body>
    <div class="container">
        <header>
            <h2>لوحة التحكم / طلبات انضمام الجمعيات</h2>
            <div class="search-bar">
                <input type="text" placeholder="بحث...">
                <select>
                    <option value="">نوع الفرع</option>
                </select>
                <select>
                    <option value="">نوع الدور</option>
                </select>
            </div>
        </header>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>اسم الجمعية</th>
                        <th>الفرع</th>
                        <th>حالة الطلب</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="checkbox"></td>
                        <td><img src="https://via.placeholder.com/40" alt="Ryan Walker"> Ryan Walker</td>
                        <td>Content</td>
                        <td><span class="status-red">مرفوض</span></td>
                        <td>
                            <button class="action-button view">عرض</button>
                            <button class="action-button delete">حذف</button>
                        </td>
                    </tr>
                    <!-- Repeat similar rows for other entries -->
                </tbody>
            </table>
        </div>
        <div class="pagination">
            <a href="#">1</a>
            <a href="#">2</a>
            <a href="#">3</a>
            <a href="#">4</a>
            <a href="#">5</a>
            <a href="#">...</a>
            <a href="#">11</a>
        </div>
    </div>
</body>
</html>
