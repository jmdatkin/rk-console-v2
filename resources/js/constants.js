import { Inertia } from "@inertiajs/inertia";

const WEEKDAYS = {
    'mon': 'Monday',
    'tue': 'Tuesday',
    'wed': 'Wednesday',
    'thu': 'Thursday',
    'fri': 'Friday',
    'sat': 'Saturday',
    'sun': 'Sunday'
};

const menuItems = [
    {
        label: 'Dashboard',
        command: () => Inertia.visit(route('dashboard'))
    },
    {
        label: 'Reports',
        icon: 'pi pi-fw pi-database',
        items: [
            {
                label: 'Outreach Report',
                command: () => Inertia.visit(route('report.outreach'))
            },
            {
                label: 'Meals Report',
                command: () => Inertia.visit(route('report.meals'))
            },
            {
                label: 'Totals',
                command: () => Inertia.visit(route('report.totals'))
            },
        ]
    },
    {
        label: 'Resources',
        icon: 'pi pi-fw pi-database',
        items: [
            {
                label: 'Personnel',
                icon: 'pi pi-fw pi-user',
                command: () => Inertia.visit(route('datatables.personnel'))
            },
            {
                label: 'Recipients',
                icon: 'pi pi-fw pi-box',
                command: () => Inertia.visit(route('datatables.recipients'))

            },
            {
                label: 'Drivers',
                icon: 'pi pi-fw pi-car',
                command: () => Inertia.visit(route('datatables.drivers'))
            },
            {
                label: 'Routes',
                icon: 'pi pi-fw pi-map',
                command: () => Inertia.visit(route('datatables.routes'))
            },
            {
                label: 'Agencies',
                icon: 'pi pi-fw pi-building',
                command: () => Inertia.visit(route('datatables.agencies'))
            }
        ]
    },
    {
        label: 'Views',
        icon: 'pi pi-fw pi-database',
        items: [
            {
                label: 'Pending Jobs',
                command: () => Inertia.visit(route('pendingjobs'))
            },
            {
                label: 'Audits',
                command: () => Inertia.visit(route('audits'))
            },
            {
                label: 'Recipients by Route',
                command: () => Inertia.visit(route('recipientsbyroute'))
            },
            {
                label: 'Drivers by Route',
                command: () => Inertia.visit(route('driversbyroute'))
            },
            {
                label: 'Schedule Exceptions',
                command: () => Inertia.visit(route('exception.index'))
            },
        ]
    },
    {
        label: 'Settings',
        icon: 'pi pi-fw pi-cog',
        items: [
            {
                label: 'Application Settings',
                icon: 'pi pi-fw pi-cog',
                command: () => Inertia.visit(route('settings'))
            },
            {
                label: 'User Settings',
                icon: 'pi pi-fw pi-user',
                command: () => Inertia.visit(route('settings.user'))
            },
        ]
    },
    {
        label: 'Profile',
        icon: 'pi pi-fw pi-user',
        items: [
            {
                label: 'Log Out',
                command: () => Inertia.post(route('logout'))
            },
            {
                label: 'User Profile',
                command: () => Inertia.visit(route('profile'))
            },
        ]
    }
];

export { WEEKDAYS, menuItems };