import axios from "axios";

const get = function () {
    // return axios.get('/recipient/data');
    return axios.get(route('datatables.recipients.data'));
};

const store = function (data) {
    return axios.post('/recipient/store', data);
};

const destroy = function (ids) {
    return axios.post('/recipient/destroy', { ids });
};

const edit = function (id, data) {
    return axios.patch(`/recipient/${id}/update`, data);
};

export default { get, destroy, store, edit };