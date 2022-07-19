import { Inertia } from '@inertiajs/inertia';
import moment from 'moment-timezone';
import { computed } from 'vue';

moment.tz.setDefault('Etc/UTC');

const mergePersonObject = function (item) {
    let { id, ...person } = item.person || {};
    Object.assign(item, person);   //Bring properties from nested 'person' object into top level
    delete item.person;
    return item;
}

const parseSubstitutes = function (data) {
    return computed(() => {
        return data.map(row => {
            let isSub = false,
                inException = false;

            let routeId = row.id;

            let driver = {};
            let exception = {};
            let substitute;

            if (row.drivers.length > 0) {
                driver = row.drivers[0];

                if (driver.exceptions.length > 0) {
                    inException = true;
                    exception = driver.exceptions[0];

                    if (typeof exception.substitutes !== 'undefined' && exception.substitutes.length > 0) {
                        // substitute = exception.substitutes[0];
                        substitute = exception.substitutes.find(val => val.substitute.route_id === routeId);

                        if (substitute) {
                            driver = substitute;
                            isSub = true;
                        }




                    }

                }
            }

            return {
                driver,
                exception,
                isSub,
                inException,
                routeId: row.id,
                routeName: row.name,
                ...row
            };
        });
    });
};

const DateAdapter = {
    make: function (date) {
        // return moment(date).tz('Etc/UTC').format(momentFormatString);
        return moment(date).tz('Etc/UTC').toISOString();
    }
};

const back = function() {
    Inertia.visit(window.history.back());
};

const momentFormatString = "MMDDYYYY";

// export { mergePersonObject, momentFormatString };
export { mergePersonObject, parseSubstitutes, DateAdapter, back };