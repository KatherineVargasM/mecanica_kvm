import { Component } from '@angular/core';
export interface Empleado {
    id: number;
    cedula: string;
    nombres: string;
    apellidos: string;
    correo?: string;
    telefono?: string;
    cargo: string;
    estado: number;
}