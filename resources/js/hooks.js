import { Inertia } from "@inertiajs/inertia";
import { ref, computed } from "vue";
import { toastBus } from "./app";

const useBreadcrumb = (function () {
    // let items = {};

    // const get = function () {
    //     // return {
    //     //     // home: { to: '/' },
    //     //     items
    //     // };
    //     return items;
    // };
    const items = ref([]);

    const append = function (item) {
        console.log('calling append');
        items.value.unshift(item);
    };

    return function () {
        return { items, append }
    };
})();

// Hook to reduce code reusage when fetching ajax data
const useData = function (url, params) {
    const data = ref([]);
    const dataLoaded = ref(false);

    const getData = function () {
        dataLoaded.value = false;
        let req_params;

        if (typeof params === 'object') {
            req_params = params;
        } else if (typeof params === 'function') {
            req_params = params.apply(this, arguments);
        }

        axios.get(url, req_params).then(
            (res) => {
                data.value = res.data;
                dataLoaded.value = true;
            },
            () => {
            }
        )
    };

    return { data, dataLoaded, getData };
};

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
                    toastBus.emit('add', { severity: 'success', summary: 'Success', detail: res.data, life: 3000 });
                },
                res => {
                    toastBus.emit('add', { severity: 'error', summary: 'Error', detail: res, life: 3000 });
                },
            );
    };

    const update = function (id, data) {
        dataLoaded.value = false;
        service.edit(id, data)
            .then(
                res => {
                    selected.value = [];
                    get();
                    toastBus.emit('add', { severity: 'success', summary: 'Success', detail: res.data, life: 3000 });
                },
                res => {
                    toastBus.emit('add', { severity: 'error', summary: 'Error', detail: res, life: 3000 });
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
                    toastBus.emit('add', { severity: 'success', summary: 'Success', detail: res.data, life: 3000 });
                },
                res => {
                    toastBus.emit('add', { severity: 'error', summary: 'Error', detail: res, life: 3000 });
                });
    };

    const upload = function (files) {
        let fr = new FileReader();

        fr.readAsText(files[0]);

        fr.onload = () => {
            service.importCsv(fr.result)
                .then(
                    () => {
                        get()
                        toastBus.emit('add', { severity: 'success', summary: 'Success', detail: res.data, life: 3000 });
                    },
                    () => {
                        toastBus.emit('add', { severity: 'error', summary: 'Error', detail: res, life: 3000 });
                    }
                );

        };
    }

    return {
        data, dataLoaded, selected,
        CRUD: {
            get,
            store,
            update,
            destroy,
            upload
        }
    };
};

const usePending = function (pendingJobs, tableData) {
    return computed(() => {
        let updates = pendingJobs.filter(job => job.job_action.indexOf('update') > 0);
        const newData = _.cloneDeep(tableData.value);
        updates.forEach(update => {
            let idx = newData.findIndex(row => row.id == update.resource_id);
            console.log(idx);
            if (idx < 0) return;
            let payload = update.payload;
            let row = newData[idx];
            Object.assign(row, payload);
            newData[idx] = { pending: true, ...row };
        });
        return newData;
    });
};

const fullName = props => computed(() => `${props.firstName} ${props.lastName}`);

export {
    useCRUD,
    usePending,
    fullName,
    useData,
    useBreadcrumb
};