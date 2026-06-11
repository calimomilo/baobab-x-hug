
export const formatTime = (time: string) => {
    const times = time.split(':');

    return `${times[0]}h${times[1]}`;
}

export const formatDate = (date: string, start?: string, end?: string) => {
    const rawDate = new Date(date);

    let month;

    switch (rawDate.getMonth()) {
        case 1: month = 'jan'; break;
        case 2: month = 'fev'; break;
        case 3: month = 'mar'; break;
        case 4: month = 'avr'; break;
        case 5: month = 'mai'; break;
        case 6: month = 'juin'; break;
        case 7: month = 'jui'; break;
        case 8: month = 'août'; break;
        case 9: month = 'sep'; break;
        case 10: month = 'oct'; break;
        case 11: month = 'nov'; break;
        case 12: month = 'dec'; break;
    }

    if (!start || !end) {
        return `${rawDate.getDate()} ${month} ${rawDate.getFullYear()}`;
    } else {
        return `${rawDate.getDate()} ${month} ${rawDate.getFullYear()}, ${formatTime(start)}–${formatTime(end)}`;
    }
}