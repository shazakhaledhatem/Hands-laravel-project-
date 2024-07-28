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

.cards {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.card {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    text-align: center;
    width: 30%;
    padding: 20px;
}

.card img {
    border-radius: 50%;
    width: 100px;
    height: 100px;
    object-fit: cover;
    margin-bottom: 10px;
}

.card h3 {
    margin: 10px 0;
    font-size: 18px;
}

.card p {
    margin: 5px 0;
    color: #777;
}

.card a {
    display: inline-block;
    margin-top: 10px;
    padding: 10px 20px;
    background-color: #e0e0e0;
    color: #333;
    border-radius: 4px;
    text-decoration: none;
}

.card a:hover {
    background-color: #ccc;
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
            <h2>لوحة التحكم / عرض الجمعيات</h2>
            <div class="search-bar">
                <input type="text" placeholder="بحث...">
                <select>
                    <option value="">جميع الجمعيات</option>
                </select>
            </div>
        </header>
        <div class="cards">
            <div class="card">
                <img src="https://via.placeholder.com/100" alt="اسم الجمعية">
                <h3>اسم الجمعية</h3>
                <p>202-555-0123</p>
                <p>CHARITY@EXAMPLE.COM</p>
                <a href="#">عرض الملف الشخصي</a>
            </div>
            <div class="card">
                <img src="https://via.placeholder.com/100" alt="اسم الجمعية">
                <h3>اسم الجمعية</h3>
                <p>202-555-0432</p>
                <p>CHARITY@EXAMPLE.COM</p>
                <a href="#">عرض الملف الشخصي</a>
            </div>
            <div class="card">
                <img src="https://via.placeholder.com/100" alt="اسم الجمعية">
                <h3>اسم الجمعية</h3>
                <p>111-523-0123</p>
                <p>CHARITY@EXAMPLE.COM</p>
                <a href="#">عرض الملف الشخصي</a>
            </div>
            <div class="card">
                <img src="https://via.placeholder.com/100" alt="اسم الجمعية">
                <h3>اسم الجمعية</h3>
                <p>202-555-0123</p>
                <p>CHARITY@EXAMPLE.COM</p>
                <a href="#">عرض الملف الشخصي</a>
            </div>
            <div class="card">
                <img src="https://via.placeholder.com/100" alt="اسم الجمعية">
                <h3>اسم الجمعية</h3>
                <p>202-555-0123</p>
                <p>CHARITY@EXAMPLE.COM</p>
                <a href="#">عرض الملف الشخصي</a>
            </div>
            <div class="card">
                <img src="https://via.placeholder.com/100" alt="اسم الجمعية">
                <h3>اسم الجمعية</h3>
                <p>202-555-0123</p>
                <p>CHARITY@EXAMPLE.COM</p>
                <a href="#">عرض الملف الشخصي</a>
            </div>
            <div class="card">
                <img src="https://via.placeholder.com/100" alt="اسم الجمعية">
                <h3>اسم الجمعية</h3>
                <p>202-555-0123</p>
                <p>CHARITY@EXAMPLE.COM</p>
                <a href="#">عرض الملف الشخصي</a>
            </div>
            <div class="card">
                <img src="https://via.placeholder.com/100" alt="اسم الجمعية">
                <h3>اسم الجمعية</h3>
                <p>202-555-0123</p>
                <p>CHARITY@EXAMPLE.COM</p>
                <a href="#">عرض الملف الشخصي</a>
            </div>
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
