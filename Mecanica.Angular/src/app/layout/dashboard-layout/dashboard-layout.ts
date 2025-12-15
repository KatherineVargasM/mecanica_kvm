import { Component } from '@angular/core'
import { Router, RouterLink, RouterOutlet } from '@angular/router'; 

@Component({
  selector: 'app-dashboard-layout',
  imports: [RouterLink, RouterOutlet], 
  templateUrl: './dashboard-layout.html',
  styleUrl: './dashboard-layout.css',
})
export class DashboardLayout {

    constructor(private router: Router) { }

    private routeTitles: { [key: string]: string } = {
        'servicios': 'Gestión de Servicios',
        'usuarios': 'Gestión de Usuarios',
        'vehiculos': 'Gestión de Vehículos',
        'empleados': 'Gestión de Empleados',
        'perfil': 'Mi Perfil'
    };

    getCurrentRouteTitle(): string {
        const url = this.router.url.split('?')[0]; 
        const pathSegment = url.split('/').pop() || ''; 
        return this.routeTitles[pathSegment] || 'Panel de Control';
    }
}