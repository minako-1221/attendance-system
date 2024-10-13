document.addEventListener('DOMContentLoaded', function () {
    const dateElement = document.getElementById('current-date');
    let currentDate = new Date(dateElement.textContent);

    const cache = {};

    // 前日ボタン
    document.getElementById('prev-date').addEventListener('click', function () {
        currentDate.setDate(currentDate.getDate() - 1);
        updateDate();
    });

    // 翌日ボタン
    document.getElementById('next-date').addEventListener('click', function () {
        currentDate.setDate(currentDate.getDate() + 1);
        updateDate();
    });

    // 日付を更新する関数
    function updateDate(dayChange) {

        currentDate.setDate(currentDate.getDate() + dayChange);

        const year = currentDate.getFullYear();
        const month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
        const day = ('0' + currentDate.getDate()).slice(-2);
        const formattedDate = `${year}-${month}-${day}`;

        dateElement.textContent = formattedDate;

        if (cache[formattedDate]) {
            document.querySelector('.attendance-table').innerHTML = cache[formattedDate];
        } else {
            document.querySelector('.attendance-table').innerHTML = '<p>Loading...</p>';

            fetch(`/attendance`)
            .then(response => response.text())
            .then(html => {
                cache[formattedDate] = html;
                document.querySelector('.attendance__content').innerHTML = html;
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                document.querySelector('.attendance__content').innerHTML = '<p>Error loading data.</p>';
            });
        }

    };
});
