import { inject } from '@angular/core';
import { ResolveFn } from '@angular/router';
import { EmpleadoService } from '../services/empleado';
import { Empleado } from '../models/empleado/empleado';
import { catchError, of } from 'rxjs';

export const empleadoResolver: ResolveFn<Empleado[]> = (route, state) => {
    const empleadoService = inject(EmpleadoService);
    return empleadoService.getEmpleados().pipe(
        catchError(() => {
            console.error('Failed to resolve employees data.');
            return of([]);
        })
    );
};