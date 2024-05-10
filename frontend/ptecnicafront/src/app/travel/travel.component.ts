import { HttpClient, HttpClientModule } from '@angular/common/http';
import { Component, inject } from '@angular/core';
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

interface TransporteInterface {
  value: string;
  label: string;
}

@Component({
  selector: 'app-travel',
  standalone: true,
  providers: [provideNativeDateAdapter()],
  imports: [
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
  formulario = new FormGroup({
    addrStart: new FormControl(''),
    addrEnd: new FormControl(''),
    transport: new FormControl(''),
    traveldate: new FormControl(''),
    distance: new FormControl(''),
    workerName: new FormControl(''),
    isRoundTrip: new FormControl('')
  })
  transportes: TransporteInterface[] = [
    {value: 'steak-0', label: 'Steak'},
    {value: 'pizza-1', label: 'Pizza'},
    {value: 'tacos-2', label: 'Tacos'},
  ];

  ammount: TransporteInterface[] = [];
  client = inject(HttpClient);
  ngOnInit(): void {
    this.fetchData();
  }
  fetchData() {
    this.client.get("http://localhost/company-carbon-footprint").subscribe((data: any) => {
      console.log(data)
      this.ammount = data;
    }
    )
  }
}
