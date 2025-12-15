import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Servicio } from '../models/servicio/servicio';


@Injectable({
    providedIn: 'root'
})
export class ServicioService {
    private apiUrl = "https://localhost:7120/api/servicio";

    constructor(private http: HttpClient) { }

    getServicios(): Observable<Servicio[]> {
        return this.http.get<Servicio[]>(this.apiUrl);
    }

    getServicio(id: number): Observable<Servicio> {
        return this.http.get<Servicio>(`${this.apiUrl}/${id}`);
    }

    postServicio(servicio: Servicio): Observable<Servicio> {
        return this.http.post<Servicio>(this.apiUrl, servicio);
    }

    putServicio(id: number, servicio: Servicio): Observable<any> {
        return this.http.put(`${this.apiUrl}/${id}`, servicio);
    }

    deleteServicio(id: number): Observable<any> {
        return this.http.delete(`${this.apiUrl}/${id}`);
    }
}