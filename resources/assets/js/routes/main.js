import Vue from 'vue'
import Router from 'vue-router'
import Home from '../views/Admin/Home.vue'

import Projects from '../views/Admin/Projects/List.vue'
import ProjectsAdd from '../views/Admin/Projects/Add.vue'
import ProjectsEdit from '../views/Admin/Projects/Edit.vue'
import ProjectsProsessesAdd from '../views/Admin/Projects/AddProcess.vue'
import ProjectsProsessesEdit from '../views/Admin/Projects/EditProcess.vue'

import Processes from '../views/Admin/Processes/List.vue'

import Orders from '../views/Admin/Orders/List.vue'
import OrdersAdd from '../views/Admin/Orders/Add.vue'
import OrdersEdit from '../views/Admin/Orders/Edit.vue'
import OrdersShipmentsAdd from '../views/Admin/Orders/AddShipment.vue'
import OrdersShipmentsEdit from '../views/Admin/Orders/EditShipment.vue'

import Countries from '../views/Admin/Countries/List.vue'
import CountriesAdd from '../views/Admin/Countries/Add.vue'
import CountriesEdit from '../views/Admin/Countries/Edit.vue'

import Cities from '../views/Admin/Cities/List.vue'
import CitiesAdd from '../views/Admin/Cities/Add.vue'
import CitiesEdit from '../views/Admin/Cities/Edit.vue'

import Locations from '../views/Admin/Locations/List.vue'
import LocationsAdd from '../views/Admin/Locations/Add.vue'
import LocationsEdit from '../views/Admin/Locations/Edit.vue'
import LocationsProsessesAdd from '../views/Admin/Locations/AddProcess.vue'
import LocationsProsessesEdit from '../views/Admin/Locations/EditProcess.vue'

import Vehicles from '../views/Admin/Vehicles/List.vue'
import VehiclesAdd from '../views/Admin/Vehicles/Add.vue'
import VehiclesEdit from '../views/Admin/Vehicles/Edit.vue'

import Users from '../views/Admin/Users/List.vue'
import UsersAdd from '../views/Admin/Users/Add.vue'
import UsersEdit from '../views/Admin/Users/Edit.vue'

import Roles from '../views/Admin/Roles/List.vue'
import RolesAdd from '../views/Admin/Roles/Add.vue'
import RolesEdit from '../views/Admin/Roles/Edit.vue'

import Permissions from '../views/Admin/Permissions/List.vue'
import PermissionsEdit from '../views/Admin/Permissions/Edit.vue'
import Permissionsdd from '../views/Admin/Permissions/Add.vue'

import Sizes from '../views/Admin/Sizes/List.vue'
import SizesAdd from '../views/Admin/Sizes/Add.vue'
import SizesEdit from '../views/Admin/Sizes/Edit.vue'

import Weights from '../views/Admin/Weights/List.vue'
import WeightsAdd from '../views/Admin/Weights/Add.vue'
import WeightsEdit from '../views/Admin/Weights/Edit.vue'

import Grades from '../views/Admin/Grades/List.vue'
import GradesAdd from '../views/Admin/Grades/Add.vue'
import GradesEdit from '../views/Admin/Grades/Edit.vue'

import Aquatics from '../views/Admin/Aquatics/List.vue'
import AquaticsAdd from '../views/Admin/Aquatics/Add.vue'
import AquaticsEdit from '../views/Admin/Aquatics/Edit.vue'

import Merchandises from '../views/Admin/Merchandises/List.vue'
import MerchandisesAdd from '../views/Admin/Merchandises/Add.vue'
import MerchandisesEdit from '../views/Admin/Merchandises/Edit.vue'
import MerchandisesProsessesAdd from '../views/Admin/Merchandises/AddProcess.vue'
import MerchandisesProsessesEdit from '../views/Admin/Merchandises/EditProcess.vue'

import Packages from '../views/Admin/Packages/List.vue'
import PackagesAdd from '../views/Admin/Packages/Add.vue'
import PackagesEdit from '../views/Admin/Packages/Edit.vue'

import Login from '../views/Auth/Login.vue'

Vue.use(Router)

export default new Router({
    mode: 'history',
    scrollBehavior (to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition
        } else {
            return { x: 0, y: 0 }
        }
    },
    routes: [

        {
            path: '/',
            name: 'home',
            component: Home,
            meta: {
                auth: true
            }
        },

        {
            path: '/login',
            name: 'login',
            component: Login,
            meta: {
                auth: false
            }
        },


        {
            path: '/projects',
            name: 'projects',
            component: Projects,
            meta: {
                auth: true
            }
        },

        {
            path: '/projects/add',
            name: 'projects.add',
            component: ProjectsAdd,
            meta: {
                auth: true
            }
        },

        {
            path: '/projects/:hashid',
            name: 'projects.edit',
            component: ProjectsEdit,
            meta: {
                auth: true
            }
        },

        {
            path: '/projects/:projectHashid/processes/add',
            name: 'projects.processes.add',
            component: ProjectsProsessesAdd,
            meta: {
                auth: true
            }
        },

        {
            path: '/projects/:projectHashid/processes/:processHashid',
            name: 'projects.processes.edit',
            component: ProjectsProsessesEdit,
            meta: {
                auth: true
            }
        },


        {
            path: '/processes',
            name: 'processes',
            component: Processes,
            meta: {
                auth: true
            }
        },


        {
            path: '/orders',
            name: 'orders',
            component: Orders,
            meta: {
                auth: true
            }
        },

        {
            path: '/orders/add',
            name: 'orders.add',
            component: OrdersAdd,
            meta: {
                auth: true
            }
        },

        {
            path: '/orders/:hashid',
            name: 'orders.edit',
            component: OrdersEdit,
            meta: {
                auth: true
            }
        },

        {
            path: '/orders/:orderHashid/shipments/add',
            name: 'orders.shipments.add',
            component: OrdersShipmentsAdd,
            meta: {
                auth: true
            }
        },

        {
            path: '/orders/:orderHashid/shipments/:shipmentHashid',
            name: 'orders.shipments.edit',
            component: OrdersShipmentsEdit,
            meta: {
                auth: true
            }
        },


        {
            path: '/countries',
            name: 'countries',
            component: Countries,
            meta: {
                auth: true
            }
        },

        {
            path: '/countries/add/:hashid?',
            name: 'countries.add',
            component: CountriesAdd,
            meta: {
                auth: true
            }
        },

        {
            path: '/countries/:hashid',
            name: 'countries.edit',
            component: CountriesEdit,
            meta: {
                auth: true
            }
        },


        {
            path: '/cities',
            name: 'cities',
            component: Cities,
            meta: {
                auth: true
            }
        },

        {
            path: '/cities/add/:hashid?',
            name: 'cities.add',
            component: CitiesAdd,
            meta: {
                auth: true
            }
        },

        {
            path: '/cities/:hashid',
            name: 'cities.edit',
            component: CitiesEdit,
            meta: {
                auth: true
            }
        },


        {
            path: '/locations',
            name: 'locations',
            component: Locations,
            meta: {
                auth: true
            }
        },

        {
            path: '/locations/add/:hashid?',
            name: 'locations.add',
            component: LocationsAdd,
            meta: {
                auth: true
            }
        },

        {
            path: '/locations/:hashid',
            name: 'locations.edit',
            component: LocationsEdit,
            meta: {
                auth: true
            }
        },

        {
            path: '/locations/:locationHashid/processes/add',
            name: 'locations.processes.add',
            component: LocationsProsessesAdd,
            meta: {
                auth: true
            }
        },

        {
            path: '/locations/:locationHashid/processes/:processHashid',
            name: 'locations.processes.edit',
            component: LocationsProsessesEdit,
            meta: {
                auth: true
            }
        },

        {
            path: '/vehicles',
            name: 'vehicles',
            component: Vehicles,
            meta: {
                auth: true
            }
        },

        {
            path: '/vehicles/add/:hashid?',
            name: 'vehicles.add',
            component: VehiclesAdd,
            meta: {
                auth: true
            }
        },

        {
            path: '/vehicles/:hashid',
            name: 'vehicles.edit',
            component: VehiclesEdit,
            meta: {
                auth: true
            }
        },


        {
            path: '/sizes',
            name: 'sizes',
            component: Sizes,
            meta: {
                auth: true
            }
        },

        {
            path: '/sizes/add/:hashid?',
            name: 'sizes.add',
            component: SizesAdd,
            meta: {
                auth: true
            }
        },

        {
            path: '/sizes/:hashid',
            name: 'sizes.edit',
            component: SizesEdit,
            meta: {
                auth: true
            }
        },


        {
            path: '/weights',
            name: 'weights',
            component: Weights,
            meta: {
                auth: true
            }
        },

        {
            path: '/weights/add/:hashid?',
            name: 'weights.add',
            component: WeightsAdd,
            meta: {
                auth: true
            }
        },

        {
            path: '/weights/:hashid',
            name: 'weights.edit',
            component: WeightsEdit,
            meta: {
                auth: true
            }
        },


        {
            path: '/grades',
            name: 'grades',
            component: Grades,
            meta: {
                auth: true
            }
        },

        {
            path: '/grades/add/:hashid?',
            name: 'grades.add',
            component: GradesAdd,
            meta: {
                auth: true
            }
        },

        {
            path: '/grades/:hashid',
            name: 'grades.edit',
            component: GradesEdit,
            meta: {
                auth: true
            }
        },


        {
            path: '/aquatics',
            name: 'aquatics',
            component: Aquatics,
            meta: {
                auth: true
            }
        },

        {
            path: '/aquatics/add/:hashid?',
            name: 'aquatics.add',
            component: AquaticsAdd,
            meta: {
                auth: true
            }
        },

        {
            path: '/aquatics/:hashid',
            name: 'aquatics.edit',
            component: AquaticsEdit,
            meta: {
                auth: true
            }
        },


        {
            path: '/merchandises',
            name: 'merchandises',
            component: Merchandises,
            meta: {
                auth: true
            }
        },

        {
            path: '/merchandises/add',
            name: 'merchandises.add',
            component: MerchandisesAdd,
            meta: {
                auth: true
            }
        },

        {
            path: '/merchandises/:hashid',
            name: 'merchandises.edit',
            component: MerchandisesEdit,
            meta: {
                auth: true
            }
        },

        {
            path: '/merchandises/:merchandiseHashid/processes/add',
            name: 'merchandises.processes.add',
            component: MerchandisesProsessesAdd,
            meta: {
                auth: true
            }
        },

        {
            path: '/merchandises/:merchandiseHashid/processes/:processHashid',
            name: 'merchandises.processes.edit',
            component: MerchandisesProsessesEdit,
            meta: {
                auth: true
            }
        },


        {
            path: '/packages',
            name: 'packages',
            component: Packages,
            meta: {
                auth: true
            }
        },

        {
            path: '/packages/add/:hashid?',
            name: 'packages.add',
            component: PackagesAdd,
            meta: {
                auth: true
            }
        },

        {
            path: '/packages/:hashid',
            name: 'packages.edit',
            component: PackagesEdit,
            meta: {
                auth: true
            }
        },


        {
            path: '/users',
            name: 'users',
            component: Users,
            meta: {
                auth: true
            }
        },

        {
            path: '/users/add/:hashid?',
            name: 'users.add',
            component: UsersAdd,
            meta: {
                auth: true
            }
        },

        {
            path: '/users/:hashid',
            name: 'users.edit',
            component: UsersEdit,
            meta: {
                auth: true
            }
        },

        {
            path: '/roles',
            name: 'roles',
            component: Roles,
            meta: {
                auth: true
            }
        },
        {
            path: '/roles/add/:hashid?',
            name: 'roles.add',
            component: RolesAdd,
            meta: {
                auth: true
            }
        },
        {
            path: '/roles/:hashid?',
            name: 'roles.edit',
            component: RolesEdit,
            meta: {
                auth: true
            }
        },
        
    ]
})