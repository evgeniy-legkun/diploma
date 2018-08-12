import VueRouter from 'vue-router';

import DashboardComponent from '../views/dashboard/Dashborad';

import UsersComponent from '../views/user/Users';
import UsersListComponent from '../views/user/UsersList';
import UserCreateComponent from '../views/user/UserCreate';
import UserEditComponent from '../views/user/UserEdit';

import TransportationComponent from '../views/transportation/Transportation';
import TransportationCarriersComponent from '../views/transportation/TransportationCarriers';
import TransportationListComponent from '../views/transportation/TransportationsList';

import WarehousesListComponent from '../views/warehouse/WarehousesList';
import WarehousesComponent from '../views/warehouse/Warehouses';
import WarehouseCreateComponent from '../views/warehouse/WarehouseCreate';
import WarehouseEditComponent from '../views/warehouse/WarehouseEdit'
import WarehouseMaterialsListComponent from '../views/warehouse/WarehouseMaterialsList';

import MaterialsListComponent from '../views/warehouse/MaterialsList';
import MaterialEditComponent from '../views/warehouse/MaterialEdit';
import MaterialCreateComponent from '../views/warehouse/MaterialCreate';

const router = new VueRouter(
    {
        routes: [

            {
                path: '/',
                component: DashboardComponent,
                name: 'dashboard'
            },

            {
                path: '/transportation',
                component: TransportationComponent,
                name: 'transportation',
                children: [
                    { path: '/', name: 'transportation-list', component: TransportationListComponent },
                    { path: '/carriers', name: 'transportation-carriers', component: TransportationCarriersComponent }
                ]

            },

            {
                path: '/warehouse',
                name:'warehouses',
                component: WarehousesComponent,
                children: [
                    { path: '/', name: 'warehouses-list', component: WarehousesListComponent },
                    { path: 'warehouse-create', name:'warehouse-create', component: WarehouseCreateComponent},
                    { path: 'warehouse-edit', name:'warehouse-edit', component: WarehouseEditComponent},
                    { path: 'warehouse-materials', name: 'warehouse-materials', component: WarehouseMaterialsListComponent },
                    { path: 'materials', name:'materials-list', component: MaterialsListComponent },
                    { path: 'material-create', name:'material-create', component: MaterialCreateComponent },
                    { path: 'material-edit', name:'material-edit', component: MaterialEditComponent },
                ]
            },

            {
                path: '/user',
                name: 'users',
                component: UsersComponent,
                children: [
                    { path: '/', name: 'users-list', component: UsersListComponent },
                    { path: 'add', name: 'user-create', component: UserCreateComponent },
                    { path: 'edit/:id', name: 'user-edit', component: UserEditComponent },
                ]
            }

        ]
    }
);

export default router;

