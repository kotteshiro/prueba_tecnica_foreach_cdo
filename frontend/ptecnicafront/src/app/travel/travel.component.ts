import { HttpClient, HttpClientModule } from '@angular/common/http';
import { Component, Input, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { provideNativeDateAdapter } from '@angular/material/core';
// import { MatSlideToggleModule } from '@angular/material/slide-toggle';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatIconModule } from '@angular/material/icon';
import { MatSelectModule } from '@angular/material/select';
import { MatInputModule } from '@angular/material/input';
// import { MatRadioModule } from '@angular/material/radio';
import { MatCheckboxModule } from '@angular/material/checkbox';
import { MatDatepickerModule } from '@angular/material/datepicker';
// import {MatDividerModule} from '@angular/material/divider';
import {MatButtonModule} from '@angular/material/button';
import { Router, RouterLink } from '@angular/router';
import { API_CONFIG } from '../app.config';

import { MatSnackBar} from '@angular/material/snack-bar';

interface TransporteInterface {
  id: number;
  label: string;
  co2: number;
}

@Component({
  selector: 'app-travel',
  standalone: true,
  providers: [provideNativeDateAdapter()], // Fix locale
  imports: [
    RouterLink,
    CommonModule,
    ReactiveFormsModule,
    // MatSlideToggleModule,
    MatCheckboxModule,
    // MatRadioModule,
    MatFormFieldModule,
    MatInputModule,
    MatSelectModule,
    MatIconModule,
    MatDatepickerModule,
    MatButtonModule,
    // MatDividerModule,
    HttpClientModule],
  templateUrl: './travel.component.html',
  styleUrl: './travel.component.css'
})
export class TravelComponent {
  snackBarRef = inject(MatSnackBar);
  @Input() id:number =-1;
  router = inject(Router);
  formulario = new FormGroup({
    id: new FormControl(-1),
    addrStart: new FormControl(''),
    addrEnd: new FormControl(''),
    transport: new FormControl(-1),
    traveldate: new FormControl(''),
    distance: new FormControl(''),
    workerName: new FormControl(''),
    isRoundTrip: new FormControl(false)
  })
  trasportList: TransporteInterface[] = [];
  client = inject(HttpClient);
  carbonFootPrint:number = 0;
  ngOnInit(): void {
    this.fetchData();
    if(this.id >=0 ){
      this.loadTravel(this.id );
    }
  }
  fetchData() {
    this.client.get(API_CONFIG.api_url + "transportes").subscribe((data: any) => {
      console.log(data)
      this.trasportList = data;
    }
    )
  }
  saveTravel(){
    this.client.post(API_CONFIG.api_url + "traslado", this.formulario.value).subscribe((data: any) => {
      if(data.id == this.id){
        this.snackBarRef.open('Guardado', '', {
          duration: 3000
        });
        this.loadTravel(data.id);
      }else if((!this.id || this.id<0)  && data.id >= 0){
        this.snackBarRef.open('Nuevo Registro de viaje #'+data.id, '', {
          duration: 3000
        });
      }
      this.router.navigate(["traslado",data.id])
    }
    )
  }
  loadTravel(id:number){
    this.client.get(API_CONFIG.api_url + "traslado/"+id).subscribe((data: any) => {
      if(data.id !=  id){
        console.error("Cargando id incorrecto");
        return;
      }
      console.log(data)
      this.formulario.patchValue({
        "id": data.id,
        "addrStart": data.dire_partida,
        "addrEnd": data.dire_termino,
        "transport" : data.transporte_id.toString(),
        "traveldate" : data.fecha!='' && data.fecha!='0000-00-00' ? new Date(data.fecha)!.toISOString().slice(0, -1) : '',
        "distance" : data.distancia_km,
        "workerName" : data.trabajador,
        "isRoundTrip" : data.ida_vuelta
      });
      this.carbonFootPrint = data.co2footprint;
      window.scroll({ top: 0});
    }
    )
  }
  deletethis(){
    let confirma = confirm("¿Está seguro que desea eliminar el registro de viaje #"+this.id+"?");
    if (confirma){
      this.client.delete(API_CONFIG.api_url + "traslado/" +this.id).subscribe((data: any) => {
        if(data.deleted == this.id){
          this.snackBarRef.open('Eliminado #'+this.id, '', {
            duration: 3000
          });
          this.router.navigate(["traslados"])
        }else{
          alert("ha ocurrido un error eliminando #"+this.id);
        }
      })
    }else{
      console.log("no borra");
      window.scroll({ top: 0});
    }
  }
}
