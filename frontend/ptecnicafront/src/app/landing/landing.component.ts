import { Component } from '@angular/core';
import { CompanyCarbonFootprintComponent } from '../company-carbon-footprint/company-carbon-footprint.component';

@Component({
  selector: 'app-landing',
  standalone: true,
  imports: [CompanyCarbonFootprintComponent],
  templateUrl: './landing.component.html',
  styleUrl: './landing.component.css'
})
export class LandingComponent {

}
