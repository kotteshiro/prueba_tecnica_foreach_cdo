import { Component, inject } from '@angular/core';
import {MatTableModule} from '@angular/material/table';
import {MatButtonModule} from '@angular/material/button';
import {MatIconModule} from '@angular/material/icon';
import { RouterModule, RouterOutlet } from '@angular/router';
import { CommonModule } from '@angular/common';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { API_CONFIG } from '../app.config';

interface Travel {
  id: number,
  dire_partida: string,
  dire_termino: string,
  distancia_km: string,
  transporte_id: number,
  trabajador: string,
  ida_vuelta: boolean,
}

@Component({
  selector: 'app-travel-list',
  standalone: true,
  imports: [RouterOutlet, RouterModule,MatTableModule,CommonModule, HttpClientModule, MatButtonModule,MatIconModule],
  templateUrl: './travel-list.component.html',
  styleUrl: './travel-list.component.css'
})

export class TravelListComponent {
  client = inject(HttpClient);
  displayedColumns: string[] = ['id', 'dire_partida', 'dire_termino', 'distancia_km', 'trabajador', 'actions'];
  traveldata:Travel[] = [];
  fetchData() {
    this.client.get(API_CONFIG.api_url + "traslados").subscribe((data: any) => {
      console.log(data)
      this.traveldata = data;
    }
    )
  }
  ngOnInit(): void {
    this.fetchData();
  }
}
