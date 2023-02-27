export const incrementDate = (currentDate, day) => {
    let given_date = new Date(currentDate);
    let next_date = new Date(given_date);
    next_date.setDate(given_date.getDate() + day);
    return next_date.toLocaleDateString();
}

export const dateAndTimeFormat = (date, return_type) => {
    if (return_type === 'date') {
        if (!date) {
            return null;
        }
        let current_date = new Date(date);
        let month = '' + (current_date.getMonth() + 1);
        let day = '' + current_date.getDate();
        let year = current_date.getFullYear();

        if (month.length < 2) {
            month = '0' + month;
        }
        if (day.length < 2) {
            day = '0' + day;
        }

        return [year, month, day].join('-');
    }
}

export const allTimes = () => {
    let all_times = [];
    for (let i = 0; i < 24; i++) {
        let minute = 0;
        for (let min = 0; min < 12; min++) {
            let temp_hr = i;
            let temp_min = minute;
            if (String(temp_hr).length === 1) {
                temp_hr = '0' + temp_hr;
            }
            if (String(temp_min).length === 1) {
                temp_min = '0' + temp_min;
            }
            all_times.push(temp_hr + ':' + temp_min);
            minute += 5;
        }
    }
    return all_times;
}
