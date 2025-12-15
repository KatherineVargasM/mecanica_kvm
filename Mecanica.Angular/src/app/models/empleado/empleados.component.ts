import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ActivatedRoute, Router } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { Empleado } from './empleado';
import { EmpleadoService } from '../../services/empleado';

@Component({
  selector: 'app-empleados',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './empleados.component.html',
  styleUrls: ['./empleados.component.css']
})
export class EmpleadosComponent implements OnInit {
    empleados: Empleado[] = [];
    isLoading: boolean = false;
    errorMessage: string | null = null;

    isModalOpen: boolean = false;
    modalTitle: string = '';

    currentEmpleado: Empleado = {
        id: 0,
        cedula: '',
        nombres: '',
        apellidos: '',
        cargo: '',
        estado: 1,
        correo: '',
        telefono: ''
    };

    constructor(
        private route: ActivatedRoute,
        private router: Router,
        private empleadoService: EmpleadoService
    ) { }

    ngOnInit(): void {
        this.loadEmpleadosFromResolver();
    }

    loadEmpleadosFromResolver(): void {
        this.isLoading = true;
        this.errorMessage = null;
        const resolvedData = this.route.snapshot.data['empleadosData'];
        if (resolvedData) {
            this.empleados = resolvedData;
        }
        this.isLoading = false;
    }

    fetchEmpleados(): void {
        this.isLoading = true;
        this.empleadoService.getEmpleados().subscribe({
            next: (data) => {
                this.empleados = data;
                this.isLoading = false;
            },
            error: (err) => {
                console.error(err);
                this.isLoading = false;
            }
        });
    }

    getNewEmpleado(): Empleado {
        return {
            id: 0,
            cedula: '',
            nombres: '',
            apellidos: '',
            cargo: '',
            estado: 1,
            correo: '',
            telefono: '',
        };
    }

    openModal(empleado?: Empleado): void {
        this.isModalOpen = true;

        if (empleado) {
            this.modalTitle = 'Editar Empleado';
            this.currentEmpleado = { ...empleado };
        } else {
            this.modalTitle = 'Nuevo Empleado';
            this.currentEmpleado = this.getNewEmpleado();
        }
    }

    closeModal(): void {
        this.isModalOpen = false;
        setTimeout(() => {
            this.currentEmpleado = this.getNewEmpleado();
        }, 200);
    }

    guardarEmpleado(): void {
        if (!this.currentEmpleado.cedula || !this.currentEmpleado.nombres || !this.currentEmpleado.cargo) {
            alert('Por favor complete los campos obligatorios (Cédula, Nombres, Apellidos, Cargo).');
            return;
        }

        this.isLoading = true;

        if (this.currentEmpleado.id && this.currentEmpleado.id !== 0) {
            this.empleadoService.putEmpleado(this.currentEmpleado.id, this.currentEmpleado).subscribe({
                next: (response) => {
                    this.isLoading = false;
                    this.closeModal();
                    alert('Se ha editado exitosamente');
                    this.fetchEmpleados();
                },
                error: (err) => {
                    console.error(err);
                    alert('Error al guardar. Revisa la consola.');
                    this.isLoading = false;
                }
            });
        } else {
            this.empleadoService.postEmpleado(this.currentEmpleado).subscribe({
                next: (response) => {
                    this.isLoading = false;
                    this.closeModal();
                    alert('Se ha creado exitosamente');
                    this.fetchEmpleados();
                },
                error: (err) => {
                    console.error(err);
                    alert('Error al guardar. Revisa la consola.');
                    this.isLoading = false;
                }
            });
        }
    }

    nuevoEmpleado(): void {
        this.openModal();
    }

    editarEmpleado(empleado: Empleado): void {
        this.openModal(empleado);
    }


    eliminarEmpleado(id: number | null): void { 
    if (!id) return;
    if (confirm('¿Eliminar permanentemente?')) {
        this.isLoading = true;
        this.empleadoService.deleteEmpleado(id).subscribe({
            next: () => {
                this.fetchEmpleados(); 
                alert('Empleado eliminado exitosamente');
            },
            error: () => { 
                alert('Error al eliminar'); 
                this.isLoading = false; 
            }
        });
    }
}


eliminarSuave(empleado: Empleado): void {
    if (!empleado.id) return;
    if (confirm(`¿Desactivar a ${empleado.nombres}?`)) {
        const empleadoOff = { ...empleado, estado: 0 };
        this.isLoading = true;
        this.empleadoService.putEmpleado(empleado.id, empleadoOff).subscribe({
            next: () => {
                this.fetchEmpleados();
                alert('Empleado desactivado exitosamente');
            },
            error: () => { alert('Error al desactivar'); this.isLoading = false; }
        });
    }
}
}