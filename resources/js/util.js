import moment from 'moment';

const mergePersonObject = function (item) {
    let { id, ...person } = item.person || {};
    Object.assign(item, person);   //Bring properties from nested 'person' object into top level
    delete item.person;
    return item;
}

const DateAdapter = {
    make: function(date) {
        return moment(date).format(momentFormatString);
    }
};

const momentFormatString = "MMDDYYYY";

// export { mergePersonObject, momentFormatString };
export { mergePersonObject, DateAdapter };