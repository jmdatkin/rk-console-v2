import axios from "axios";

const get = function () {
    // return axios.get('/driver/data');
    return axios.get(route('datatables.drivers.data'));
};

const store = function(data) {
    return axios.post('/driver/store', data);
};

const destroy = function (ids) {
    return axios.post('/driver/destroy', { ids });
};

const edit = function(id, data) {
    return axios.patch(`/driver/${id}/update`, data);
};

const importCsv = function(data) {
    return axios.post('/driver/import', { data });
};

export default { get, destroy, store, edit, importCsv };