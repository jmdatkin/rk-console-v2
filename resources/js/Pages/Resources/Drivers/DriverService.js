import axios from "axios";

const get = function () {
    return axios.get('/driver/data');
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

export default { get, destroy, store, edit };