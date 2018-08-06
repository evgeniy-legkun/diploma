import VueRouter from 'vue-router';

import UsersComponent from '../views/user/Users';
import UsersListComponent from '../views/user/UsersList';
import UserCreateComponent from '../views/user/UserCreate';
import UserEditComponent from '../views/user/UserEdit';

import DashboardComponent from '../views/dashboard/Dashborad';
import StatisticsComponent from '../views/statistics/Statistics';
import TransportationComponent from '../views/transportation/Transportation';
import WarehouseComponent from '../views/warehouse/Warehouses';


const router = new VueRouter(
    {
        routes: [
            { path: '/', component: DashboardComponent},
            { path: '/statistics', component: StatisticsComponent},
            { path: '/transportation', component: TransportationComponent},
            { path: '/warehouse', component: WarehouseComponent},
            {
                path: '/user',
                name: 'users',
                component: UsersComponent,
                children: [
                    { path: '/', name: 'users-list', component: UsersListComponent },
                    { path: 'add', name: 'user-create', component: UserCreateComponent },
                    { path: 'edit', name: 'user-edit', component: UserEditComponent },
                ]
            }
        ]
    }
);

export default router;

