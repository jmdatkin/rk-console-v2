import axios from "axios";

const get = function () {
    // return axios.get('/person/data');
    return axios.get(route('datatables.personnel.data'));
};

const store = function(data) {
    return axios.post('/personnel/store', data);
};

const destroy = function (ids) {
    return axios.post('/personnel/destroy', { ids });
};

const edit = function(id, data) {
    return axios.patch(`/personnel/${id}/update`, data);
};

const importCsv = function(data) {
    return axios.post('/personnel/import', { data });
};

export default { get, destroy, store, edit, importCsv };