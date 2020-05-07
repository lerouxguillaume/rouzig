import moment from 'moment';

export const RelativeDate = (date) => {
    return moment(date).calendar();
}

export function formatErrorCode(code) {
    return 'error.input.' + code;
}