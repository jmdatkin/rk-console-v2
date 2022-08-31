import axios from "axios";

const modifyDriverAssignment = function(driver_id, route_id, weekday) {
    return axios.post(route('assignment.driver.assign', { driver_id, route_id, weekday})); 
};

const reorderRecipientAssignment = function(route_id, recipient_id, weekday, new_index) {
    return axios.post(route('assignment.recipient.reorder'),
    { route_id, recipient_id, weekday, new_index});
};


export default { modifyDriverAssignment, reorderRecipientAssignment };