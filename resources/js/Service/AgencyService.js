
import axios from "axios";

const get = function () {
    // return axios.get('/agency/data');
    return axios.get(route('datatables.agencies.data'));
};

const store = function (data) {
    return axios.post('/agency/store', data);
};

const destroy = function (ids) {
    return axios.post('/agency/destroy', { ids });
};

const edit = function (id, data) {
    return axios.patch(`/agency/${id}/update`, data);
};

export default { get, destroy, store, edit };