import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';
@Component({
  selector: 'app-travel',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './travel.component.html',
  styleUrl: './travel.component.css'
})
export class TravelComponent {
  formulario = new FormGroup({
    addrStart: new FormControl(''),
    addrEnd: new FormControl(''),
    transport: new FormControl(''),
    date: new FormControl(''),
    distance: new FormControl(''),
    workerName: new FormControl(''),
    isRoundTrip: new FormControl('')
  })
}
