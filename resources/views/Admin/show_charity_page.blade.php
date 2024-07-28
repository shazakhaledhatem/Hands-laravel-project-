<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
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

.profile-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}

.profile-header h3 {
    margin: 0;
}

.profile-header p {
    margin: 5px 0;
    color: #777;
}

.profile-header .email {
    color: #555;
}

.profile-details {
    margin-bottom: 20px;
}

.profile-details h3 {
    margin-bottom: 10px;
}

.profile-details p {
    margin: 5px 0;
}

.details-group {
    margin-bottom: 20px;
}

.details-group p {
    display: flex;
    justify-content: space-between;
    margin: 5px 0;
}

.details-group p span {
    font-weight: bold;
}

.cards-slider {
    margin-bottom: 20px;
}

.card {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    text-align: center;
    padding: 20px;
    margin: 10px;
}

.card h4 {
    margin: 10px 0;
    font-size: 16px;
}

.card p {
    margin: 5px 0;
    color: #777;
}

.slick-prev:before,
.slick-next:before {
    color: black;
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
            <h2>لوحة التحكم / عرض الجمعيات / عرض الملف الشخصي</h2>
            <button class="action-button delete">حذف الملف</button>
        </header>
        <div class="profile-header">
            <div>
                <h3>اسم الجمعية</h3>
                <p class="email">charity@example.com</p>
            </div>
            <div>
                <span class="icon">🔍</span>
            </div>
        </div>
        <div class="profile-details">
            <div class="details-group">
                <h3>المعلومات الأساسية</h3>
                <p><span>التاريخ:</span> May 27, 2022</p>
                <p><span>الهاتف:</span> (484) 816-2133</p>
                <p><span>العنوان:</span> 3675 Beach Street, Indianapolis, IN 46203</p>
            </div>
        </div>
        <div class="cards-slider">
            <div class="card">
                <h4>اسم النشاط</h4>
                <p>08:00 - 09:00 AM</p>
                <p>الفرع</p>
            </div>
            <div class="card">
                <h4>اسم النشاط</h4>
                <p>08:00 - 09:00 AM</p>
                <p>الفرع</p>
            </div>
            <div class="card">
                <h4>اسم النشاط</h4>
                <p>08:00 - 09:00 AM</p>
                <p>الفرع</p>
            </div>
            <div class="card">
                <h4>اسم النشاط</h4>
                <p>08:00 - 09:00 AM</p>
                <p>الفرع</p>
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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.cards-slider').slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                arrows: true,
                dots: true
            });
        });
    </script>
</body>
</html>
