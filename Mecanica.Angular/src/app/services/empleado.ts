import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Empleado } from '../models/empleado/empleado';

@Injectable({
    providedIn: 'root'
})

export class EmpleadoService {
    private apiUrl = "https://localhost:7120/api/empleado";

    constructor(private http: HttpClient) { }

    getEmpleados(): Observable<Empleado[]> {
        return this.http.get<Empleado[]>(this.apiUrl);
    }

    getEmpleado(id: number): Observable<Empleado> {
        return this.http.get<Empleado>(`${this.apiUrl}/${id}`);
    }

    postEmpleado(empleado: Empleado): Observable<Empleado> {
        return this.http.post<Empleado>(this.apiUrl, empleado);
    }

    putEmpleado(id: number, empleado: Empleado): Observable<any> {
        return this.http.put(`${this.apiUrl}/${id}`, empleado);
    }

    deleteEmpleado(id: number): Observable<any> {
        return this.http.delete(`${this.apiUrl}/${id}`);
    }
}