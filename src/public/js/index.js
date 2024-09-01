// 初期設定: 勤務開始ボタンのみ有効
document.querySelector('.button__clock-in').style.color = 'black';
document.querySelector('.button__clock-in').disabled = false;
document.querySelector('.button__clock-out').disabled = true;
document.querySelector('.button__break-start').disabled = true;
document.querySelector('.button__break-end').disabled = true;

// 勤務開始ボタンがクリックされたとき
document.querySelector('.button__clock-in').addEventListener('click', function() {
    this.style.color = 'gray';
    this.disabled = true;

    const clockOutButton = document.querySelector('.button__clock-out');
    const breakStartButton = document.querySelector('.button__break-start');

    clockOutButton.style.color = 'black';
    clockOutButton.disabled = false;

    breakStartButton.style.color = 'black';
    breakStartButton.disabled = false;
});

// 勤務終了ボタンがクリックされたとき
document.querySelector('.button__clock-out').addEventListener('click', function() {
    this.style.color = 'gray';
    this.disabled = true;

    document.querySelector('.button__clock-in').style.color = 'gray';
    document.querySelector('.button__clock-in').disabled = true;

    document.querySelector('.button__break-start').style.color = 'gray';
    document.querySelector('.button__break-start').disabled = true;

    document.querySelector('.button__break-end').style.color = 'gray';
    document.querySelector('.button__break-end').disabled = true;
});

// 休憩開始ボタンがクリックされたとき
document.querySelector('.button__break-start').addEventListener('click', function() {
    this.style.color = 'gray';
    this.disabled = true;

    const breakEndButton = document.querySelector('.button__break-end');

    breakEndButton.style.color = 'black';
    breakEndButton.disabled = false;
});

// 休憩終了ボタンがクリックされたとき
document.querySelector('.button__break-end').addEventListener('click', function() {
    this.style.color = 'gray';
    this.disabled = true;

    const clockOutButton = document.querySelector('.button__clock-out');
    const breakStartButton = document.querySelector('.button__break-start');

    clockOutButton.style.color = 'black';
    clockOutButton.disabled = false;

    breakStartButton.style.color = 'black';
    breakStartButton.disabled = false;
});
