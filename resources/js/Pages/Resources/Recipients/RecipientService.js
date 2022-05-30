import { Inertia } from "@inertiajs/inertia";
import axios from "axios";

const get = function () {
    return axios.get('/recipient/data');
};

const create = function() {
    return new Promise((resolve, reject) => {

    });
};

const destroy = function (ids) {
    // return new Promise((resolve, reject) => {
    //     Inertia.post('/recipient/destroy', { ids },
    //     {
    //         onSuccess: () => {
    //             resolve();
    //         },
    //         onError: () => {
    //             reject();
    //         }
    //     });
    // });
    return axios.post('/recipient/destroy', { ids });
};

const edit = function(id, data) {
    // return new Promise((resolve, reject) => {
    //    Inertia.patch(`/recipient/${id}/update`, data, {
    //     onSuccess: () => {
    //         resolve();
    //     },
    //     onError: () => {
    //         reject();
    //     }
    //    }); 
    // });
    return axios.patch(`/recipient/${id}/update`, data);
};

export default { get, destroy, edit };