import { ref, computed } from "vue";
import { toastBus } from "../../app";

const useCRUD = function (service) {
    const data = ref([]);
    const dataLoaded = ref(false);
    const selected = ref();

    const get = function () {
        dataLoaded.value = false;
        service.get().then(res => {
            data.value = res.data;
            dataLoaded.value = true;
        }).catch(err => console.error(err));
    };

    const store = function (form) {
        dataLoaded.value = false;
        service.store(form)
            .then(
                res => {
                    get();
                    toastBus.emit('add',{ severity: 'success', summary: 'Success', detail: res.data, life: 3000 });
                },
                res => {
                    toastBus.emit('add',{ severity: 'error', summary: 'Error', detail: res, life: 3000 });
                },
            );
    };

    const update = function (form) {
        let id = form.id;
        dataLoaded.value = false;
        service.edit(id, form)
            .then(
                res => {
                    selected.value = [];
                    get();
                    toastBus.emit('add',{ severity: 'success', summary: 'Success', detail: res.data, life: 3000 });
                },
                res => {
                    toastBus.emit('add',{ severity: 'error', summary: 'Error', detail: res, life: 3000 });
                },
            );
    };

    const destroy = function (ids) {
        dataLoaded.value = false;
        service.destroy(ids)
            .then(
                res => {
                    selected.value = [];
                    get();
                    toastBus.emit('add',{ severity: 'success', summary: 'Success', detail: res.data, life: 3000 });
                },
                res => {
                    toastBus.emit('add',{severity: 'error', summary: 'Error', detail: res, life: 3000 });
                });
    };

    return {
        data, dataLoaded, selected,
        CRUD: {
            get,
            store,
            update,
            destroy
        }
    };
};

const usePending = function(pendingJobs, tableData) {
    console.log(tableData);
    return computed(() => {
    let updates = pendingJobs.filter(job => job.job_name.indexOf('update') > 0);
    const newData = _.cloneDeep(tableData.value);
    updates.forEach(update => {
        let idx = newData.findIndex(row => row.id == update.payload[0]);
        console.log(idx);
        if (idx < 0) return;
        let payload = update.payload[1];
        let row = newData[idx];
        Object.assign(row, payload);
        newData[idx] = {pending: true, ...row};
    });
    return newData;
    });
};

const fullName = props => computed(() => `${props.firstName} ${props.lastName}`);

export { useCRUD, usePending, fullName };