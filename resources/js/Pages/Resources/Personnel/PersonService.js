import axios from "axios";

const get = function () {
    // return axios.get('/person/data');
    return axios.get(route('datatables.personnel.data'));
};

const store = function(data) {
    return axios.post('/person/store', data);
};

const destroy = function (ids) {
    return axios.post('/person/destroy', { ids });
};

const edit = function(id, data) {
    return axios.patch(`/person/${id}/update`, data);
};

export default { get, destroy, store, edit };