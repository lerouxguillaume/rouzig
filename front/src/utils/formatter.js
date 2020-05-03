import moment from 'moment';

export const RelativeDate = (date) => {
    return moment(date).calendar();
}