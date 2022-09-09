import axios from "axios";

const get = function () {
    return axios.get(route('datatables.routes.data'));
};

const store = function (data) {
    return axios.post('/route/store', data);
};

const destroy = function (ids) {
    return axios.post('/route/destroy', { ids });
};

const edit = function (id, data) {
    return axios.patch(`/route/${id}/update`, data);
};

const importCsv = function(data) {
    return axios.post('/route/import', { data });
};

export default { get, destroy, store, edit, importCsv };