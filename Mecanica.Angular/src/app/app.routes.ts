import { Routes } from '@angular/router';

import { DashboardLayout } from './layout/dashboard-layout/dashboard-layout';
import { EmpleadosComponent } from './models/empleado/empleados.component';
import { ServiciosComponent } from './models/servicio/servicio';
import { Vehiculo } from './models/vehiculo/vehiculo';
import { Usuario } from './models/usuario/usuario';
import { servicioResolver } from './resolvers/servicio.resolver';
import { empleadoResolver } from './resolvers/empleado.resolver';


export const routes: Routes = [
    { path: '', redirectTo: 'servicios', pathMatch: 'full' },
    {
        path: '',
        component: DashboardLayout,
        children: [
            { 
                path: 'servicios', 
                component: ServiciosComponent,
                resolve: {
                    serviciosData: servicioResolver 
                } 
            },
            { path: 'usuarios', component: Usuario },
            { path: 'vehiculos', component: Vehiculo },
            { 
                path: 'empleados', 
                component: EmpleadosComponent,
                resolve: {
                    empleadosData: empleadoResolver
                } 
            },

        ]
    },
];