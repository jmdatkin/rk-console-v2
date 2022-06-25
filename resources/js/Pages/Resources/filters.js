import { FilterMatchMode, FilterOperator } from 'primevue/api';

const recipientFilters = {
    'global':
    {
        value: null, matchMode: FilterMatchMode.CONTAINS
    },

    'id':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }],
    },

    'agency.name':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }],
    },

    'firstName':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }],
    },

    'lastName':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }],
    },

    'address':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }],
    },

    'email':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }],
    },

    'phoneHome':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }],
    },

    'phoneCell':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }],
    },

    'numMeals':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }],
    },

    'notes':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }],
    },
};


// Person
const personFilters = {
    'global':
    {
        value: null, matchMode: FilterMatchMode.CONTAINS
    },

    'id':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }],
    },

    'roles':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }],
    },

    'firstName':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }],
    },

    'lastName':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }],
    },

    'email':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }],
    },

    'phoneHome':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }],
    },

    'phoneCell':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }],
    },

    'notes':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }],
    },
};

const driverFilters = {
    'global':
    {
        value: null, matchMode: FilterMatchMode.CONTAINS
    },

    'id':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }],
    },

    'firstName':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }],
    },

    'lastName':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }],
    },

    'email':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }],
    },

    'phoneHome':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }],
    },

    'phoneCell':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }],
    },

    'notes':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }],
    },
};

const agencyFilters = {
    'global':
    {
        value: null, matchMode: FilterMatchMode.CONTAINS
    },

    'id':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }],
        // value: null, matchMode: FilterMatchMode.CONTAINS
    },

    'name':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }],
    },
    'notes':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }],
    },
};

const routeFilters = {
    'global':
    {
        value: null, matchMode: FilterMatchMode.CONTAINS
    },

    'id':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }],
        // value: null, matchMode: FilterMatchMode.CONTAINS
    },

    'name':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }],
    },
    'notes':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }],
    },
};

const driversByRouteFilters = {
    'global':
    {
        value: null, matchMode: FilterMatchMode.CONTAINS
    },

    'routeName':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }],
    },

    'id':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }],
    },

    'driver.person.firstName':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }],
    },

    'driver.person.lastName':
    {
        operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }],
    },
};

export {
    recipientFilters,
    personFilters,
    driverFilters,
    agencyFilters,
    routeFilters,
    driversByRouteFilters
};