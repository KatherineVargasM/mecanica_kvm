import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ActivatedRoute } from '@angular/router';
import { FormsModule } from '@angular/forms'; 
import { ServicioService } from '../../services/servicio'; 

export interface Usuario {
    nombre_usuario: string; 
}

export interface Vehiculo {
    marca: string; 
    modelo: string; 
}

export interface Servicio {
    id: number;
    id_vehiculo: number;
    id_usuario: number;
    fecha_servicio: string;
    vehiculo?: Vehiculo; 
    usuario?: Usuario; 
    descripcion: string; 
    costo: number; 
}


@Component({
    selector: 'app-servicios', 
    standalone: true,
    imports: [CommonModule, FormsModule], 
    templateUrl: './servicio.html',
    styleUrls: [
        './servicio.css' 
    ] 
})
export class ServiciosComponent implements OnInit {
    servicios: Servicio[] = [];
    isLoading: boolean = false;
    errorMessage: string | null = null;
    
    isModalOpen: boolean = false;
    modalTitle: string = '';
    
    currentServicio: Servicio = this.getNewServicio(); 

    constructor(
        private route: ActivatedRoute,
        private servicioService: ServicioService 
    ) { }
    
    getNewServicio(): Servicio {
        return {
            id: 0,
            id_vehiculo: 0,
            id_usuario: 0,
            fecha_servicio: new Date().toISOString(),
            descripcion: '',
            costo: 0,
            vehiculo: { marca: '', modelo: '' },
            usuario: { nombre_usuario: '' }
        };
    }

    ngOnInit(): void {
        this.loadServiciosFromResolver();
    }
    
    loadServiciosFromResolver(): void {
        const resolvedData = this.route.snapshot.data['serviciosData'];
        
        if (resolvedData && resolvedData.length > 0) {
            this.servicios = resolvedData;
        } else {
            this.errorMessage = 'Hubo un error al recuperar los datos de servicios o la lista está vacía.';
        }
    }

    fetchServicios(): void {
        this.isLoading = true;
        this.servicioService.getServicios().subscribe({
            next: (data) => {
                this.servicios = data;
                this.isLoading = false;
                this.errorMessage = (data.length === 0) ? 'No se encontraron servicios registrados.' : null;
            },
            error: (err) => {
                console.error('Error al cargar servicios:', err);
                this.errorMessage = 'No se pudieron cargar los servicios.';
                this.isLoading = false;
            }
        });
    }

    closeModal(): void {
        this.isModalOpen = false;
        setTimeout(() => {
            this.currentServicio = this.getNewServicio();
        }, 200);
    }
    
    openModal(servicio?: Servicio): void {
        this.isModalOpen = true;

        if (servicio && servicio.id !== 0) {
            this.modalTitle = 'Editar Servicio';
            
            this.currentServicio = { 
                id: servicio.id,
                id_vehiculo: servicio.id_vehiculo || 0,
                id_usuario: servicio.id_usuario || 0,
                fecha_servicio: servicio.fecha_servicio || new Date().toISOString(),
                descripcion: servicio.descripcion || '',
                costo: servicio.costo || 0,
            }; 
        } else {
            this.modalTitle = 'Nuevo Servicio';
            this.currentServicio = this.getNewServicio();
        }
    }
    
    nuevoServicio(): void {
        this.openModal();
    }

    editarServicio(servicio: Servicio): void {
        this.openModal(servicio);
    }

    guardarServicio(): void {
        if (!this.currentServicio.id_vehiculo || !this.currentServicio.id_usuario) {
            alert('Por favor complete los campos ID Vehículo e ID Cliente.');
            return;
        }

        this.isLoading = true;
        
        const servicioPayload = {
    id: this.currentServicio.id,
    id_vehiculo: this.currentServicio.id_vehiculo || 0,
    id_usuario: this.currentServicio.id_usuario || 0,
    fecha_servicio: this.currentServicio.fecha_servicio || new Date().toISOString(), 
    descripcion: this.currentServicio.descripcion || '',
    costo: this.currentServicio.costo || 0,
};
console.log('Payload enviado:', servicioPayload);

        if (servicioPayload.id && servicioPayload.id !== 0) {
            this.servicioService.putServicio(servicioPayload.id, servicioPayload).subscribe({
                next: (response) => {
                    this.isLoading = false;
                    this.closeModal();
                    alert('Servicio editado exitosamente');
                    this.fetchServicios(); 
                },
                error: (err) => {
                    console.error(err);
                    alert('Error al editar el servicio. Revisa la consola.');
                    this.isLoading = false;
                }
            });
        } else {
            this.servicioService.postServicio(servicioPayload).subscribe({
                next: (response) => {
                    this.isLoading = false;
                    this.closeModal();
                    alert('Servicio creado exitosamente');
                    this.fetchServicios(); 
                },
                error: (err) => {
                    console.error(err);
                    alert('Error al crear el servicio. Revisa la consola.');
                    this.isLoading = false;
                }
            });
        }
    }

    eliminarServicio(id: number): void {
        if (confirm(`¿Está seguro de eliminar permanentemente el Servicio con ID ${id}?`)) {
            this.isLoading = true;
            this.servicioService.deleteServicio(id).subscribe({
                next: () => {
                    this.fetchServicios(); 
                    alert('Servicio eliminado exitosamente');
                },
                error: () => { 
                    alert('Error al eliminar el servicio'); 
                    this.isLoading = false; 
                }
            });
        }
    }
}