<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Form</title>
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
    max-width: 900px;
    margin: 20px auto;
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
    margin-bottom: 20px;
}

.section {
    margin-bottom: 30px;
}

.section h3 {
    margin-bottom: 10px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.row {
    display: flex;
    justify-content: space-between;
    gap: 20px;
}

.row .form-group {
    flex: 1;
}

.submit-btn {
    background-color: #00bcd4;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
}

.submit-btn:hover {
    background-color: #0097a7;
}
</style>
<body>
    <div class="container">
        <h2>لوحة التحكم / تفعيل حالة الطوارئ</h2>
        <form>
            <div class="section">
                <h3>تفاصيل حالة الطوارئ</h3>
                <div class="form-group">
                    <label for="emergency-name">اسم حالة الطوارئ</label>
                    <input type="text" id="emergency-name" placeholder="اسم حالة الطوارئ">
                </div>
                <div class="form-group">
                    <label for="date">التاريخ</label>
                    <input type="date" id="date">
                </div>
            </div>
            <div class="section">
                <h3>احتياجات حالة الطوارئ</h3>
                <div class="row">
                    <div class="form-group">
                        <label for="need1">احتياج 1</label>
                        <input type="text" id="need1" placeholder="احتياج 1">
                    </div>
                    <div class="form-group">
                        <label for="need2">احتياج 2</label>
                        <input type="text" id="need2" placeholder="احتياج 2">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label for="need3">احتياج 3</label>
                        <input type="text" id="need3" placeholder="احتياج 3">
                    </div>
                    <div class="form-group">
                        <label for="need4">احتياج 4</label>
                        <input type="text" id="need4" placeholder="احتياج 4">
                    </div>
                </div>
            </div>
            <div class="section">
                <h3>الدعم</h3>
                <div class="row">
                    <div class="form-group">
                        <label for="support-type">نوع الدعم</label>
                        <select id="support-type">
                            <option value="">اختر نوع الدعم</option>
                            <option value="type1">نوع 1</option>
                            <option value="type2">نوع 2</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="support-amount">كمية الدعم</label>
                        <input type="text" id="support-amount" placeholder="كمية الدعم">
                    </div>
                </div>
            </div>
            <button type="submit" class="submit-btn">تفعيل</button>
        </form>
    </div>
</body>
</html>
