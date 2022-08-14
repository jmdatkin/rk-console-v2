import axios from "axios";

const modifyDriverAssignment = function(driver_id, route_id, weekday) {
    return axios.post(route('assignment.driver.assign', { driver_id, route_id, weekday})); 
};


export default { modifyDriverAssignment };