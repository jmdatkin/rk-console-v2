import axios from 'axios';

const createSub = function(driver_id, route_id, sub_driver_id, date) {
    return axios.post(route('substitute.store'), { driver_id, route_id, sub_driver_id, date})
}

export default { createSub };