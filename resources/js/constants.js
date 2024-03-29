import { Inertia } from "@inertiajs/inertia";
import moment from "moment";

const WEEKDAYS = moment.weekdays();

const adminMenuItems = [
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
                label: 'Totals Report',
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
                label: 'Jobs',
                command: () => Inertia.visit(route('jobs'))
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
    },
    {
        label: 'Links',
        icon: 'pi pi-fw pi-paper',
        items: [
            {
                label: 'Docs',
                command: () => Inertia.visit(route('docs'))
            }
        ]
    }
];

const driverMenuItems = [
    {
        label: 'Dashboard',
        command: () => Inertia.visit(route('dashboard'))
    },
    {
        label: 'Views',
        icon: 'pi pi-fw pi-database',
        items: [
        ]
    },
    {
        label: 'User Settings',
        icon: 'pi pi-fw pi-user',
        command: () => Inertia.visit(route('settings.user'))
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
    },
];

export { WEEKDAYS, adminMenuItems, driverMenuItems };