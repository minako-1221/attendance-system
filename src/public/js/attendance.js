document.addEventListener('DOMContentLoaded', function() {
    const dateElement = document.getElementById('current-date');
    let currentDate = new Date(dateElement.textContent);

    // 前日ボタン
    document.getElementById('prev-date').addEventListener('click', function() {
        currentDate.setDate(currentDate.getDate() - 1);
        updateDate();
    });

    // 翌日ボタン
    document.getElementById('next-date').addEventListener('click', function() {
        currentDate.setDate(currentDate.getDate() + 1);
        updateDate();
    });

    // 日付を更新する関数
    function updateDate() {
        const year = currentDate.getFullYear();
        const month = ('0' + (currentDate.getMonth() + 1)).slice(-2); // 月は0から始まるので+1
        const day = ('0' + currentDate.getDate()).slice(-2);
        dateElement.textContent = `${year}-${month}-${day}`;
    }
});
