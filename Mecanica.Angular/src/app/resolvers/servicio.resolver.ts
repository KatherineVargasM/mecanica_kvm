import { inject } from '@angular/core';
import { ResolveFn } from '@angular/router';
import { ServicioService } from '../services/servicio';
import { Servicio } from '../models/servicio/servicio';
import { catchError, of } from 'rxjs';

export const servicioResolver: ResolveFn<Servicio[]> = (route, state) => {
    const servicioService = inject(ServicioService);
    return servicioService.getServicios().pipe(
        catchError(() => {
            console.error('Failed to resolve services data.');
            return of([]);
        })
    );
};