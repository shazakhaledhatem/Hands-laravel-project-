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

.dashboard {
    display: flex;
}

.sidebar {
    width: 250px;
    background-color: white;
    color: white;
    padding: 20px;
    height: 100vh;
}

.sidebar h2 {
  color: black;
    margin-top: 0;
}

.sidebar ul {
    list-style: none;
    padding: 0;
}

.sidebar ul li {
    margin: 15px 0;
}

.sidebar ul li a {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.main-content {
    flex-grow: 1;
    padding: 20px;
}

header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

header h1 {
    margin: 0;
}

.search-bar {
    display: flex;
    align-items: center;
}

.search-bar input {
    padding: 5px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 1000px;
}

.stats {
    display: flex;
    justify-content: space-around;
    margin-top: 20px;
}

.stat {
    background-color: #6495ED;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    width: 20%;
}

.chart-container {
    margin-top: 40px;
    background-color: white;
    padding: 20px;
    border-radius: 8px;
}

.canvas-container {
    display: flex;
    justify-content: space-between;
}

canvas {
    width: 100% !important;
    height: 400px !important;
}

.donation-chart-container {
    width: 300px;
    height: 400px;
    margin-right: 20px;
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 40px;
}

.comments-sidebar {
    width: 300px;
    background-color: white;
    position: fixed;
    left: -300px;
    top: 0;
    bottom: 0;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    transition: left 0.3s ease;
}

.comments-sidebar.visible {
    left: 0;
}

.comments-sidebar h2 {
    margin-top: 0;
}

.comments-sidebar .comment {
    margin-bottom: 20px;
}

.comments-sidebar .comment h4 {
    margin: 0 0 5px 0;
}

.comments-sidebar .comment p {
    margin: 5px 0;
}

.comments-sidebar .comment .reply {
    color: #00bcd4;
    cursor: pointer;
}
.button5 {
  background-color: #04AA6D; /* Green */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  width: 50%;
  position: fixed;
  margin-top: 240px;
}

</style>
<body>
    <div class="dashboard">
        <div class="sidebar">
            <h2>واجهة التحكم</h2>
            <ul>
                <li><a href="#">عرض الجمعيات</a></li>
                <li><a href="#">تفعيل الحالة الطارئة</a></li>
                <li><a href="#">التقارير</a></li>
                <li><a href="#">عرض الفواتير</a></li>
                <li><a href="#">عرض طلبات انضمام الحمعيات</a></li>
                <li><a href="#" id="show-comments">التعليقات</a></li>
                <li><a href="#">إدارة الحساب</a></li>
            </ul>
            <button class="button button5">تسجيل خروج</button>
            <>
        </div>
        <div class="main-content">
            <header>

                <div class="search-bar">
                    <input type="text" placeholder="بحث...">
                </div>
                <div class="user-info">

                    <span>admin@example.com</span>
                </div>
                <div class="user-info">
                 <img src="{{ asset('user.png') }}" alt="User Image" style="width:40px">

                </div>

            </header>
            <div class="stats">
                <div class="stat">
                    <h3>عدد الطلبات</h3>
                    <p>99</p>
                </div>
                <div class="stat">
                    <h3>عدد المستخدمين</h3>
                    <p>99</p>
                </div>
                <div class="stat">
                    <h3>عدد الجمعيات</h3>
                    <p>99</p>
                </div>
            </div>
            <div class="canvas-container">
                <div class="donation-chart-container">
                    <canvas id="donationChart"></canvas>
                </div>
                <div class="chart-container">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
        <!--<div class="comments-sidebar" id="comments-sidebar">
            <h2>التعليقات</h2>
            <div class="comment">
                <h4>Anna</h4>
                <p>12:03 PM</p>
                <p>Ut in a labor</p>
                <span class="reply">Reply</span>
            </div>
            <div class="comment">
                <h4>Anna</h4>
                <p>12:03 PM</p>
                <p>Ut in a labor</p>
                <span class="reply">Reply</span>
            </div>
            <div class="comment">
                <h4>Anna</h4>
                <p>12:03 PM</p>
                <p>Ut in a labor</p>
                <span class="reply">Reply</span>
            </div>
        </div>-->
        <div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.getElementById('show-comments').addEventListener('click', function() {
            var commentsSidebar = document.getElementById('comments-sidebar');
            commentsSidebar.classList.toggle('visible');
        });

        const ctxBar = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو'],
                datasets: [{
                    label: 'المستخدمين',
                    data: [12, 19, 3, 5, 2, 3, 7],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }, {
                    label: 'الجهودات',
                    data: [8, 10, 5, 2, 20, 30, 45],
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const ctxPie = document.getElementById('donationChart').getContext('2d');
        const donationChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['الفئة1', 'الفئة2', 'الفئة3'],
                datasets: [{
                    label: 'التبرعات',
                    data: [10, 20, 30],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
</body>
</html>
